<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admin_model');
    }
    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $admin = $this->Admin_model->verify_login($username, $password);
            if ($admin) {
                $this->session->set_userdata('admin_logged_in', true);
                $this->session->set_userdata('admin_id', $admin['id']);
                $this->session->set_userdata('admin_username', $admin['username']);
                redirect('admin/dashboard');
            } else {
                $data['error'] = 'Username atau password salah';
            }
        }
        $this->load->view('admin/login', isset($data) ? $data : []);
    }
    public function register() {
        if ($this->input->post()) {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'admin'
            ];
            $this->Admin_model->create_admin($data);
            redirect('admin/auth/login');
        }
        $this->load->view('admin/register');
    }
    public function logout() {
        $this->session->unset_userdata(['admin_logged_in', 'admin_id']);
        redirect('admin/auth/login');
    }
}
