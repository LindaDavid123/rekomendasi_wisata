<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Rekomendasi Controller
 * Sistem rekomendasi hybrid menggunakan Python Flask Microservice
 * KNN + Cosine Similarity
 */
class Rekomendasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('recommendation_model');
        $this->load->model('wisata_model');
        $this->load->helper('recommendation');

        // Check if logged in
        if (! $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        $data['title'] = 'Rekomendasi Untuk Anda';
        $data['page']  = 'rekomendasi';

        // Check user rating count
        $this->load->model('rating_model');
        $user_rating_count         = $this->rating_model->count_user_ratings($user_id);
        $data['user_rating_count'] = $user_rating_count;

        // Check if Python API is available
        $use_python_api           = check_recommendation_api();
        $data['using_python_api'] = $use_python_api;

        if ($user_rating_count > 0) {
            // User has ratings, get recommendations
            if ($use_python_api) {
                // Use Python Flask Microservice (KNN + Cosine Similarity)
                $recommendations = get_recommendations($user_id, 'hybrid', 5, 12, 0.6);

                if ($recommendations && ! empty($recommendations)) {
                    // Get wisata details from database
                    $wisata_ids              = array_column($recommendations, 'wisata_id');
                    $data['recommendations'] = $this->wisata_model->get_by_ids($wisata_ids);

                    // Add score to wisata data
                    foreach ($data['recommendations'] as &$wisata) {
                        foreach ($recommendations as $rec) {
                            if ($rec['wisata_id'] == $wisata['id']) {
                                $wisata['recommendation_score'] = $rec['score'];
                                $wisata['methods']              = isset($rec['methods']) ? $rec['methods'] : [];
                                break;
                            }
                        }
                    }

                    // Get separate recommendations for display
                    $collab  = get_recommendations($user_id, 'collaborative', 5, 6);
                    $content = get_recommendations($user_id, 'content_based', 10, 6);

                    $data['collaborative'] = $collab ? $this->wisata_model->get_by_ids(array_column($collab, 'wisata_id')) : [];
                    $data['item_based']    = $content ? $this->wisata_model->get_by_ids(array_column($content, 'wisata_id')) : [];
                } else {
                    // Fallback to old method if API fails
                    $data['recommendations']  = $this->recommendation_model->get_hybrid_recommendations($user_id, 12);
                    $data['collaborative']    = $this->recommendation_model->get_collaborative_recommendations($user_id, 6);
                    $data['item_based']       = $this->recommendation_model->get_item_based_recommendations($user_id, 6);
                    $data['using_python_api'] = false;
                }
            } else {
                // Use old PHP method as fallback
                $data['recommendations'] = $this->recommendation_model->get_hybrid_recommendations($user_id, 12);
                $data['collaborative']   = $this->recommendation_model->get_collaborative_recommendations($user_id, 6);
                $data['item_based']      = $this->recommendation_model->get_item_based_recommendations($user_id, 6);
            }

            $data['is_new_user'] = false;

            // If no recommendations generated, show popular
            if (empty($data['recommendations'])) {
                $data['recommendations'] = $this->wisata_model->get_popular(12);
            }
        } else {
            // New user, show popular wisata
            $data['recommendations'] = $this->wisata_model->get_popular(12);
            $data['collaborative']   = [];
            $data['item_based']      = [];
            $data['is_new_user']     = true;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('rekomendasi/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Endpoint AJAX: Get real-time recommendations for user
     */
    public function get_realtime()
    {
        if (! $this->session->userdata('user_id')) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $user_id = $this->session->userdata('user_id');

        // Try Python API first
        if (check_recommendation_api()) {
            $recommendations = get_recommendations($user_id, 'hybrid', 5, 10, 0.6);

            if ($recommendations) {
                $wisata_ids  = array_column($recommendations, 'wisata_id');
                $wisata_list = $this->wisata_model->get_by_ids($wisata_ids);

                echo json_encode([
                    'success'         => true,
                    'recommendations' => $wisata_list,
                    'method'          => 'python_api',
                ]);
                return;
            }
        }

        // Fallback to old method
        $recommendations = $this->recommendation_model->get_hybrid_recommendations($user_id, 10);
        echo json_encode([
            'success'         => true,
            'recommendations' => $recommendations,
            'method'          => 'php_fallback',
        ]);
    }

    /**
     * Refresh Python API cache
     */
    public function refresh_cache()
    {
        if (! $this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Unauthorized');
            redirect('dashboard');
        }

        $success = refresh_recommendation_cache();

        if ($success) {
            $this->session->set_flashdata('success', 'Cache rekomendasi berhasil di-refresh!');
        } else {
            $this->session->set_flashdata('error', 'Gagal refresh cache. Pastikan Python API running.');
        }

        redirect('rekomendasi');
    }

    /**
     * Get API statistics
     */
    public function stats()
    {
        if (! $this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $stats = get_recommendation_stats();

        echo json_encode([
            'success'    => true,
            'stats'      => $stats,
            'api_status' => check_recommendation_api() ? 'online' : 'offline',
        ]);
    }
}
