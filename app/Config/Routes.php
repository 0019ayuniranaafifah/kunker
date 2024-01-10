<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Root');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Root::index');
$routes->add('/login', 'Root::proseslogin');
$routes->add('/logout', 'Root::proseslogout');
$routes->add('/cetak/1/(:any)', 'Root::cetaksuratpengajuan/$1');
$routes->add('/cetak/2/(:any)', 'Root::cetaksuratpengantar/$1');
$routes->add('/cetak/3/(:any)', 'Root::cetaksuratperintah/$1');

/* --------------------------------------------------------------------
 * Pimpinan
 */
$routes->add('/p', 'Pimpinan::index');
$routes->add('/p/profil', 'Pimpinan::tampilprofil');
$routes->add('/p/profil/u', 'Pimpinan::ubahprofil');
$routes->add('/p/akses', 'Pimpinan::tampilakses');
$routes->add('/p/akses/u', 'Pimpinan::ubahakses');

$routes->add('/p/pengguna', 'Pengguna::index');
$routes->add('/p/pengguna/s', 'Pengguna::simpan');
$routes->add('/p/pengguna/u', 'Pengguna::ubah');
$routes->add('/p/pengguna/d/(:any)', 'Pengguna::detail/$1');
$routes->add('/p/pengguna/h/(:any)', 'Pengguna::hapus/$1');

$routes->add('/p/pegawai', 'Pegawai::index');
$routes->add('/p/pegawai/s', 'Pegawai::simpan');
$routes->add('/p/pegawai/u', 'Pegawai::ubah');
$routes->add('/p/pegawai/d/(:any)', 'Pegawai::detail/$1');
$routes->add('/p/pegawai/h/(:any)', 'Pegawai::hapus/$1');

$routes->add('/p/verifikasi', 'Verifikasi::index');
$routes->add('/p/verifikasi/d/(:any)', 'Verifikasi::detail/$1');
$routes->add('/p/verifikasi/s', 'Verifikasi::sesuai');
$routes->add('/p/verifikasi/ts', 'Verifikasi::tidaksesuai');

/* --------------------------------------------------------------------
 * Bendahara
 */
$routes->add('/b', 'Bendahara::index');
$routes->add('/b/profil', 'Bendahara::tampilprofil');
$routes->add('/b/profil/u', 'Bendahara::ubahprofil');
$routes->add('/b/akses', 'Bendahara::tampilakses');
$routes->add('/b/akses/u', 'Bendahara::ubahakses');

$routes->add('/b/pengajuan', 'Datapengajuan::index');
$routes->add('/b/pengajuan/d/(:any)', 'Datapengajuan::detail/$1');
$routes->add('/b/pengajuan/b/tb', 'Datapengajuan::tambahbiaya');
$routes->add('/b/pengajuan/b/hb/(:any)', 'Datapengajuan::hapusbiaya/$1');
$routes->add('/b/pengajuan/b', 'Datapengajuan::bayar');

$routes->add('/b/laporan/l', 'Datapengajuan::laporan');
$routes->add('/b/laporan/l/t', 'Datapengajuan::tampillaporan');
$routes->add('/b/laporan/l/c/(:any)', 'Datapengajuan::cetaklaporan/$1');

/* --------------------------------------------------------------------
 * Operator
 */
$routes->add('/o', 'Operator::index');
$routes->add('/o/profil', 'Operator::tampilprofil');
$routes->add('/o/profil/u', 'Operator::ubahprofil');
$routes->add('/o/akses', 'Operator::tampilakses');
$routes->add('/o/akses/u', 'Operator::ubahakses');

$routes->add('/o/pengajuan', 'Pengajuan::index');
$routes->add('/o/pengajuan/b', 'Pengajuan::baru');
$routes->add('/o/pengajuan/b/td', 'Pengajuan::tambahdasar');
$routes->add('/o/pengajuan/b/tu', 'Pengajuan::tambahutusan');
$routes->add('/o/pengajuan/b/ta', 'Pengajuan::tambahagenda');
$routes->add('/o/pengajuan/b/tk', 'Pengajuan::tambahketerangan');
$routes->add('/o/pengajuan/b/tp', 'Pengajuan::tambahpengikut');
$routes->add('/o/pengajuan/b/tb', 'Pengajuan::tambahbiaya');
$routes->add('/o/pengajuan/b/hd/(:any)/(:any)', 'Pengajuan::hapusdasar/$1/$2');
$routes->add('/o/pengajuan/b/hu/(:any)/(:any)', 'Pengajuan::hapusutusan/$1/$2');
$routes->add('/o/pengajuan/b/ha/(:any)/(:any)', 'Pengajuan::hapusagenda/$1/$2');
$routes->add('/o/pengajuan/b/hk/(:any)/(:any)', 'Pengajuan::hapusketerangan/$1/$2');
$routes->add('/o/pengajuan/b/hp/(:any)/(:any)', 'Pengajuan::hapuspengikut/$1/$2');
$routes->add('/o/pengajuan/b/hb/(:any)/(:any)', 'Pengajuan::hapusbiaya/$1/$2');
$routes->add('/o/pengajuan/s', 'Pengajuan::simpan');
$routes->add('/o/pengajuan/v', 'Pengajuan::verifikasi');
$routes->add('/o/pengajuan/d/(:any)', 'Pengajuan::detail/$1');
$routes->add('/o/pengajuan/u/td', 'Pengajuan::tambahdetaildasar');
$routes->add('/o/pengajuan/u/tu', 'Pengajuan::tambahdetailutusan');
$routes->add('/o/pengajuan/u/ta', 'Pengajuan::tambahdetailagenda');
$routes->add('/o/pengajuan/u/tk', 'Pengajuan::tambahdetailketerangan');
$routes->add('/o/pengajuan/u/tp', 'Pengajuan::tambahdetailpengikut');
$routes->add('/o/pengajuan/u/tb', 'Pengajuan::tambahdetailbiaya');
$routes->add('/o/pengajuan/u/hd/(:any)', 'Pengajuan::hapusdetaildasar/$1');
$routes->add('/o/pengajuan/u/hu/(:any)', 'Pengajuan::hapusdetailutusan/$1');
$routes->add('/o/pengajuan/u/ha/(:any)', 'Pengajuan::hapusdetailagenda/$1');
$routes->add('/o/pengajuan/u/hk/(:any)', 'Pengajuan::hapusdetailketerangan/$1');
$routes->add('/o/pengajuan/u/hp/(:any)', 'Pengajuan::hapusdetailpengikut/$1');
$routes->add('/o/pengajuan/u/hb/(:any)', 'Pengajuan::hapusdetailbiaya/$1');
$routes->add('/o/pengajuan/u', 'Pengajuan::ubah');
$routes->add('/o/pengajuan/h/(:any)', 'Pengajuan::hapus/$1');
$routes->add('/o/pengajuan/acc/(:any)', 'Pengajuan::acc/$1');


$routes->add('/o/laporan/l', 'Pengajuan::laporan');
$routes->add('/o/laporan/l/t', 'Pengajuan::tampillaporan');
$routes->add('/o/laporan/l/b/(:any)', 'Pengajuan::buatlaporan/$1');
$routes->add('/o/laporan/l/d/(:any)', 'Pengajuan::detaillaporan/$1');
$routes->add('/o/laporan/l/s', 'Pengajuan::simpanlaporan');
$routes->add('/o/laporan/l/u', 'Pengajuan::ubahlaporan');
$routes->add('/o/laporan/l/c/(:any)', 'Pengajuan::cetaklaporan/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
