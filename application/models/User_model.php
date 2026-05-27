<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 * Handle user data and authentication
 */
class User_model extends CI_Model {
        public function get_recent_users($limit = 5) {
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit($limit);
            return $this->db->get($this->table)->result_array();
        }
    
    private $table = 'users';
    
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }
    
    public function get_by_username($username) {
        return $this->db->get_where($this->table, ['username' => $username])->row_array();
    }
    
    public function get_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row_array();
    }
    
    public function get_by_google_id($google_id) {
        return $this->db->get_where($this->table, ['google_id' => $google_id])->row_array();
    }
    
    public function login($username, $password) {
        $user = $this->db->get_where($this->table, [
            'username' => $username,
            'status' => 'active'
        ])->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function login_by_email($email, $password) {
        $user = $this->db->get_where($this->table, [
            'email' => $email,
            'status' => 'active'
        ])->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }
    
    public function update_last_login($id) {
        return $this->db->update($this->table, [
            'last_login' => date('Y-m-d H:i:s')
        ], ['id' => $id]);
    }
    
    public function link_google_account($user_id, $google_id, $foto = null) {
        $data = ['google_id' => $google_id];
        if ($foto) {
            $data['foto'] = $foto;
        }
        return $this->db->update($this->table, $data, ['id' => $user_id]);
    }
    
    public function get_all($limit = null, $offset = null) {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
    
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
    
    public function get_statistics($user_id) {
        $stats = [];
        
        // Total ratings
        $stats['total_ratings'] = $this->db->where('user_id', $user_id)->count_all_results('rating');
        
        // Total reviews
        $stats['total_reviews'] = $this->db->where('user_id', $user_id)->count_all_results('reviews');
        
        // Total favorites
        $stats['total_favorites'] = $this->db->where('user_id', $user_id)->count_all_results('favorit');
        
        return $stats;
    }
}
