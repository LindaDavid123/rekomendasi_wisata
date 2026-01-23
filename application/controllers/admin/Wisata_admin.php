<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Wisata Management Controller
 */
class Wisata_admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Wisata_model');
        $this->load->library('upload');
        
        // Check admin login
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $config['base_url'] = base_url('admin/wisata_admin/index');
        $config['total_rows'] = $this->Wisata_model->count_all();
        $config['per_page'] = 10;
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
            'title' => 'Kelola Wisata',
            'wisata_list' => $this->Wisata_model->get_all($config['per_page'], $page),
            'pagination' => $this->pagination->create_links()
        ];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/wisata/index', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function create() {
        $data = ['title' => 'Tambah Wisata'];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/wisata/create', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function store() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->create();
            return;
        }
        
        // Upload foto
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/wisata/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'wisata_' . time();
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            }
        }
        
        $data = [
            'nama' => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
            'lokasi' => $this->input->post('lokasi'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'jam_buka' => $this->input->post('jam_buka'),
            'jam_tutup' => $this->input->post('jam_tutup'),
            'foto' => $foto
        ];
        
        if ($this->Wisata_model->create($data)) {
            $this->session->set_flashdata('success', 'Wisata berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan wisata');
        }
        
        redirect('admin/wisata_admin');
    }
    
    public function edit($id) {
        $data = [
            'title' => 'Edit Wisata',
            'wisata' => $this->Wisata_model->get_by_id($id)
        ];
        
        if (!$data['wisata']) {
            show_404();
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/wisata/edit', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function update($id) {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }
        
        $wisata = $this->Wisata_model->get_by_id($id);
        if (!$wisata) {
            show_404();
        }
        
        // Upload foto if provided
        $foto = $wisata['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/wisata/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'wisata_' . time();
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto')) {
                // Delete old foto
                if ($foto && file_exists('./uploads/wisata/' . $foto)) {
                    unlink('./uploads/wisata/' . $foto);
                }
                $foto = $this->upload->data('file_name');
            }
        }
        
        $data = [
            'nama' => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
            'lokasi' => $this->input->post('lokasi'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'jam_buka' => $this->input->post('jam_buka'),
            'jam_tutup' => $this->input->post('jam_tutup'),
            'foto' => $foto
        ];
        
        if ($this->Wisata_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Wisata berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate wisata');
        }
        
        redirect('admin/wisata_admin');
    }
    
    public function delete($id) {
        $wisata = $this->Wisata_model->get_by_id($id);
        
        if (!$wisata) {
            show_404();
        }
        
        // Delete foto
        if ($wisata['foto'] && file_exists('./uploads/wisata/' . $wisata['foto'])) {
            unlink('./uploads/wisata/' . $wisata['foto']);
        }
        
        if ($this->Wisata_model->delete($id)) {
            $this->session->set_flashdata('success', 'Wisata berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus wisata');
        }
        
        redirect('admin/wisata_admin');
    }
    
    /**
     * Import wisata dari CSV
     */
    public function import() {
        $data = ['title' => 'Import Wisata CSV'];
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/wisata/import', $data);
        $this->load->view('templates/admin_footer');
    }
    
    public function process_import() {
        if (!empty($_FILES['csv_file']['name'])) {
            $config['upload_path'] = './uploads/temp/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 2048;
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('csv_file')) {
                $file_data = $this->upload->data();
                $file_path = $file_data['full_path'];
                
                // Read CSV
                $handle = fopen($file_path, 'r');
                $header = fgetcsv($handle); // Skip header
                
                $imported = 0;
                while (($row = fgetcsv($handle)) !== FALSE) {
                    $data = [
                        'nama' => $row[0],
                        'kategori' => $row[1],
                        'deskripsi' => $row[2],
                        'harga' => $row[3],
                        'lokasi' => $row[4],
                        'latitude' => $row[5] ?? null,
                        'longitude' => $row[6] ?? null,
                        'jam_buka' => $row[7] ?? null,
                        'jam_tutup' => $row[8] ?? null,
                        'foto' => $row[9] ?? null
                    ];
                    
                    if ($this->Wisata_model->create($data)) {
                        $imported++;
                    }
                }
                
                fclose($handle);
                unlink($file_path); // Delete temp file
                
                $this->session->set_flashdata('success', "Berhasil mengimport $imported wisata");
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        } else {
            $this->session->set_flashdata('error', 'File CSV tidak dipilih');
        }
        
        redirect('admin/wisata_admin/import');
    }
}
