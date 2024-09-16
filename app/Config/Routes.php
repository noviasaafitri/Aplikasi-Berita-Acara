<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Web');
$routes->setDefaultMethod('Beranda');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


// Mengarahkan root URL ke Home::beranda
$routes->get('/', 'Web::Beranda');

// Route untuk login
$routes->get('login', 'Auth::login');


// $routes->get('/', 'Auth::login');

$routes->get('Admin/edit_ps/(:num)', 'Admin::edit_ps/$1');
$routes->get('Admin/edit_pj/(:num)', 'Admin::edit_pj/$1');
$routes->get('Admin/edit_rj/(:num)', 'Admin::edit_rj/$1');

$routes->get('Admin/view_ps/(:num)', 'Admin::view_ps/$1');
$routes->get('Admin/view_pj/(:num)', 'Admin::view_pj/$1');
$routes->get('Admin/view_rj/(:num)', 'Admin::view_rj/$1');


$routes->get('direktur/view_ps/(:num)', 'Direktur::view_ps/$1');
$routes->get('direktur/update_status_by_kategori_ps/(:any)/(:any)/(:num)', 'Direktur::update_status_by_kategori_ps/$1/$2/$3');

$routes->get('direktur/view_rj/(:num)', 'Direktur::view_rj/$1');
$routes->get('direktur/update_status_by_kategori_rj/(:any)/(:any)/(:num)', 'Direktur::update_status_by_kategori_rj/$1/$2/$3');

$routes->get('direktur/view_pj/(:num)', 'Direktur::view_pj/$1');
$routes->get('direktur/update_status_by_kategori_pj/(:any)/(:any)/(:num)', 'Direktur::update_status_by_kategori_pj/$1/$2/$3');

$routes->get('direktur/view_sm/(:num)', 'Direktur::view_sm/$1');
$routes->get('direktur/update_status_by_kategori_sm/(:any)/(:any)/(:num)', 'Direktur::update_status_by_kategori_sm/$1/$2/$3');


$routes->get('kepalaseksi/view_ps/(:num)', 'KepalaSeksi::view_ps/$1');
$routes->get('kepalaseksi/view_pj/(:num)', 'KepalaSeksi::view_pj/$1');
$routes->get('kepalaseksi/view_rj/(:num)', 'KepalaSeksi::view_rj/$1');

$routes->get('admin/profile', 'Admin::profile');
$routes->post('admin/update_profile_picture', 'Admin::update_profile_picture');

$routes->get('StafSeksi/profile', 'StafSeksi::profile');
$routes->post('StafSeksi/update_profile_picture', 'StafSeksi::update_profile_picture');

$routes->get('Direktur/profile', 'Direktur::profile');
$routes->post('Direktur/update_profile_picture', 'Direktur::update_profile_picture');

$routes->get('Kepalaseksi/profile', 'KepalaSeksi::profile');
$routes->post('Kepalaseksi/update_profile_picture', 'KepalaSeksi::update_profile_picture');

$routes->get('Instalatir/profile', 'Instalatir::profile');
$routes->post('Instalatir/update_profile_picture', 'Instalatir::update_profile_picture');

$routes->get('/admin/surat_keterangan_ps/(:num)', 'Admin::surat_keterangan_ps/$1');
$routes->get('/admin/surat_keterangan_rj/(:num)', 'Admin::surat_keterangan_rj/$1');
$routes->get('/admin/surat_keterangan_pj/(:num)', 'Admin::surat_keterangan_pj/$1');
