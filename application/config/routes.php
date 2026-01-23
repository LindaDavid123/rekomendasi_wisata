<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
*/

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Landing page & Dashboard routes
$route['dashboard'] = 'dashboard/index';

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['auth/google'] = 'auth/google_login';
$route['auth/google_callback'] = 'auth/google_callback';

// Wisata routes
$route['wisata'] = 'wisata/index';
$route['wisata/detail/(:num)'] = 'wisata/detail/$1';
$route['wisata/submit_rating'] = 'wisata/submit_rating';
$route['wisata/submit_review'] = 'wisata/submit_review';

// Recommendation routes
$route['rekomendasi'] = 'rekomendasi/index';

// Favorit routes
$route['favorit'] = 'favorit/index';
$route['favorit/toggle'] = 'favorit/toggle';

// Profil routes
$route['profil'] = 'profil/index';
$route['profil/edit'] = 'profil/edit';
$route['profil/update'] = 'profil/update';

// Admin routes
$route['admin'] = 'admin/dashboard/index';
$route['admin/dashboard'] = 'admin/dashboard/index';
$route['admin/wisata'] = 'admin/wisata/index';
$route['admin/wisata/tambah'] = 'admin/wisata/tambah';
$route['admin/wisata/edit/(:num)'] = 'admin/wisata/edit/$1';
$route['admin/wisata/hapus/(:num)'] = 'admin/wisata/hapus/$1';
$route['admin/users'] = 'admin/users/index';
