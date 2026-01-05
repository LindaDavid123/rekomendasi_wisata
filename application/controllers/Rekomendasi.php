<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rekomendasi Controller
 * Sistem rekomendasi hybrid (collaborative + item-based filtering)
 */
class Rekomendasi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('recommendation_model');
        $this->load->model('wisata_model');
        
        // Check if logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Rekomendasi Untuk Anda';
        $data['page'] = 'rekomendasi';
        
        // Check user rating count
        $this->load->model('rating_model');
        $user_rating_count = $this->rating_model->count_user_ratings($user_id);
        $data['user_rating_count'] = $user_rating_count;
        
        if ($user_rating_count > 0) {
            // User has ratings, use hybrid recommendations with cosine similarity
            $data['recommendations'] = $this->recommendation_model->get_hybrid_recommendations($user_id, 12);
            $data['collaborative'] = $this->recommendation_model->get_collaborative_recommendations($user_id, 6);
            $data['item_based'] = $this->recommendation_model->get_item_based_recommendations($user_id, 6);
            $data['is_new_user'] = false;
            
            // If no recommendations generated, show popular
            if (empty($data['recommendations'])) {
                $data['recommendations'] = $this->wisata_model->get_popular(12);
            }
        } else {
            // New user, show popular wisata
            $data['recommendations'] = $this->wisata_model->get_popular(12);
            $data['collaborative'] = [];
            $data['item_based'] = [];
            $data['is_new_user'] = true;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('rekomendasi/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Endpoint AJAX: Get real-time recommendations for user
     */
    public function get_realtime() {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        $user_id = $this->session->userdata('user_id');
        $recommendations = $this->recommendation_model->get_hybrid_recommendations($user_id, 10);
        echo json_encode(['recommendations' => $recommendations]);
    }
}
