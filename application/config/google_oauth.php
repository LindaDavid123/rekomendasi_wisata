<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Google OAuth Configuration
| Dapatkan credentials dari: https://console.cloud.google.com/
*/

$config['google_oauth'] = [
    'client_id' => '464823547696-npgdnvohimp9hnmamqbc2bcbgsqh95nc.apps.googleusercontent.com',
    'client_secret' => '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',
    'redirect_uri' => 'http://localhost/rekomendasi_wisata/auth/google_callback',
    'scopes' => ['email', 'profile']
];