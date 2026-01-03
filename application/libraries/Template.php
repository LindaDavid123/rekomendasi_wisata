<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Library
 * Helper for loading views with template
 */
class Template {
    
    protected $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    /**
     * Load view with header and footer
     */
    public function load($view, $data = [], $template = 'default') {
        if ($template == 'admin') {
            $this->CI->load->view('templates/admin_header', $data);
            $this->CI->load->view($view, $data);
            $this->CI->load->view('templates/admin_footer', $data);
        } else {
            $this->CI->load->view('templates/header', $data);
            $this->CI->load->view($view, $data);
            $this->CI->load->view('templates/footer', $data);
        }
    }
    
    /**
     * Load view without template
     */
    public function load_plain($view, $data = []) {
        $this->CI->load->view($view, $data);
    }
}
