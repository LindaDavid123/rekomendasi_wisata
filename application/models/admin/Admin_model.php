<?php
class Admin_model extends CI_Model {
    private $table = 'users';

    public function create_admin($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = 'admin';
        // Email wajib
        if (!isset($data['email'])) $data['email'] = $data['username'];
        // Hilangkan field 'nama' jika ada
        if (isset($data['nama'])) unset($data['nama']);
        return $this->db->insert($this->table, $data);
    }

    public function get_by_username($username) {
        return $this->db->get_where($this->table, ['username' => $username, 'role' => 'admin'])->row_array();
    }

    public function verify_login($username, $password) {
        $admin = $this->get_by_username($username);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    public function get_count($table) {
        return $this->db->count_all($table);
    }

    public function get_rating_history() {
        return $this->db->order_by('created_at', 'DESC')->get('rating')->result_array();
    }
}
