<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('favorit_model');
    }

    // halaman favorit saya
    public function index() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $user_id = $this->session->userdata('user_id');

        $data['title'] = 'Favorit Saya';
        $data['page']  = 'favorit';
        $data['favorites'] = $this->favorit_model->get_user_favorites($user_id);

        $this->load->view('templates/header', $data);
        $this->load->view('favorit/index', $data);
        $this->load->view('templates/footer');
    }

    // toggle favorit (AJAX)
    public function toggle() {
        if (!$this->session->userdata('user_id')) {
            echo json_encode([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ]);
            return;
        }

        $user_id   = $this->session->userdata('user_id');
        $wisata_id = $this->input->post('wisata_id');

        if ($this->favorit_model->is_favorite($user_id, $wisata_id)) {
            $this->favorit_model->remove_favorite($user_id, $wisata_id);
            echo json_encode([
                'success'   => true,
                'favorited' => false
            ]);
        } else {
            $this->favorit_model->add_favorite($user_id, $wisata_id);
            echo json_encode([
                'success'   => true,
                'favorited' => true
            ]);
        }
    }
}
