<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wisata Helper Functions
 */

if (!function_exists('format_rupiah')) {
    function format_rupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('get_wisata_image')) {
    function get_wisata_image($foto) {
        if ($foto && file_exists('./uploads/wisata/' . $foto)) {
            return base_url('uploads/wisata/' . $foto);
        }
        return base_url('assets/images/placeholder.jpg');
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image($foto) {
        if ($foto && file_exists('./uploads/users/' . $foto)) {
            return base_url('uploads/users/' . $foto);
        }
        return base_url('assets/images/user-placeholder.png');
    }
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }
}

if (!function_exists('get_star_rating')) {
    function get_star_rating($rating) {
        $html = '';
        $full_stars = floor($rating);
        $half_star = ($rating - $full_stars) >= 0.5 ? 1 : 0;
        $empty_stars = 5 - $full_stars - $half_star;
        
        // Full stars
        for ($i = 0; $i < $full_stars; $i++) {
            $html .= '<i class="fas fa-star text-warning"></i>';
        }
        
        // Half star
        if ($half_star) {
            $html .= '<i class="fas fa-star-half-alt text-warning"></i>';
        }
        
        // Empty stars
        for ($i = 0; $i < $empty_stars; $i++) {
            $html .= '<i class="far fa-star text-warning"></i>';
        }
        
        return $html;
    }
}

if (!function_exists('is_favorited')) {
    function is_favorited($wisata_id, $user_id = null) {
        $CI =& get_instance();
        
        // Jika user_id tidak diberikan, ambil dari session
        if ($user_id === null) {
            $user_id = $CI->session->userdata('user_id');
        }
        
        // Jika tidak ada user_id, return false
        if (!$user_id) {
            return false;
        }
        
        $CI->load->model('favorit_model');
        
        // Check apakah wisata ini ada di favorit user
        $CI->db->where('user_id', $user_id);
        $CI->db->where('wisata_id', $wisata_id);
        $result = $CI->db->get('favorit')->row();
        
        return $result ? true : false;
    }
}

if (!function_exists('get_user_rating')) {
    function get_user_rating($user_id, $wisata_id) {
        $CI =& get_instance();
        $CI->load->model('Rating_model');
        
        $CI->db->where('user_id', $user_id);
        $CI->db->where('wisata_id', $wisata_id);
        $result = $CI->db->get('rating')->row();
        
        return $result ? $result->rating : 0;
    }
}

if (!function_exists('truncate_text')) {
    function truncate_text($text, $length = 150) {
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }
}