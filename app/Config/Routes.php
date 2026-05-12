<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/home/coba-parameter/(:alpha)/(:num)/(:alphanum)', 'Home::belajar_segment/$1/$2/$3');

$routes->get('/', 'Admin::login');

// untuk admin
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
