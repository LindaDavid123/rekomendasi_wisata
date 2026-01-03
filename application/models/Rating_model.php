<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rating Model
 */
class Rating_model extends CI_Model {
    
    private $table = 'rating';
    
    public function get_user_rating($user_id, $wisata_id) {
        return $this->db->get_where($this->table, [
            'user_id' => $user_id,
            'wisata_id' => $wisata_id
        ])->row_array();
    }
    
    public function count_user_ratings($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results($this->table);
    }
    
    public function get_average($wisata_id) {
        $this->db->select('AVG(rating) as avg_rating, COUNT(*) as total');
        $this->db->where('wisata_id', $wisata_id);
        return $this->db->get($this->table)->row_array();
    }
    
    public function save_rating($user_id, $wisata_id, $rating) {
        $existing = $this->get_user_rating($user_id, $wisata_id);
        
        $data = [
            'user_id' => $user_id,
            'wisata_id' => $wisata_id,
            'rating' => $rating
        ];
        
        if ($existing) {
            return $this->db->update($this->table, ['rating' => $rating], [
                'user_id' => $user_id,
                'wisata_id' => $wisata_id
            ]);
        } else {
            return $this->db->insert($this->table, $data);
        }
    }
    
    public function get_user_ratings($user_id) {
        $this->db->select('rating.*, wisata.nama, wisata.foto');
        $this->db->join('wisata', 'wisata.id = rating.wisata_id');
        $this->db->where('rating.user_id', $user_id);
        $this->db->order_by('rating.created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
