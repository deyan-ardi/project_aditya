<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// REDIRECT TO ROOT
Route::get('home', function () {
  return redirect('/');
});
Route::get('/', 'Pengguna\BerandaController@index')->name('beranda');
// END REDIRECT TO ROOT

// PUBLIC API
Route::group(['prefix' => 'api-public'], function () {
  Route::get('list-kategori', 'PublicApiController@getListKategori')->name('api_getListKategori');
  Route::get('list-province', 'PublicApiController@getListProvince')->name('api_getListProvince');
  Route::get('list-city/{id?}', 'PublicApiController@getListCity')->name('api_getListCity');
  Route::get('get-cost/{kota?}/{berat?}', 'PublicApiController@getCost')->name('api_getCost');
});

Route::get('produk', 'PublicApiController@getPencarianProduk')->name('api_getProduk');
Route::group(['prefix' => 'produk'], function () {
  Route::get('cari', 'PublicApiController@getPencarianProduk')->name('api_getPencarianProduk');
  Route::get('detail', 'PublicApiController@getDetailProduk')->name('api_getDetailProduk');
});
// END PUBLIC API

// PENGGUNA API
Route::group(['prefix' => 'api-pengguna'], function () {
  Route::get('count-keranjang', 'Pengguna\KeranjangController@getCount')->name('api_pengguna_getCountKeranjang');
  Route::get('count-pemesanan', 'Pengguna\PemesananController@getCount')->name('api_pengguna_getCountPemesanan');
  Route::get('count-pembayaran', 'Pengguna\PembayaranController@getCount')->name('api_pengguna_getCountPembayaran');
});
// END PENGGUNA API

// PENGGUNA
Route::group(['prefix' => 'pengguna'], function () {
  Route::get('akun-detail', 'Pengguna\AccountController@index')->name('pengguna_detail_akun');
  Route::get('akun-edit', 'Pengguna\AccountController@edit')->name('pengguna_edit_akun');
  Route::post('akun-edit', 'Pengguna\AccountController@edit')->name('pengguna_edit_akun_post');
  Route::get('akun-reset', 'Pengguna\AccountController@reset_password')->name('pengguna_reset_akun');
  Route::post('akun-reset', 'Pengguna\AccountController@reset_password')->name('pengguna_reset_akun_post');

  Route::get('keranjang', 'Pengguna\KeranjangController@index')->name('pengguna_keranjang');
  Route::post('tambah-keranjang', 'Pengguna\KeranjangController@save')->name('pengguna_tambah_keranjang');
  Route::get('hapus-keranjang-barang/{id?}', 'Pengguna\KeranjangController@delete')->name('pengguna_hapus_keranjang');
  Route::post('update-keranjang-barang', 'Pengguna\KeranjangController@update')->name('pengguna_update_keranjang');
  Route::get('checkout-keranjang-barang/{alamat?}', 'Pengguna\KeranjangController@checkOutView')->name('pengguna_checkout_view_keranjang');

  Route::get('pemesanan', 'Pengguna\PemesananController@index')->name('pengguna_pemesanan');
  Route::post('tambah-pemesanan', 'Pengguna\PemesananController@save')->name('pengguna_tambah_pemesanan');
  Route::post('batalkan-pemesanan', 'Pengguna\PemesananController@batalkan')->name('pengguna_batalkan_pemesanan');

  Route::get('pembayaran', 'Pengguna\PembayaranController@index')->name('pengguna_pembayaran');
  Route::get('pembayaran-upload-bukti/{id?}', 'Pengguna\PembayaranController@upload_bukti')->name('pengguna_pembayaran_upload_bukti');
  Route::post('pembayaran-upload-bukti', 'Pengguna\PembayaranController@upload_bukti_post')->name('pengguna_pembayaran_upload_bukti_post');
});
// END PENGGUNA

// ADMIN API
Route::group(['prefix' => 'api-admin'], function () {
  Route::get('produk-detail/{id?}', 'Admin\ProdukController@get_barang_detail')->name('api_admin_get_barang');
});
// END ADMIN API

// ADMIN
Route::get('admin', 'Admin\BerandaController@index')->name('beranda_admin');
Route::group(['prefix' => 'admin'], function () {
  Route::get('produk', 'Admin\ProdukController@index')->name('list_produk');
  Route::post('produk', 'Admin\ProdukController@tambah_produk')->name('tambah_produk');
  Route::get('produk-hapus/{id}', 'Admin\ProdukController@hapus_produk')->name('hapus_produk');
  Route::post('produk-edit', 'Admin\ProdukController@edit_produk')->name('admin_edit_produk');
  
  Route::get('pembayaran', 'Admin\PembayaranController@index')->name('admin_pembayaran');
  Route::get('proses-pembayaran/{id?}', 'Admin\PembayaranController@proses')->name('admin_pembayaran_proses');

  Route::get('pemesanan', 'Admin\PemesananController@index')->name('admin_pemesanan');
  Route::post('proses-pemesanan', 'Admin\PemesananController@proses')->name('admin_pemesanan_proses');
  Route::get('kirim-pemesanan/{id?}', 'Admin\PemesananController@kirim')->name('admin_pemesanan_kirim');

  Route::get('transaksi/pengiriman', 'Admin\PengirimanController@index')->name('pengiriman_admin');
});
// END ADMIN