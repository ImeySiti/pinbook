<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================== FILTER ==================
$authFilter = ['filter' => 'auth'];

$admin    = ['filter' => 'role:admin'];
$petugas  = ['filter' => 'role:petugas'];
$anggota  = ['filter' => 'role:anggota'];
$intRole  = ['filter' => 'role:admin,petugas'];
$allRole  = ['filter' => 'role:admin,petugas,anggota'];


// ================== AUTH ==================
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');


// ================== DASHBOARD ==================
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);


// ================== USERS ==================
$routes->group('users', function($routes) use ($intRole, $allRole) {
    $routes->get('/', 'Users::index', $intRole);
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1', $allRole);
    $routes->post('update/(:num)', 'Users::update/$1', $allRole);
    $routes->get('delete/(:num)', 'Users::delete/$1', $allRole);
    $routes->get('detail/(:num)', 'Users::detail/$1', $allRole);
    $routes->get('print', 'Users::print', $allRole);
    $routes->get('wa/(:num)', 'Users::wa/$1', $allRole);
});

$routes->group('peminjaman', function($routes) {

    $routes->get('/', 'Peminjaman::index');
    $routes->get('create', 'Peminjaman::create');
    
    $routes->post('pinjamMulti', 'Peminjaman::pinjamMulti');

    $routes->get('detail/(:num)', 'Peminjaman::detail/$1');
    $routes->get('delete/(:num)', 'Peminjaman::delete/$1');

    $routes->get('kembali/(:num)', 'Peminjaman::kembali/$1');
    $routes->get('perpanjang/(:num)', 'Peminjaman::perpanjang/$1');

    $routes->get('pembayaran/(:num)', 'Peminjaman::pembayaran/$1');
    $routes->post('prosesBayar/(:num)', 'Peminjaman::prosesBayar/$1');

    $routes->get('konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');
    $routes->get('mulaiAntar/(:num)', 'Peminjaman::mulaiAntar/$1');
    $routes->get('selesai/(:num)', 'Peminjaman::selesai/$1');

    $routes->get('konfirmasiAntar/(:num)', 'Peminjaman::konfirmasiAntar/$1');

    $routes->get('ajukanKembali/(:num)', 'Peminjaman::ajukanKembali/$1');
    $routes->get('ajukanPerpanjang/(:num)', 'Peminjaman::ajukanPerpanjang/$1');
    $routes->get('ajukanPenarikan/(:num)', 'Peminjaman::ajukanPenarikan/$1');

    $routes->get('konfirmasiPengembalian/(:num)', 'Peminjaman::konfirmasiPengembalian/$1');
    $routes->get('konfirmasiPerpanjangan/(:num)', 'Peminjaman::konfirmasiPerpanjangan/$1');
    $routes->get('konfirmasiPenarikan/(:num)', 'Peminjaman::konfirmasiPenarikan/$1');

});
// ================== PENGEMBALIAN ==================
$routes->group('pengembalian', function($routes) {

    $routes->get('/', 'Pengembalian::index');
    $routes->get('create', 'Pengembalian::create');
    $routes->post('store', 'Pengembalian::store');

    $routes->get('edit/(:num)', 'Pengembalian::edit/$1');
    $routes->post('update/(:num)', 'Pengembalian::update/$1');

    $routes->get('bayar/(:num)', 'Pengembalian::bayar/$1');
    $routes->get('delete/(:num)', 'Pengembalian::delete/$1');
    $routes->post('pengembalian/simpan', 'Pengembalian::simpan');

});


// ================== TRANSAKSI ==================
$routes->group('transaksi', function($routes) {

    $routes->get('/', 'Transaksi::index');
    $routes->get('create', 'Transaksi::create');
    $routes->post('store', 'Transaksi::store');

    $routes->get('edit/(:num)', 'Transaksi::edit/$1');
    $routes->post('update/(:num)', 'Transaksi::update/$1');

    $routes->post('upload/(:num)', 'Transaksi::uploadBukti/$1');
    $routes->get('konfirmasi/(:num)', 'Transaksi::konfirmasi/$1');
    $routes->get('delete/(:num)', 'Transaksi::delete/$1');

    $routes->post('bayar', 'Transaksi::bayar');
///wiuhdgfuwefbweubf
$routes->get('pengembalian/create/(:num)', 'Pengembalian::create/$1');
$routes->post('pengembalian/simpan', 'Pengembalian::simpan');
});