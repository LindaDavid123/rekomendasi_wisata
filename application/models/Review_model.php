<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Review Model
 */
class Review_model extends CI_Model {
    
    private $table = 'reviews';
    
    public function get_by_wisata($wisata_id, $limit = null) {
        $this->db->select('reviews.*, users.username');
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->where('reviews.wisata_id', $wisata_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    public function save_review($user_id, $wisata_id, $review, $rating = 5) {
        // Pastikan rating mengikuti constraint 1-5 agar tidak gagal insert
        $rating = max(1, min(5, (int) $rating));

        $data = [
            'user_id' => $user_id,
            'wisata_id' => $wisata_id,
            'review' => $review,
            'rating' => $rating,
        ];
        
        return $this->db->insert($this->table, $data);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
    
    public function get_user_reviews($user_id) {
        $this->db->select('reviews.*, wisata.nama');
        $this->db->join('wisata', 'wisata.id = reviews.wisata_id');
        $this->db->where('reviews.user_id', $user_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
