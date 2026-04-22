<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
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
$routes->get('/users', 'Users::index', $intRole);
$routes->get('/users/create', 'Users::create');
$routes->post('/users/store', 'Users::store');
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole);
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole);
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole);
$routes->get('/users/detail/(:num)', 'Users::detail/$1', $allRole);
$routes->get('/users/print', 'Users::print', $allRole);
$routes->get('/users/wa/(:num)', 'Users::wa/$1', $allRole);

//kategori
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

//penulis
$routes->get('penulis', 'Penulis::index');
$routes->get('penulis/create', 'Penulis::create');
$routes->post('penulis/store', 'Penulis::store');
$routes->get('penulis/edit/(:num)', 'Penulis::edit/$1');
$routes->post('penulis/update/(:num)', 'Penulis::update/$1');
$routes->get('penulis/delete/(:num)', 'Penulis::delete/$1');

//penerbit
$routes->get('penerbit', 'Penerbit::index');
$routes->get('penerbit/create', 'Penerbit::create');
$routes->post('penerbit/store', 'Penerbit::store');
$routes->get('penerbit/edit/(:num)', 'Penerbit::edit/$1');
$routes->post('penerbit/update/(:num)', 'Penerbit::update/$1');
$routes->get('penerbit/delete/(:num)', 'Penerbit::delete/$1');


// RAK
$routes->get('/rak', 'Rak::index');
$routes->get('/rak/create', 'Rak::create');
$routes->post('/rak/store', 'Rak::store');
$routes->get('/rak/edit/(:num)', 'Rak::edit/$1');
$routes->post('/rak/update/(:num)', 'Rak::update/$1');
$routes->get('/rak/delete/(:num)', 'Rak::delete/$1');

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



//peminjaman
$routes->get('/peminjaman', 'Peminjaman::index');
$routes->get('/peminjaman/create', 'Peminjaman::create');
$routes->get('/peminjaman/cari', 'Peminjaman::cari');
$routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1');
$routes->get('/peminjaman/pinjam/(:num)', 'Peminjaman::pinjam/$1');
$routes->get('/peminjaman/edit/(:num)', 'Peminjaman::edit/$1');
$routes->post('/peminjaman/update/(:num)', 'Peminjaman::update/$1');
$routes->get('/peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->get('/peminjaman/kembali/(:num)', 'Peminjaman::kembali/$1');
$routes->get('peminjaman/perpanjang/(:num)', 'Peminjaman::perpanjang/$1');
$routes->post('/peminjaman/pinjamMulti', 'Peminjaman::pinjamMulti');
$routes->get('peminjaman/pembayaran/(:num)', 'Peminjaman::pembayaran/$1');
$routes->post('peminjaman/prosesBayar/(:num)', 'Peminjaman::prosesBayar/$1');
$routes->post('peminjaman/uploadBukti/(:num)', 'Peminjaman::uploadBukti/$1');
$routes->get('peminjaman/konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');
$routes->get('peminjaman/mulaiAntar/(:num)', 'Peminjaman::mulaiAntar/$1');
$routes->get('peminjaman/selesai/(:num)', 'Peminjaman::selesai/$1');
$routes->post('peminjaman/pilihMetode/(:num)', 'Peminjaman::pilihMetode/$1');

$routes->group('pengembalian', function($routes) {
$routes->get('/', 'Pengembalian::index');
$routes->get('create', 'Pengembalian::create');
$routes->post('store', 'Pengembalian::store');
$routes->get('edit/(:num)', 'Pengembalian::edit/$1');
$routes->post('update/(:num)', 'Pengembalian::update/$1');
$routes->get('delete/(:num)', 'Pengembalian::delete/$1');
});