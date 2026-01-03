<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Google OAuth Configuration
| Dapatkan credentials dari: https://console.cloud.google.com/
*/

$config['google_oauth'] = [
    'client_id' => 'YOUR_GOOGLE_CLIENT_ID',
    'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
    'redirect_uri' => 'http://localhost/wisata_ci3/auth/google_callback',
    'scopes' => ['email', 'profile']
];
