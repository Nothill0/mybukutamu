<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

//homeuser
$routes->get('/', 'Home::publicIndex');

$routes->get('tamu/tambah', 'Tamu::tambah'); // Halaman form tambah tamu diluar login
$routes->post('tamu/simpan', 'Tamu::simpan'); // Untuk memproses tambah/edit tamu

// Routes untuk Otentikasi
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Grup route yang dilindungi oleh filter 'auth' (harus login)
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // Beranda Admin
    $routes->get('home', 'Home::index'); // Ubah ini untuk controller Home yang baru
    $routes->get('home/getChartData', 'Home::getChartData');

    // Manajemen Tamu
    $routes->get('tamu/persetujuan', 'Tamu::persetujuan'); // Halaman persetujuan tamu

    $routes->get('tamu/detail/(:num)', 'Tamu::detail/$1'); // Detail tamu
    $routes->get('tamu/edit/(:num)', 'Tamu::edit/$1'); // Form edit tamu
    $routes->put('tamu/update/(:num)', 'Tamu::update/$1'); // Proses update tamu (gunakan PUT karena ada _method="PUT")
    $routes->get('tamu/delete/(:num)', 'Tamu::delete/$1'); // Hapus tamu

    $routes->post('tamu/setujui/(:num)', 'Tamu::setujui/$1'); // Aksi setujui tamu
    $routes->post('tamu/tolak/(:num)', 'Tamu::tolak/$1');     // Aksi tolak tamu

    // Laporan
    $routes->get('laporan', 'Laporan::index'); // Rute untuk halaman laporan
    $routes->get('laporan/data-chart', 'Laporan::getDataChart'); // Rute baru untuk data chart
});
