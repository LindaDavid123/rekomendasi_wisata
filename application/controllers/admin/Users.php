<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Users Management Controller
 */
class Users extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        
        // Check admin login (hanya session admin)
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');
        }
    }
    
    public function index() {
        $config['base_url'] = base_url('admin/users/index');
        $config['total_rows'] = $this->User_model->count_all();
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        
        // Bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $data = [
            'title' => 'Kelola Users',
            'users' => $this->User_model->get_all($config['per_page'], $page),
            'pagination' => $this->pagination->create_links()
        ];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function detail($id) {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }
        
        $this->load->model('Rating_model');
        $this->load->model('Review_model');
        $this->load->model('Favorit_model');
        
        $data = [
            'title' => 'Detail User - ' . $user['nama'],
            'user' => $user,
            'statistics' => $this->User_model->get_statistics($id),
            'recent_ratings' => $this->Rating_model->get_user_ratings($id, 5),
            'recent_reviews' => $this->Review_model->get_user_reviews($id)
        ];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/detail', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function toggle_role($id) {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan');
            redirect('admin/users');
            return;
        }
        
        // Toggle role
        $new_role = ($user['role'] == 'admin') ? 'user' : 'admin';
        
        if ($this->User_model->update($id, ['role' => $new_role])) {
            $this->session->set_flashdata('success', 'Role user berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah role user');
        }
        
        redirect('admin/users');
    }
    
    public function delete($id) {
        // Prevent deleting self
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri');
            redirect('admin/users');
            return;
        }
        
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }
        
        // Delete user foto if exists
        if ($user['foto'] && file_exists('./uploads/users/' . $user['foto'])) {
            unlink('./uploads/users/' . $user['foto']);
        }
        
        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }
        
        redirect('admin/users');
    }
}
