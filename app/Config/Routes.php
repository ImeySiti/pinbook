<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================== FILTER ==================
$authFilter = ['filter' => 'auth'];

$admin   = ['filter' => 'role:admin'];
$petugas = ['filter' => 'role:petugas'];
$anggota = ['filter' => 'role:anggota'];
$intRole = ['filter' => 'role:admin,petugas'];
$allRole = ['filter' => 'role:admin,petugas,anggota'];


// ================== AUTH ==================
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login/auth', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');


// ================== DASHBOARD ==================
$routes->get('dashboard', 'Home::index', $authFilter);


// ================== USERS ==================
$routes->group('users', ['filter' => 'role:admin,petugas'], function($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
    $routes->get('detail/(:num)', 'Users::detail/$1');
    $routes->get('print', 'Users::print');
    $routes->get('wa/(:num)', 'Users::wa/$1');
});

//Anggota
$routes->group('anggota', function($routes) use ($allRole) {
$routes->get('profil', 'Anggota::profil');

});

// ================== KATEGORI ==================
$routes->group('kategori', $authFilter, function($routes) {
    $routes->get('/', 'Kategori::index');
    $routes->get('create', 'Kategori::create');
    $routes->post('store', 'Kategori::store');
    $routes->get('edit/(:num)', 'Kategori::edit/$1');
    $routes->post('update/(:num)', 'Kategori::update/$1');
    $routes->get('delete/(:num)', 'Kategori::delete/$1');
});


// ================== PENULIS ==================
$routes->group('penulis', $authFilter, function($routes) {
    $routes->get('/', 'Penulis::index');
    $routes->get('create', 'Penulis::create');
    $routes->post('store', 'Penulis::store');
    $routes->get('edit/(:num)', 'Penulis::edit/$1');
    $routes->post('update/(:num)', 'Penulis::update/$1');
    $routes->get('delete/(:num)', 'Penulis::delete/$1');
});


// ================== PENERBIT ==================
$routes->group('penerbit', $authFilter, function($routes) {
    $routes->get('/', 'Penerbit::index');
    $routes->get('create', 'Penerbit::create');
    $routes->post('store', 'Penerbit::store');
    $routes->get('edit/(:num)', 'Penerbit::edit/$1');
    $routes->post('update/(:num)', 'Penerbit::update/$1');
    $routes->get('delete/(:num)', 'Penerbit::delete/$1');
});


// ================== RAK ==================
$routes->group('rak', $authFilter, function($routes) {
    $routes->get('/', 'Rak::index');
    $routes->get('create', 'Rak::create');
    $routes->post('store', 'Rak::store');
    $routes->get('edit/(:num)', 'Rak::edit/$1');
    $routes->post('update/(:num)', 'Rak::update/$1');
    $routes->get('delete/(:num)', 'Rak::delete/$1');
});


// ================== BUKU ==================
$routes->group('buku', $authFilter, function($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('create', 'Buku::create');
    $routes->post('store', 'Buku::store');

    $routes->get('detail/(:num)', 'Buku::detail/$1');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');

    $routes->get('delete/(:num)', 'Buku::delete/$1');

    // tambahan
    $routes->get('print', 'Buku::print');
    $routes->get('wa/(:num)', 'Buku::wa/$1');
});


$routes->group('peminjaman', $authFilter, function($routes) {

    $routes->get('/', 'Peminjaman::index');
    $routes->get('create', 'Peminjaman::create');

    $routes->post('pinjamMulti', 'Peminjaman::pinjamMulti');

    $routes->post('simpan', 'Peminjaman::simpan');

    $routes->get('detail/(:num)', 'Peminjaman::detail/$1');
    $routes->get('delete/(:num)', 'Peminjaman::delete/$1');

    $routes->get('kembali/(:num)', 'Peminjaman::kembali/$1');
    $routes->get('perpanjang/(:num)', 'Peminjaman::perpanjang/$1');

    $routes->get('pembayaran/(:num)', 'Peminjaman::pembayaran/$1');
    $routes->post('prosesBayar/(:num)', 'Peminjaman::prosesBayar/$1');

    $routes->get('konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');

});


// ================== PENGEMBALIAN ==================
$routes->group('pengembalian', $authFilter, function($routes) {

    $routes->get('/', 'Pengembalian::index');
    $routes->get('create', 'Pengembalian::create');
    $routes->post('store', 'Pengembalian::store');

    $routes->get('edit/(:num)', 'Pengembalian::edit/$1');
    $routes->post('update/(:num)', 'Pengembalian::update/$1');

    $routes->get('bayar/(:num)', 'Pengembalian::bayar/$1');
    $routes->get('delete/(:num)', 'Pengembalian::delete/$1');

    $routes->post('simpan', 'Pengembalian::simpan');
});


// ================== TRANSAKSI ==================
$routes->group('transaksi', $authFilter, function($routes) {

    $routes->get('/', 'Transaksi::index');
    $routes->get('create', 'Transaksi::create');
    $routes->post('store', 'Transaksi::store');

    $routes->get('edit/(:num)', 'Transaksi::edit/$1');
    $routes->post('update/(:num)', 'Transaksi::update/$1');

    $routes->post('upload/(:num)', 'Transaksi::uploadBukti/$1');
    $routes->get('konfirmasi/(:num)', 'Transaksi::konfirmasi/$1');
    $routes->get('delete/(:num)', 'Transaksi::delete/$1');

    $routes->post('bayar', 'Transaksi::bayar');
});

 //Backup
$routes->get('/backup', 'Backup::index');


// ================== EXTRA (FIX DUPLIKASI) ==================
