<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Dashboard Controller
 */
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Wisata_model');
        $this->load->model('Rating_model');
        $this->load->model('Review_model');
        
        // Check admin login (hanya session admin)
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');
        }
    }
    
    public function index() {
        $data = [
            'title' => 'Dashboard Admin',
            'total_users' => $this->User_model->count_all(),
            'total_wisata' => $this->Wisata_model->count_all(),
            'total_ratings' => $this->db->count_all('rating'),
            'total_reviews' => $this->db->count_all('reviews'),
            'recent_users' => $this->User_model->get_all(5),
            'recent_wisata' => $this->Wisata_model->get_newest(5),
            'top_rated' => $this->Wisata_model->get_popular(5),
            'total_favorit' => $this->db->count_all('favorit')
        ];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_footer');
    }
    
    /**
     * Get statistics data for charts (AJAX)
     */
    public function get_statistics() {
        $type = $this->input->get('type');
        
        $result = [];
        
        switch ($type) {
            case 'ratings_per_month':
                $result = $this->get_ratings_per_month();
                break;
            case 'users_per_month':
                $result = $this->get_users_per_month();
                break;
            case 'popular_categories':
                $result = $this->get_popular_categories();
                break;
            default:
                $result = ['error' => 'Invalid type'];
        }
        
        echo json_encode($result);
    }
    
    private function get_ratings_per_month() {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total 
                FROM rating 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY month 
                ORDER BY month ASC";
        
        return $this->db->query($sql)->result_array();
    }
    
    private function get_users_per_month() {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total 
                FROM users 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY month 
                ORDER BY month ASC";
        
        return $this->db->query($sql)->result_array();
    }
    
    private function get_popular_categories() {
        $sql = "SELECT kategori, COUNT(*) as total 
                FROM wisata 
                GROUP BY kategori 
                ORDER BY total DESC";
        
        return $this->db->query($sql)->result_array();
    }
    
    /**
     * Endpoint AJAX: Get real-time statistics and recent users
     */
    public function get_stats() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        $recent_users_raw = $this->User_model->get_recent_users(5);
        $recent_users = array_map(function($user) {
            $user['created_at'] = date('d M Y H:i', strtotime($user['created_at']));
            return $user;
        }, $recent_users_raw);
        $stats = [
            'total_wisata' => $this->Wisata_model->count_all(),
            'total_users' => $this->User_model->count_all(),
            'total_ratings' => $this->db->count_all('rating'),
            'total_reviews' => $this->db->count_all('reviews'),
            'total_favorit' => $this->db->count_all('favorit'),
            'recent_users' => $recent_users,
        ];
        echo json_encode($stats);
    }
}
