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

        $user_row = $this->User_model->get_by_id($user_id);
        $user = $this->normalize_user($user_row);
        
        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
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
        $user_row = $this->User_model->get_by_id($user_id);
        $user = $this->normalize_user($user_row);

        $data = [
            'title' => 'Edit Profil',
            'user' => $user
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
        
        $user_row = $this->User_model->get_by_id($user_id);
        $user = $this->normalize_user($user_row);

    // Avatar preset selections
    $available_avatars = ['avatar:girl', 'avatar:boy', 'avatar:cat', 'avatar:dog', 'avatar:fox', 'avatar:panda', 'avatar:flower', 'avatar:flower_pink', 'avatar:flower_blue', 'avatar:flower_yellow', 'avatar:butterfly', 'avatar:bunny', 'avatar:robot'];
        $avatar_choice = $this->input->post('avatar_choice');
        $use_avatar = in_array($avatar_choice, $available_avatars, true);
        
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
                if ($foto && strpos($foto, 'avatar:') !== 0 && file_exists('./uploads/users/' . $foto)) {
                    unlink('./uploads/users/' . $foto);
                }
                $foto = $this->upload->data('file_name');
            }
        }

        // Use preset avatar if selected and no new upload
        if (empty($_FILES['foto']['name']) && $use_avatar) {
            if ($foto && strpos($foto, 'avatar:') !== 0 && file_exists('./uploads/users/' . $foto)) {
                unlink('./uploads/users/' . $foto);
            }
            $foto = $avatar_choice;
        }
        
        $data = [
            'nama_lengkap' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'foto_profil' => $foto
        ];
        
        // Update password if provided
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        if ($this->User_model->update($user_id, $data)) {
            // Refresh session info so dashboard/avatar uses latest data
            $this->session->set_userdata([
                'nama' => $data['nama_lengkap'],
                'email' => $data['email'],
                'foto' => $foto,
                'foto_profil' => $foto,
            ]);
            $this->session->set_flashdata('success', 'Profil berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate profil');
        }
        
        redirect('profil');
    }

    private function normalize_user($row) {
        if (!$row) {
            return [
                'nama' => '',
                'email' => '',
                'foto' => null,
            ];
        }

        return [
            'nama' => $row['nama'] ?? ($row['nama_lengkap'] ?? ($row['username'] ?? '')),
            'email' => $row['email'] ?? '',
            'foto' => $row['foto'] ?? ($row['foto_profil'] ?? null),
        ];
    }
}
