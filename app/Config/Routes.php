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
