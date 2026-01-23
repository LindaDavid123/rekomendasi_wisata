<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 * Dashboard untuk user yang sudah login
 */
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('wisata_model');
        $this->load->model('recommendation_model');
        $this->load->helper('url');
        
        // Protect: hanya user biasa yang login bisa akses (bukan admin)
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }
        
        // Jika admin, redirect ke admin dashboard
        if ($this->session->userdata('role') == 'admin') {
            redirect('admin/dashboard');
        }
    }
    
    /**
     * Dashboard - untuk user yang sudah login
     */
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Dashboard - Rekomendasi Wisata Jogja';
        $data['page'] = 'dashboard';
        
        // Get popular wisata
        $data['popular_wisata'] = $this->wisata_model->get_all();
        
        // Get newest wisata
        $data['newest'] = $this->wisata_model->get_newest(6);
        
        // Get categories
        $data['categories'] = $this->wisata_model->get_categories();
        
        // Get user's rating history
        $data['user_ratings'] = $this->db->where('user_id', $user_id)
                                         ->order_by('created_at', 'DESC')
                                         ->limit(10)
                                         ->join('wisata', 'wisata.id = rating.wisata_id', 'left')
                                         ->select('rating.rating, rating.created_at, wisata.nama as nama_wisata')
                                         ->get('rating')
                                         ->result_array();
        
        // Get recommendations for user (Item-Based Collaborative Filtering)
        $data['recommendations'] = $this->recommendation_model->get_hybrid_recommendations($user_id, 6);
        
        // Get statistics
        $data['statistics'] = [
            'total_wisata' => $this->wisata_model->count_all(),
            'total_users' => $this->db->count_all('users'),
            'total_reviews' => $this->db->count_all('reviews'),
            'total_ratings' => $this->db->count_all('rating')
        ];
        
        // Dashboard load full page (tanpa templates header/footer)
        $this->load->view('dashboard', $data);
    }
}
