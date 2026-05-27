<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google OAuth Library
 */
class Google_oauth {
    
    protected $CI;
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $scopes;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('google_oauth', true);
        $config = $this->CI->config->item('google_oauth');
        if (!$config || !isset($config['client_id']) || !isset($config['client_secret']) || !isset($config['redirect_uri']) || !isset($config['scopes'])) {
            show_error('Google OAuth belum dikonfigurasi dengan benar. Pastikan file application/config/google_oauth.php dan autoload.php sudah benar.');
        }
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->redirect_uri = $config['redirect_uri'];
        $this->scopes = $config['scopes'];
    }
    
    /**
     * Get authorization URL
     */
    public function get_auth_url() {
        $params = [
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => implode(' ', $this->scopes),
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }
    
    /**
     * Exchange authorization code for access token
     */
    public function get_access_token($code) {
        $url = 'https://oauth2.googleapis.com/token';
        
        $params = [
            'code' => $code,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'authorization_code'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        }
        
        return false;
    }
    
    /**
     * Get user info using access token
     */
    public function get_user_info($access_token) {
        $url = 'https://www.googleapis.com/oauth2/v2/userinfo';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        }
        
        return false;
    }
}
