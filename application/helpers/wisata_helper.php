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
        if ($foto) {
            // Check if foto is a URL (starts with http:// or https://)
            if (strpos($foto, 'http://') === 0 || strpos($foto, 'https://') === 0) {
                return $foto;
            }
            
            // Check if it's a file in /assets/images/
            $path = FCPATH . 'assets/images/' . $foto;
            if (file_exists($path)) {
                return base_url('assets/images/' . $foto);
            }
        }
        // Return random placeholder (boy.png or girl.png)
        $placeholders = ['boy.png', 'girl.png'];
        $placeholder = $placeholders[array_rand($placeholders)];
        return base_url('assets/images/' . $placeholder);
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image($foto = null, $nama_lengkap = '') {
        // Google OAuth profile picture (URL)
        if ($foto && (strpos($foto, 'http://') === 0 || strpos($foto, 'https://') === 0)) {
            return $foto;
        }

        // Preset avatar (character/animal) selected by user
        if ($foto && strpos($foto, 'avatar:') === 0) {
            $slug = substr($foto, 7);
            $avatar_uri = get_avatar_data_uri($slug);
            if ($avatar_uri) {
                return $avatar_uri;
            }
        }

        // Initials-based avatar (e.g., initials:AB)
        if ($foto && strpos($foto, 'initials:') === 0) {
            $initials = substr($foto, 9);
            $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $initials), 0, 3));
            if (!$initials) {
                $initials = 'U';
            }
            return get_initials_avatar_data_uri($initials);
        }

        // User uploaded photo
        if ($foto && file_exists('./uploads/users/' . $foto)) {
            return base_url('uploads/users/' . $foto);
        }

        // Generate initials from user name as fallback
        if (!empty($nama_lengkap)) {
            $words = array_filter(explode(' ', trim($nama_lengkap)));
            $initials = '';
            foreach (array_slice($words, 0, 2) as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if ($initials) {
                return get_initials_avatar_data_uri($initials);
            }
        }

        // Default placeholder
        return get_initials_avatar_data_uri('U');
    }
}

if (!function_exists('get_initials_avatar_data_uri')) {
    function get_initials_avatar_data_uri($initials) {
        $palette = [
            ['#2d5016', '#5a8f4a'],
            ['#3a6ea5', '#7fb1e3'],
            ['#b34700', '#ff9f40'],
            ['#5a3b7a', '#9c7bcf'],
            ['#125d5a', '#3fbfb8'],
        ];
        $colors = $palette[crc32($initials) % count($palette)];
        list($c1, $c2) = $colors;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
             . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">'
             . '<stop offset="0%" stop-color="' . $c1 . '"/><stop offset="100%" stop-color="' . $c2 . '"/>'
             . '</linearGradient></defs>'
             . '<rect width="200" height="200" rx="36" fill="url(#grad)"/>'
             . '<text x="100" y="118" font-family="Arial,Helvetica,sans-serif" font-size="64" font-weight="700" fill="#ffffff" text-anchor="middle">'
             . htmlspecialchars($initials, ENT_QUOTES, 'UTF-8') . '</text>'
             . '</svg>';

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}

if (!function_exists('get_avatar_data_uri')) {
    function get_avatar_data_uri($slug) {
           // girl (cewek) version
           if ($slug === 'girl') {
               return base_url('assets/images/girl.png');
           }
        // boy (cowok) version
         elseif ($slug === 'boy') {
             return base_url('assets/images/boy.png');
        }
        // flower lily variant (distinct shape)
        elseif ($slug === 'flower_lily') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="gradLily" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#fff0f7"/><stop offset="100%" stop-color="#f7c6ff"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#gradLily)"/>'
                 . '<rect x="95" y="120" width="10" height="48" fill="#3aaf6c" rx="5"/>'
                 . '<ellipse cx="100" cy="70" rx="18" ry="38" fill="#f7c6ff"/>'
                 . '<ellipse cx="130" cy="110" rx="14" ry="32" fill="#fff0f7" transform="rotate(25 130 110)"/>'
                 . '<ellipse cx="70" cy="110" rx="14" ry="32" fill="#fff0f7" transform="rotate(-25 70 110)"/>'
                 . '<ellipse cx="100" cy="120" rx="28" ry="14" fill="#f7c6ff"/>'
                 . '<circle cx="100" cy="100" r="18" fill="#ffd24d"/>'
                 . '<ellipse cx="100" cy="100" rx="4" ry="10" fill="#ffac33"/>'
                 . '<ellipse cx="100" cy="100" rx="2" ry="6" fill="#ffb6b6"/>'
                 . '</svg>';
        }
        // flower blue variant (replaces dad)
        elseif ($slug === 'flower_blue') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="gradBlue" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#e1f2ff"/><stop offset="100%" stop-color="#c2e1ff"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#gradBlue)"/>'
                 . '<rect x="95" y="120" width="10" height="48" fill="#2d9c73" rx="5"/>'
                 . '<ellipse cx="80" cy="150" rx="13" ry="21" fill="#3bb28a" transform="rotate(-28 80 150)"/>'
                 . '<ellipse cx="120" cy="152" rx="13" ry="21" fill="#3bb28a" transform="rotate(28 120 152)"/>'
                 . '<circle cx="100" cy="58" r="18" fill="#66b3ff"/><circle cx="100" cy="58" r="13" fill="#8cc8ff"/>'
                 . '<circle cx="132" cy="80" r="18" fill="#8cc8ff"/><circle cx="132" cy="80" r="13" fill="#66b3ff"/>'
                 . '<circle cx="132" cy="120" r="18" fill="#66b3ff"/><circle cx="132" cy="120" r="13" fill="#8cc8ff"/>'
                 . '<circle cx="68" cy="120" r="18" fill="#8cc8ff"/><circle cx="68" cy="120" r="13" fill="#66b3ff"/>'
                 . '<circle cx="68" cy="80" r="18" fill="#66b3ff"/><circle cx="68" cy="80" r="13" fill="#8cc8ff"/>'
                 . '<circle cx="100" cy="98" r="22" fill="#ffd24d"/>'
                 . '<circle cx="100" cy="94" r="4" fill="#ffac33"/><circle cx="104" cy="98" r="4" fill="#ffac33"/>'
                 . '<circle cx="100" cy="102" r="4" fill="#ffac33"/><circle cx="96" cy="98" r="4" fill="#ffac33"/>'
                 . '</svg>';
        }
        // flower yellow variant (replaces child)
        elseif ($slug === 'flower_yellow') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="gradYel" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#fff6d8"/><stop offset="100%" stop-color="#ffe9a8"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#gradYel)"/>'
                 . '<rect x="95" y="120" width="10" height="48" fill="#2a9f5f" rx="5"/>'
                 . '<ellipse cx="82" cy="150" rx="13" ry="21" fill="#44b073" transform="rotate(-25 82 150)"/>'
                 . '<ellipse cx="118" cy="152" rx="13" ry="21" fill="#44b073" transform="rotate(25 118 152)"/>'
                 . '<circle cx="100" cy="60" r="18" fill="#ffd64d"/><circle cx="100" cy="60" r="13" fill="#ffe48a"/>'
                 . '<circle cx="132" cy="82" r="18" fill="#ffe48a"/><circle cx="132" cy="82" r="13" fill="#ffd64d"/>'
                 . '<circle cx="132" cy="122" r="18" fill="#ffd64d"/><circle cx="132" cy="122" r="13" fill="#ffe48a"/>'
                 . '<circle cx="68" cy="122" r="18" fill="#ffe48a"/><circle cx="68" cy="122" r="13" fill="#ffd64d"/>'
                 . '<circle cx="68" cy="82" r="18" fill="#ffd64d"/><circle cx="68" cy="82" r="13" fill="#ffe48a"/>'
                 . '<circle cx="100" cy="100" r="22" fill="#ffb833"/>'
                 . '<circle cx="100" cy="96" r="4" fill="#f59c00"/><circle cx="104" cy="100" r="4" fill="#f59c00"/>'
                 . '<circle cx="100" cy="104" r="4" fill="#f59c00"/><circle cx="96" cy="100" r="4" fill="#f59c00"/>'
                 . '</svg>';
        }
        // cat version
        elseif ($slug === 'cat') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFD700"/><stop offset="100%" stop-color="#FFA500"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<polygon points="60,45 45,15 75,35" fill="#FFA500"/><polygon points="140,45 155,15 125,35" fill="#FFA500"/>'
                 . '<polygon points="65,50 55,30 72,42" fill="#FFD4A3"/><polygon points="135,50 145,30 128,42" fill="#FFD4A3"/>'
                 . '<circle cx="100" cy="100" r="60" fill="#FFD4A3"/>'
                 . '<circle cx="80" cy="80" r="7" fill="#000"/><circle cx="120" cy="80" r="7" fill="#000"/>'
                 . '<circle cx="80" cy="82" r="3" fill="#fff"/><circle cx="120" cy="82" r="3" fill="#fff"/>'
                 . '<circle cx="100" cy="105" r="5" fill="#FF69B4"/>'
                 . '<path d="M 100 105 Q 85 120 75 115" stroke="#000" stroke-width="2.5" fill="none" stroke-linecap="round"/>'
                 . '<path d="M 100 105 Q 115 120 125 115" stroke="#000" stroke-width="2.5" fill="none" stroke-linecap="round"/>'
                 . '</svg>';
        }
        // dog version
        elseif ($slug === 'dog') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#8B4513"/><stop offset="100%" stop-color="#D2691E"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<ellipse cx="65" cy="45" rx="16" ry="35" fill="#654321"/><ellipse cx="135" cy="45" rx="16" ry="35" fill="#654321"/>'
                 . '<circle cx="100" cy="110" r="58" fill="#D2B48C"/>'
                 . '<ellipse cx="100" cy="130" rx="38" ry="32" fill="#DEB887"/>'
                 . '<circle cx="75" cy="85" r="8" fill="#000"/><circle cx="125" cy="85" r="8" fill="#000"/>'
                 . '<circle cx="75" cy="83" r="3" fill="#fff"/><circle cx="125" cy="83" r="3" fill="#fff"/>'
                 . '<ellipse cx="100" cy="125" rx="10" ry="8" fill="#000"/>'
                 . '<ellipse cx="100" cy="145" rx="8" ry="10" fill="#FF69B4"/>'
                 . '</svg>';
        }
        // fox version
        elseif ($slug === 'fox') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FF8C00"/><stop offset="100%" stop-color="#FF6347"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<polygon points="60,38 48,8 72,48" fill="#FF8C00"/><polygon points="140,38 152,8 128,48" fill="#FF8C00"/>'
                 . '<polygon points="65,42 58,18 72,46" fill="#FFD700"/><polygon points="135,42 142,18 128,46" fill="#FFD700"/>'
                 . '<circle cx="100" cy="115" r="55" fill="#FFB347"/>'
                 . '<ellipse cx="100" cy="135" rx="32" ry="28" fill="#FFDAB9"/>'
                 . '<circle cx="78" cy="95" r="8" fill="#000"/><circle cx="122" cy="95" r="8" fill="#000"/>'
                 . '<circle cx="78" cy="93" r="3" fill="#fff"/><circle cx="122" cy="93" r="3" fill="#fff"/>'
                 . '<circle cx="100" cy="130" r="6" fill="#000"/>'
                 . '<path d="M 100 130 L 95 140 M 100 130 L 105 140" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>'
                 . '</svg>';
        }
        // panda version
        elseif ($slug === 'panda') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f0f0f0"/><stop offset="100%" stop-color="#ffffff"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<circle cx="65" cy="50" r="20" fill="#000"/><circle cx="135" cy="50" r="20" fill="#000"/>'
                 . '<circle cx="100" cy="115" r="58" fill="#ffffff"/>'
                 . '<ellipse cx="73" cy="88" rx="18" ry="28" fill="#000"/><ellipse cx="127" cy="88" rx="18" ry="28" fill="#000"/>'
                 . '<circle cx="73" cy="85" r="7" fill="#ffffff"/><circle cx="127" cy="85" r="7" fill="#ffffff"/>'
                 . '<circle cx="73" cy="85" r="4" fill="#000"/><circle cx="127" cy="85" r="4" fill="#000"/>'
                 . '<ellipse cx="100" cy="120" rx="7" ry="6" fill="#000"/>'
                 . '<path d="M 100 120 Q 92 132 82 127" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>'
                 . '<path d="M 100 120 Q 108 132 118 127" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>'
                 . '</svg>';
        }
        // flower version
        elseif ($slug === 'flower') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFE4E1"/><stop offset="100%" stop-color="#FFB6C1"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<rect x="95" y="115" width="10" height="50" fill="#228B22" rx="5"/>'
                 . '<ellipse cx="80" cy="145" rx="12" ry="20" fill="#32CD32" transform="rotate(-35 80 145)"/>'
                 . '<ellipse cx="120" cy="150" rx="12" ry="20" fill="#32CD32" transform="rotate(35 120 150)"/>'
                 . '<circle cx="100" cy="55" r="16" fill="#FF1493"/><circle cx="100" cy="55" r="12" fill="#FF69B4"/>'
                 . '<circle cx="130" cy="75" r="16" fill="#FF69B4"/><circle cx="130" cy="75" r="12" fill="#FF1493"/>'
                 . '<circle cx="130" cy="125" r="16" fill="#FF1493"/><circle cx="130" cy="125" r="12" fill="#FF69B4"/>'
                 . '<circle cx="70" cy="125" r="16" fill="#FF69B4"/><circle cx="70" cy="125" r="12" fill="#FF1493"/>'
                 . '<circle cx="70" cy="75" r="16" fill="#FF1493"/><circle cx="70" cy="75" r="12" fill="#FF69B4"/>'
                 . '<circle cx="100" cy="100" r="22" fill="#FFD700"/>'
                 . '<circle cx="100" cy="95" r="4" fill="#FFA500"/><circle cx="105" cy="100" r="4" fill="#FFA500"/>'
                 . '<circle cx="100" cy="105" r="4" fill="#FFA500"/><circle cx="95" cy="100" r="4" fill="#FFA500"/>'
                 . '</svg>';
        }
        // butterfly version
        elseif ($slug === 'butterfly') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFE4E1"/><stop offset="100%" stop-color="#DDA0DD"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<rect x="95" y="75" width="10" height="55" fill="#8B4513" rx="5"/>'
                 . '<ellipse cx="75" cy="80" rx="22" ry="32" fill="#FF69B4" stroke="#FF1493" stroke-width="2"/>'
                 . '<ellipse cx="60" cy="110" rx="18" ry="26" fill="#FF1493" stroke="#FF69B4" stroke-width="1.5"/>'
                 . '<ellipse cx="125" cy="80" rx="22" ry="32" fill="#FF69B4" stroke="#FF1493" stroke-width="2"/>'
                 . '<ellipse cx="140" cy="110" rx="18" ry="26" fill="#FF1493" stroke="#FF69B4" stroke-width="1.5"/>'
                 . '<circle cx="75" cy="70" r="3" fill="#000"/><circle cx="125" cy="70" r="3" fill="#000"/>'
                 . '<path d="M 100 75 Q 90 55 85 45" stroke="#8B4513" stroke-width="2" fill="none" stroke-linecap="round"/>'
                 . '<path d="M 100 75 Q 110 55 115 45" stroke="#8B4513" stroke-width="2" fill="none" stroke-linecap="round"/>'
                 . '<circle cx="83" cy="40" r="3.5" fill="#FFD700"/><circle cx="117" cy="40" r="3.5" fill="#FFD700"/>'
                 . '</svg>';
        }
        // bunny version
        elseif ($slug === 'bunny') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFF8DC"/><stop offset="100%" stop-color="#FFDAB9"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<ellipse cx="75" cy="20" rx="14" ry="50" fill="#FFF8DC" stroke="#FFB6C1" stroke-width="2"/>'
                 . '<ellipse cx="125" cy="20" rx="14" ry="50" fill="#FFF8DC" stroke="#FFB6C1" stroke-width="2"/>'
                 . '<ellipse cx="75" cy="35" rx="7" ry="38" fill="#FFB6C1"/>'
                 . '<ellipse cx="125" cy="35" rx="7" ry="38" fill="#FFB6C1"/>'
                 . '<circle cx="100" cy="115" r="52" fill="#FFDAB9"/>'
                 . '<circle cx="80" cy="98" r="7" fill="#000"/><circle cx="120" cy="98" r="7" fill="#000"/>'
                 . '<circle cx="80" cy="96" r="3" fill="#fff"/><circle cx="120" cy="96" r="3" fill="#fff"/>'
                 . '<circle cx="100" cy="118" r="5" fill="#FFB6C1"/>'
                 . '<path d="M 98 118 Q 92 128 88 126" stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round"/>'
                 . '<path d="M 102 118 Q 108 128 112 126" stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round"/>'
                 . '</svg>';
        }
        // robot version
        elseif ($slug === 'robot') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">'
                 . '<defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#C0C0C0"/><stop offset="100%" stop-color="#808080"/></linearGradient></defs>'
                 . '<circle cx="100" cy="100" r="90" fill="url(#grad)"/>'
                 . '<rect x="55" y="60" width="90" height="85" fill="#A9A9A9" stroke="#696969" stroke-width="2" rx="8"/>'
                 . '<rect x="92" y="35" width="16" height="25" fill="#696969"/>'
                 . '<circle cx="100" cy="30" r="7" fill="#FFD700"/>'
                 . '<rect x="65" y="75" width="20" height="20" fill="#00FF00" stroke="#008000" stroke-width="1"/>'
                 . '<rect x="115" y="75" width="20" height="20" fill="#00FF00" stroke="#008000" stroke-width="1"/>'
                 . '<rect x="90" y="105" width="20" height="15" fill="#00FF00" stroke="#008000" stroke-width="1"/>'
                 . '<line x1="70" y1="130" x2="130" y2="130" stroke="#696969" stroke-width="2" stroke-linecap="round"/>'
                 . '<rect x="55" y="145" width="15" height="25" fill="#696969" stroke="#404040" stroke-width="1"/>'
                 . '<rect x="130" y="145" width="15" height="25" fill="#696969" stroke="#404040" stroke-width="1"/>'
                 . '</svg>';
        }
        else {
            return null;
        }

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($datetime) {
        if (empty($datetime)) return 'Tidak ada tanggal';
        try {
            $date = new DateTime($datetime);
            return $date->format('d M Y H:i');
        } catch (Exception $e) {
            return 'Tidak ada tanggal';
        }
    }
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        return format_datetime($datetime);
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