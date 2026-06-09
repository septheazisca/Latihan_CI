<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// HOME
$routes->get('/', 'Homepage::index');

// AUTHENTICATION
$routes->group('admin', function ($routes) {
    // Login & Logout
    $routes->get('login-admin', 'Auth::login');
    $routes->post('autentikasi-login', 'Auth::autentikasi');
    $routes->get('logout', 'Auth::logout');
    $routes->get('dashboard-admin', 'Auth::dashboard');

    // DATA ADMIN
    $routes->get('master-data-admin', 'Admin::master_data_admin');
    $routes->get('input-data-admin', 'Admin::input_data_admin');
    $routes->post('simpan-admin', 'Admin::simpan_data_admin');
    $routes->get('edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
    $routes->post('update-admin', 'Admin::update_data_admin');
    $routes->get('hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

    // DATA ANGGOTA
    $routes->get('master-data-anggota', 'Anggota::master_data_anggota');
    $routes->get('input-data-anggota', 'Anggota::input_data_anggota');
    $routes->post('simpan-anggota', 'Anggota::simpan_data_anggota');
    $routes->get('edit-data-anggota/(:alphanum)', 'Anggota::edit_data_anggota/$1');
    $routes->post('update-anggota', 'Anggota::update_data_anggota');
    $routes->get('hapus-data-anggota/(:alphanum)', 'Anggota::hapus_data_anggota/$1');

    // DATA RAK
    $routes->get('master-data-rak', 'Rak::master_data_rak');
    $routes->get('input-data-rak', 'Rak::input_data_rak');
    $routes->post('simpan-rak', 'Rak::simpan_data_rak');
    $routes->get('edit-data-rak/(:alphanum)', 'Rak::edit_data_rak/$1');
    $routes->post('update-rak', 'Rak::update_data_rak');
    $routes->get('hapus-data-rak/(:alphanum)', 'Rak::hapus_data_rak/$1');

    // DATA KATEGORI
    $routes->get('master-data-kategori', 'Kategori::master_data_kategori');
    $routes->get('input-data-kategori', 'Kategori::input_data_kategori');
    $routes->post('simpan-kategori', 'Kategori::simpan_data_kategori');
    $routes->get('edit-data-kategori/(:alphanum)', 'Kategori::edit_data_kategori/$1');
    $routes->post('update-kategori', 'Kategori::update_data_kategori');
    $routes->get('hapus-data-kategori/(:alphanum)', 'Kategori::hapus_data_kategori/$1');

    // DATA BUKU
    $routes->get('master-buku', 'Buku::master_buku');
    $routes->get('input-buku', 'Buku::input_buku');
    $routes->post('simpan-buku', 'Buku::simpan_buku');
    $routes->get('edit-buku/(:alphanum)', 'Buku::edit_buku/$1');
    $routes->post('update-buku', 'Buku::update_buku');
    $routes->get('hapus-buku/(:alphanum)', 'Buku::hapus_buku/$1');

    // TRANSAKSI PEMINJAMAN
    $routes->get('data-transaksi-peminjaman', 'Peminjaman::data_transaksi_peminjaman');
    $routes->get('peminjaman-step-1', 'Peminjaman::peminjaman_step1');
    $routes->get('tes-qr', 'Peminjaman::tes_qr');
    $routes->get('peminjaman-step-2', 'Peminjaman::peminjaman_step2');
    $routes->post('peminjaman-step-2', 'Peminjaman::peminjaman_step2');
    $routes->get('simpan-temp-pinjam/(:alphanum)', 'Peminjaman::simpan_temp_pinjam/$1');
    $routes->get('hapus-temp/(:alphanum)', 'Peminjaman::hapus_peminjaman/$1');
    $routes->get('simpan-transaksi-peminjaman', 'Peminjaman::simpan_transaksi_peminjaman');
    $routes->get('detail-transaksi/(:segment)', 'Peminjaman::detail_transaksi/$1');
    $routes->get('proses-pengembalian/(:segment)/(:segment)', 'Peminjaman::proses_pengembalian/$1/$2');
    $routes->get('data-pengembalian', 'Peminjaman::data_pengembalian');
});


$routes->group('anggota', function ($routes) {
    // Login & Logout
    $routes->get('login', 'UserAnggota::login');
    $routes->post('autentikasi-login', 'UserAnggota::autentikasi');
    $routes->get('logout', 'UserAnggota::logout');
    $routes->get('dashboard', 'UserAnggota::dashboard');
    $routes->get('daftar-buku', 'UserAnggota::daftar_buku');
    $routes->get('profile', 'UserAnggota::profile');
    $routes->get('settings', 'UserAnggota::settings');
    $routes->post('update-profile', 'UserAnggota::update_profile');
    $routes->post('update-password', 'UserAnggota::update_password');
});
