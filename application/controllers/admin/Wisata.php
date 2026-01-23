<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wisata extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Wisata_model');
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/auth/login');
        }
    }
    public function index()
    {
        $wisata = $this->Wisata_model->get_all(15, 0);
        $data['wisata'] = is_array($wisata) ? $wisata : [];
        $this->load->view('admin/wisata', $data);
    }
    public function tambah() {
        if ($this->input->post()) {
            $data = $this->input->post();
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH.'assets/images/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];
                }
            }
            $this->Wisata_model->create($data);
            redirect('admin/wisata');
        }
        $this->load->view('admin/wisata/tambah');
    }
    public function edit($id) {
        if ($this->input->post()) {
            $data = $this->input->post();
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH.'assets/images/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data['foto'] = $upload_data['file_name'];
                }
            }
            $this->Wisata_model->update($id, $data);
            redirect('admin/wisata');
        }
        $data['wisata'] = $this->Wisata_model->get_by_id($id);
        $this->load->view('admin/wisata/edit', $data);
    }
    public function hapus($id) {
        $this->Wisata_model->delete($id);
        redirect('admin/wisata');
    }
}
