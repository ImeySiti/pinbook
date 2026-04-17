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


$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');

//peminajamn
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/create', 'Peminjaman::create');
$routes->post('peminjaman/store', 'Peminjaman::store');
$routes->get('peminjaman/edit/(:num)', 'Peminjaman::edit/$1');
$routes->post('peminjaman/update/(:num)', 'Peminjaman::update/$1');
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->get('peminjaman/(:num)', 'Peminjaman::show/$1');