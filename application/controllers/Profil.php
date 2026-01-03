<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profil Controller
 */
class Profil extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Rating_model');
        $this->load->model('Review_model');
        $this->load->model('Favorit_model');
        $this->load->library('upload');
        
        // Check login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data = [
            'title' => 'Profil Saya',
            'user' => $this->User_model->get_by_id($user_id),
            'statistics' => $this->User_model->get_statistics($user_id),
            'recent_ratings' => $this->Rating_model->get_user_ratings($user_id, 10),
            'favorites' => $this->Favorit_model->get_user_favorites($user_id)
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('profil/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit() {
        $user_id = $this->session->userdata('user_id');
        
        $data = [
            'title' => 'Edit Profil',
            'user' => $this->User_model->get_by_id($user_id)
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('profil/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $this->edit();
            return;
        }
        
        $user = $this->User_model->get_by_id($user_id);
        
        // Upload foto if provided
        $foto = $user['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/users/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'user_' . $user_id . '_' . time();
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto')) {
                // Delete old foto
                if ($foto && file_exists('./uploads/users/' . $foto)) {
                    unlink('./uploads/users/' . $foto);
                }
                $foto = $this->upload->data('file_name');
            }
        }
        
        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'foto' => $foto
        ];
        
        // Update password if provided
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        if ($this->User_model->update($user_id, $data)) {
            $this->session->set_flashdata('success', 'Profil berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate profil');
        }
        
        redirect('profil');
    }
}
