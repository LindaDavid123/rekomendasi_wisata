<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller
 * Landing page untuk visitor
 */
class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('wisata_model');
        $this->load->helper('url');
    }
    
    /**
     * Landing Page - untuk visitor (belum login)
     */
    public function index() {
        // Jika sudah login
        if ($this->session->userdata('user_id')) {
            // Jika admin, redirect ke admin dashboard
            if ($this->session->userdata('role') == 'admin') {
                redirect('admin/dashboard');
            } else {
                // Jika user biasa, redirect ke user dashboard
                redirect('dashboard');
            }
        }
        
        $data['title'] = 'Beranda - Rekomendasi Wisata Jogja';
        $data['page'] = 'home';
        
        // Get statistics untuk landing page
        $data['statistics'] = [
            'total_wisata' => $this->wisata_model->count_all(),
            'total_users' => $this->db->count_all('users'),
            'total_reviews' => $this->db->count_all('reviews'),
            'total_ratings' => $this->db->count_all('rating')
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function search() {
        $keyword = $this->input->get('q');
        $data['title'] = 'Pencarian: ' . $keyword;
        $data['keyword'] = $keyword;
        $data['results'] = $this->wisata_model->search($keyword);
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/search', $data);
        $this->load->view('templates/footer');
    }
}
