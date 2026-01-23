<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth Controller
 * Handle login, register, logout, dan Google OAuth
 */
class Auth extends CI_Controller
{
    /**
     * Redirect user to Google OAuth login page
     */
    public function google_login()
    {
        // Gunakan library Google_oauth
        $this->load->library('google_oauth');
        $url = $this->google_oauth->get_auth_url();
        if (! $url) {
            show_error('Google OAuth belum dikonfigurasi.');
        }
        redirect($url);
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function login()
    {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            redirect('home');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username/Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $username     = $this->input->post('username');
                $password     = $this->input->post('password');
                $username_val = $this->input->post('username');
                $email_val    = $this->input->post('email');
                $initials     = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $username_val ?: $email_val), 0, 3));
                if (! $initials) {$initials = 'U';}

                // Try login with username or email
                $user = $this->user_model->login($username, $password);

                // If username login fails, try email
                if (! $user && filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    $user = $this->user_model->login_by_email($username, $password);
                }

                if ($user) {
                    // Set session
                    $foto_value = $user['foto'] ?? ($user['foto_profil'] ?? null);
                    if (! $foto_value) {
                        $initials   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $user['username'] ?? ''), 0, 3));
                        $foto_value = 'initials:' . ($initials ?: 'U');
                    }
                    $this->session->set_userdata([
                        'user_id'     => $user['id'],
                        'username'    => $user['username'],
                        'nama'        => $user['nama'] ?? ($user['nama_lengkap'] ?? $user['username']),
                        'email'       => $user['email'],
                        'role'        => $user['role'],
                        'foto'        => $foto_value,
                        'foto_profil' => $foto_value,
                        'logged_in'   => true,
                    ]);

                    // Update last login
                    $this->user_model->update_last_login($user['id']);

                    $this->session->set_flashdata('success', 'Login berhasil! Selamat datang, ' . $user['nama']);

                    // Redirect based on role
                    if ($user['role'] == 'admin') {
                        redirect('admin/dashboard');
                    } else {
                        redirect('dashboard');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Username/Email atau password salah!');
                }
            }
        }

        $data['title'] = 'Login';
        $this->load->view('auth/login', $data);
    }

    public function register()
    {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

            if ($this->form_validation->run()) {
                $username_val = $this->input->post('username');
                $email_val    = $this->input->post('email');
                $initials     = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $username_val ?: $email_val), 0, 3));
                if (! $initials) {$initials = 'U';}

                $data = [
                    'username'     => $username_val,
                    'email'        => $email_val,
                    'password'     => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'nama_lengkap' => $username_val,
                    'nama'         => $username_val,
                    'foto_profil'  => 'initials:' . $initials,
                    'foto'         => 'initials:' . $initials,
                    'role'         => 'user',
                    'status'       => 'active',
                ];

                if ($this->user_model->create($data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        }

        $data['title'] = 'Register';
        $this->load->view('auth/register', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Logout berhasil!');
        redirect(base_url());
    }

    public function google_callback()
    {
        if (! $this->input->get('code')) {
            $this->session->set_flashdata('error', 'Invalid Google OAuth response');
            redirect('auth/login');
        }

        // Pastikan library google_oauth di-load
        $this->load->library('google_oauth');

        $code = $this->input->get('code');

        // Get access token
        $token_data = $this->google_oauth->get_access_token($code);

        if (isset($token_data['error']) || ! isset($token_data['access_token'])) {
            $this->session->set_flashdata('error', 'Failed to get access token from Google');
            redirect('auth/login');
        }

        // Get user info
        $user_info = $this->google_oauth->get_user_info($token_data['access_token']);

        if (isset($user_info['error'])) {
            $this->session->set_flashdata('error', 'Failed to get user info from Google');
            redirect('auth/login');
        }

        // Check if user exists
        $user = $this->user_model->get_by_google_id($user_info['id']);

        if (! $user) {
            // Check if email exists
            $user = $this->user_model->get_by_email($user_info['email']);

            if ($user) {
                // Link Google account
                $this->user_model->link_google_account($user['id'], $user_info['id'], $user_info['picture']);
            } else {
                // Create new user
                $username = explode('@', $user_info['email'])[0];

                // Check if username exists
                if ($this->user_model->get_by_username($username)) {
                    $username = $username . rand(100, 999);
                }

                $user_data = [
                    'username'     => $username,
                    'email'        => $user_info['email'],
                    'password'     => password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT),
                    'nama_lengkap' => $user_info['name'],
                    'foto'         => $user_info['picture'] ?? null,
                    'google_id'    => $user_info['id'],
                    'role'         => 'user',
                    'status'       => 'active',
                ];

                $user_id = $this->user_model->create($user_data);
                $user    = $this->user_model->get_by_id($user_id);
            }
        }

        // Set session
        $foto_value = $user['foto'] ?? ($user['foto_profil'] ?? null);
        if (! $foto_value) {
            $initials   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $user['username'] ?? ''), 0, 3));
            $foto_value = 'initials:' . ($initials ?: 'U');
        }
        $this->session->set_userdata([
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'nama'        => $user['nama'] ?? ($user['nama_lengkap'] ?? $user['username']),
            'email'       => $user['email'],
            'role'        => $user['role'],
            'foto'        => $foto_value,
            'foto_profil' => $foto_value,
            'logged_in'   => true,
        ]);

        $this->session->set_flashdata('success', 'Login berhasil! Selamat datang, ' . $user['nama']);

        if ($user['role'] == 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('home');
        }
    }
}
