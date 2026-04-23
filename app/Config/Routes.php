<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================= FILTER =================
$authFilter = ['filter' => 'auth'];

// ================= ROLE =================
$admin    = ['filter' => 'role:admin'];
$petugas  = ['filter' => 'role:petugas'];
$anggota  = ['filter' => 'role:anggota'];
$intRole  = ['filter' => 'role:admin,petugas'];
$allRole  = ['filter' => 'role:admin,petugas,anggota'];


// ================== AUTH ==================
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// REGISTER
$routes->get('/register', 'Auth::register');
$routes->post('/proses-register', 'Auth::prosesRegister');


// ================== DASHBOARD ==================
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);


// ================== USERS ==================
$routes->get('/users', 'Users::index', $intRole);
$routes->get('/users/create', 'Users::create');
$routes->post('/users/store', 'Users::store');
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole);
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole);
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole);
$routes->get('/users/detail/(:num)', 'Users::detail/$1', $allRole);
$routes->get('/users/print', 'Users::print', $allRole);
$routes->get('/users/wa/(:num)', 'Users::wa/$1', $allRole);


// ================= ANGGOTA CRUD =================
$routes->get('anggota', 'Anggota::index');
$routes->get('anggota/create', 'Anggota::create');
$routes->post('anggota/store', 'Anggota::store');
$routes->get('anggota/edit/(:num)', 'Anggota::edit/$1');
$routes->post('anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('anggota/delete/(:num)', 'Anggota::delete/$1');
$routes->get('anggota/print', 'Anggota::print');
$routes->get('anggota/print/(:num)', 'Anggota::printDetail/$1');
$routes->get('anggota/wa/(:num)', 'Anggota::wa/$1');

// ================= ISI DATA ANGGOTA (KHUSUS PEMINJAMAN FLOW) =================
$routes->group('anggota', ['filter' => 'auth'], function($routes) {
$routes->get('isiData', 'Peminjaman::isiData');
$routes->post('simpanData', 'Peminjaman::simpanData');

});

// ================== KATEGORI ==================
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');


// ================== PENULIS ==================
$routes->get('penulis', 'Penulis::index');
$routes->get('penulis/create', 'Penulis::create');
$routes->post('penulis/store', 'Penulis::store');
$routes->get('penulis/edit/(:num)', 'Penulis::edit/$1');
$routes->post('penulis/update/(:num)', 'Penulis::update/$1');
$routes->get('penulis/delete/(:num)', 'Penulis::delete/$1');


// ================== PENERBIT ==================
$routes->get('penerbit', 'Penerbit::index');
$routes->get('penerbit/create', 'Penerbit::create');
$routes->post('penerbit/store', 'Penerbit::store');
$routes->get('penerbit/edit/(:num)', 'Penerbit::edit/$1');
$routes->post('penerbit/update/(:num)', 'Penerbit::update/$1');
$routes->get('penerbit/delete/(:num)', 'Penerbit::delete/$1');


// ================== RAK ==================
$routes->get('/rak', 'Rak::index');
$routes->get('/rak/create', 'Rak::create');
$routes->post('/rak/store', 'Rak::store');
$routes->get('/rak/edit/(:num)', 'Rak::edit/$1');
$routes->post('/rak/update/(:num)', 'Rak::update/$1');
$routes->get('/rak/delete/(:num)', 'Rak::delete/$1');


// ================== BUKU ==================
$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');
$routes->post('buku/search', 'Buku::search');


// ================== PEMINJAMAN ==================
$routes->group('peminjaman', ['filter' => 'auth'], function($routes) {

    // ================= LIST & CREATE =================
    $routes->get('/', 'Peminjaman::index');
    $routes->get('create', 'Peminjaman::create');
    $routes->post('pinjamMulti', 'Peminjaman::pinjamMulti');

    // ================= DETAIL =================
    $routes->get('detail/(:num)', 'Peminjaman::detail/$1');

    // ================= PEMBAYARAN =================
    $routes->get('pembayaran/(:num)', 'Peminjaman::bayarView/$1');
    $routes->post('prosesBayar/(:num)', 'Peminjaman::prosesBayar/$1');

    // ================= STATUS PINJAM =================
    $routes->get('kembali/(:num)', 'Peminjaman::kembali/$1');
    $routes->get('selesai/(:num)', 'Peminjaman::selesai/$1');

    // ================= OPSIONAL =================
    $routes->get('konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');
    $routes->get('mulaiAntar/(:num)', 'Peminjaman::mulaiAntar/$1');
    $routes->get('perpanjang/(:num)', 'Peminjaman::perpanjang/$1');

    $routes->get('delete/(:num)', 'Peminjaman::delete/$1');

    // ================= ISI DATA =================
    $routes->get('isiData', 'Peminjaman::isiData');
    $routes->post('simpanData', 'Peminjaman::simpanData');


});


// ================== PENGEMBALIAN ==================
$routes->group('pengembalian', function($routes) {
    $routes->get('/', 'Pengembalian::index');
    $routes->get('create', 'Pengembalian::create');
    $routes->post('store', 'Pengembalian::store');
    $routes->get('edit/(:num)', 'Pengembalian::edit/$1');
    $routes->post('update/(:num)', 'Pengembalian::update/$1');
    $routes->get('delete/(:num)', 'Pengembalian::delete/$1');
    
});