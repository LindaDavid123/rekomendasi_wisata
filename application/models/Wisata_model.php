<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Wisata Model
 * Handle wisata/tourism data
 */
class Wisata_model extends CI_Model
{

    private $table = 'wisata';

    public function get_all($limit = null, $offset = null)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    /**
     * Get multiple wisata by IDs
     * Used for Python API recommendations
     */
    public function get_by_ids($ids)
    {
        if (empty($ids)) {
            return [];
        }

        $this->db->where_in('id', $ids);
        $results = $this->db->get($this->table)->result_array();

        // Maintain order from input IDs
        $ordered = [];
        $indexed = [];
        foreach ($results as $row) {
            $indexed[$row['id']] = $row;
        }
        foreach ($ids as $id) {
            if (isset($indexed[$id])) {
                $ordered[] = $indexed[$id];
            }
        }

        return $ordered;
    }

    public function get_popular($limit = 10)
    {
        $this->db->order_by('rating_avg', 'DESC');
        $this->db->order_by('jumlah_rating', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }

    public function get_newest($limit = 10)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_category($category, $limit = null)
    {
        $this->db->where('kategori', $category);
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function get_categories()
    {
        $this->db->distinct();
        $this->db->select('kategori');
        $this->db->order_by('kategori', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_all_filtered($limit, $offset, $kategori = null, $harga = null, $search = null, $sort = 'terbaru')
    {
        // Filter by category
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }

        // Filter by price
        if ($harga) {
            $this->db->where('harga_tiket', $harga);
        }

        // Search
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('deskripsi', $search);
            $this->db->or_like('alamat', $search);
            $this->db->group_end();
        }

        // Sorting
        switch ($sort) {
            case 'rating':
                $this->db->order_by('rating_avg', 'DESC');
                break;
            case 'nama':
                $this->db->order_by('nama', 'ASC');
                break;
            case 'harga_murah':
                $this->db->order_by('harga_tiket', 'ASC');
                break;
            case 'harga_mahal':
                $this->db->order_by('harga_tiket', 'DESC');
                break;
            default:
                $this->db->order_by('created_at', 'DESC');
        }

        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }

    public function count_all_filtered($kategori = null, $harga = null, $search = null)
    {
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }

        if ($harga) {
            $this->db->where('harga_tiket', $harga);
        }

        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('deskripsi', $search);
            $this->db->or_like('alamat', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function search($keyword)
    {
        $this->db->like('nama', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('kategori', $keyword);
        return $this->db->get($this->table)->result_array();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function update_rating($wisata_id)
    {
        $this->db->select('AVG(rating) as avg_rating, COUNT(*) as count');
        $this->db->where('wisata_id', $wisata_id);
        $result = $this->db->get('rating')->row_array();

        $data = [
            'rating_avg'    => round($result['avg_rating'], 2),
            'jumlah_rating' => $result['count'],
        ];

        return $this->db->update($this->table, $data, ['id' => $wisata_id]);
    }
}
