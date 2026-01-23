<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Wisata Controller
 * Browse dan detail tempat wisata
 */
class Wisata extends CI_Controller
{

    public function __construct()
    {
        parent::__construct('url');
        $this->load->model('wisata_model');
        $this->load->model('rating_model');
        $this->load->model('review_model');
        $this->load->model('favorit_model');
    }

    public function index()
    {
        // Pagination config
        $this->load->library('pagination');

        $config['base_url']   = base_url('wisata/index');
        $config['total_rows'] = $this->wisata_model->count_all_filtered(
            $this->input->get('kategori'),
            $this->input->get('harga'),
            $this->input->get('search')
        );
        $config['per_page']    = 12;
        $config['uri_segment'] = 3;

        // Bootstrap 5 pagination style
        $config['full_tag_open']   = '<ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul>';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['attributes']      = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['title']       = 'Daftar Wisata';
        $data['page']        = 'wisata';
        $data['wisata_list'] = $this->wisata_model->get_all_filtered(
            $config['per_page'],
            $this->uri->segment(3),
            $this->input->get('kategori'),
            $this->input->get('harga'),
            $this->input->get('search'),
            $this->input->get('sort')
        );
        $data['categories'] = $this->wisata_model->get_categories();
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('wisata/index', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id)
    {
        $data['wisata'] = $this->wisata_model->get_by_id($id);

        if (! $data['wisata']) {
            show_404();
        }

        $data['title'] = $data['wisata']['nama'];
        $data['page']  = 'wisata_detail';

        // Get ratings and reviews
        $data['reviews']     = $this->review_model->get_by_wisata($id);
        $data['avg_rating']  = $this->rating_model->get_average($id);
        $data['user_rating'] = null;

        if ($this->session->userdata('user_id')) {
            $data['user_rating'] = $this->rating_model->get_user_rating(
                $this->session->userdata('user_id'),
                $id
            );
            $data['is_favorite'] = $this->favorit_model->is_favorite(
                $this->session->userdata('user_id'),
                $id
            );
        }

        // Get similar wisata - use Python API or fallback
        $this->load->helper('recommendation');
        $this->load->model('recommendation_model');

        if ($this->session->userdata('user_id')) {
            // Try Python API for content-based similarity
            if (check_recommendation_api()) {
                $similar = get_similar_wisata($id, 6);
                if ($similar && ! empty($similar)) {
                    $similar_ids = array_column($similar, 'wisata_id');
                    $this->load->model('wisata_model');
                    $data['similar_wisata'] = $this->wisata_model->get_by_ids($similar_ids);
                } else {
                    // Fallback to old method
                    $data['similar_wisata'] = $this->recommendation_model->get_item_based_recommendations($this->session->userdata('user_id'), 6);
                }
            } else {
                // Use old PHP method
                $data['similar_wisata'] = $this->recommendation_model->get_item_based_recommendations($this->session->userdata('user_id'), 6);
            }
        } else {
            // If not logged in, show popular wisata
            $this->load->model('wisata_model');
            $data['similar_wisata'] = $this->wisata_model->get_popular(6);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('wisata/detail', $data);
        $this->load->view('templates/footer');
    }

    public function submit_rating()
    {
        if (! $this->session->userdata('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }

        $wisata_id = $this->input->post('wisata_id');
        $rating    = $this->input->post('rating');
        $review    = $this->input->post('review');

        // Save rating
        $this->rating_model->save_rating(
            $this->session->userdata('user_id'),
            $wisata_id,
            $rating
        );

        // Save review if provided
        if (! empty($review)) {
            $this->review_model->save_review(
                $this->session->userdata('user_id'),
                $wisata_id,
                $review
            );
        }

        // Update wisata rating
        $this->wisata_model->update_rating($wisata_id);

        echo json_encode(['success' => true, 'message' => 'Rating berhasil disimpan']);
    }

    public function submit_review()
    {
        $this->output->set_content_type('application/json');

        if (! $this->session->userdata('user_id')) {
            $this->output->set_status_header(401);
            echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
            return;
        }

        $wisata_id = $this->input->post('wisata_id');
        $review    = trim((string) $this->input->post('review'));
        $rating    = $this->input->post('rating'); // optional, fallback ke 5

        if (empty($wisata_id) || $review === '') {
            $this->output->set_status_header(400);
            echo json_encode(['success' => false, 'message' => 'Ulasan tidak boleh kosong']);
            return;
        }

        // Pastikan destinasi wisata valid sebelum menyimpan ulasan
        $wisata = $this->wisata_model->get_by_id($wisata_id);
        if (! $wisata) {
            $this->output->set_status_header(404);
            echo json_encode(['success' => false, 'message' => 'Wisata tidak ditemukan']);
            return;
        }

        $saved = $this->review_model->save_review(
            $this->session->userdata('user_id'),
            $wisata_id,
            $review,
            $rating ?: 5
        );

        if (! $saved) {
            $this->output->set_status_header(500);
            echo json_encode(['success' => false, 'message' => 'Ulasan gagal disimpan']);
            return;
        }

        echo json_encode(['success' => true, 'message' => 'Ulasan berhasil dikirim']);
    }
}
