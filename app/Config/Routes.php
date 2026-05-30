<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// $routes->get('/', 'Home::index');
$routes->get('/home/coba-parameter/(:alpha)/(:num)/(:alphanum)', 'Home::belajar_segment/$1/$2/$3');

$routes->get('/', 'Admin::login');

// Untuk admin
$routes->get('admin/login-admin', 'Admin::login');
$routes->post('admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('admin/logout', 'admin::logout');
$routes->get('admin/dashboard-admin', 'Admin::dashboard');

// Routes untuk module admin
$routes->get('/admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('/admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('/admin/simpan-admin', 'Admin::simpan_data_admin');
$routes->get('/admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('/admin/update-admin', 'Admin::update_data_admin');
$routes->get('/admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

// Routes untuk module anggota
$routes->get('/admin/master-data-anggota', 'Admin::master_data_anggota');
$routes->get('/admin/input-data-anggota', 'Admin::input_data_anggota');
$routes->post('/admin/simpan-anggota', 'Admin::simpan_data_anggota');
$routes->get('/admin/edit-data-anggota/(:alphanum)', 'Admin::edit_data_anggota/$1');
$routes->post('/admin/update-anggota', 'Admin::update_data_anggota');
$routes->get('/admin/hapus-data-anggota/(:alphanum)', 'Admin::hapus_data_anggota/$1');

// Routes untuk module rak
$routes->get('/admin/master-data-rak', 'Admin::master_data_rak');
$routes->get('/admin/input-data-rak', 'Admin::input_data_rak');
$routes->post('/admin/simpan-rak', 'Admin::simpan_data_rak');
$routes->get('/admin/edit-data-rak/(:alphanum)', 'Admin::edit_data_rak/$1');
$routes->post('/admin/update-rak', 'Admin::update_data_rak');
$routes->get('/admin/hapus-data-rak/(:alphanum)', 'Admin::hapus_data_rak/$1');

// Routes untuk module kategori
$routes->get('/admin/master-data-kategori', 'Admin::master_data_kategori');
$routes->get('/admin/input-data-kategori', 'Admin::input_data_kategori');
$routes->post('/admin/simpan-kategori', 'Admin::simpan_data_kategori');
$routes->get('/admin/edit-data-kategori/(:alphanum)', 'Admin::edit_data_kategori/$1');
$routes->post('/admin/update-kategori', 'Admin::update_data_kategori');
$routes->get('/admin/hapus-data-kategori/(:alphanum)', 'Admin::hapus_data_kategori/$1');