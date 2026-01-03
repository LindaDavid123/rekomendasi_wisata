<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorit_model extends CI_Model {

    private $table = 'favorit';

    public function is_favorite($user_id, $wisata_id) {
        return $this->db->where([
            'user_id'   => $user_id,
            'wisata_id' => $wisata_id
        ])->count_all_results($this->table) > 0;
    }

    public function add_favorite($user_id, $wisata_id) {
        return $this->db->insert($this->table, [
            'user_id'   => $user_id,
            'wisata_id' => $wisata_id
        ]);
    }

    public function remove_favorite($user_id, $wisata_id) {
        return $this->db->delete($this->table, [
            'user_id'   => $user_id,
            'wisata_id' => $wisata_id
        ]);
    }

    public function get_user_favorites($user_id) {
        $this->db->select('wisata.*');
        $this->db->from($this->table);
        $this->db->join('wisata', 'wisata.id = favorit.wisata_id');
        $this->db->where('favorit.user_id', $user_id);
        $this->db->order_by('favorit.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}
