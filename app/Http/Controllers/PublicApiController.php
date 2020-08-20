<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\M_tb_kategori;
use App\M_tb_barang;

class PublicApiController extends Controller
{
  public function getListKategori()
  {
    return M_tb_kategori::all();
  }

  public function getDetailProduk(Request $request)
  {
    if ($request->has('id')) {
      $hasil_pencarian = M_tb_barang::where('id', $request->id)->first();
      return view('pengguna.pages.detail_produk', ['produk' => $hasil_pencarian]);
    } else {
      return redirect()->route('beranda');
    }
  }

  public function getPencarianProduk(Request $request)
  {
    // PENCARIAN
    $cari = [];

    if ($request->has('cari')) {
      array_push($cari, ['nama_barang', 'like', "%" . $request->cari . "%"]);
    }

    if ($request->has('kategori')) {
      $kategori = M_tb_kategori::where('slug', $request->kategori)->first();
      array_push($cari, ['id_kategori', $kategori->id]);
    }

    $hasil_pencarian = M_tb_barang::where($cari)->get();
    // END PENCARIAN

    // KATEGORI
    $kategori = M_tb_kategori::all();
    foreach (M_tb_kategori::all() as $key => $value) {
      $kategori[$key]->jumlah_barang = M_tb_barang::where('id_kategori', $value->id)->count();
    }
    // END KATEGORI

    return view('pengguna.pages.pencarian', ['produk' => $hasil_pencarian, 'kategori' => $kategori]);
  }

  public function getListProvince()
  {
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "UTF-8",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
      ],
    ]);

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return $err;
    } else {
      return $result;
    }
  }

  public function getListCity($id = null)
  {
    if ($id == null) {
      return redirect()->route('api_getListProvince');
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "UTF-8",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
      ],
    ]);

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return $err;
    } else {
      return $result;
    }
  }

  public function getCost($id_city = null, $berat = null)
  {
    if ($id_city == null || $berat == null) {
      return ['error', 'Harus isi id_city dan berat'];
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=94&destination=" . $id_city . "&weight=" . $berat . "&courier=jne",
      CURLOPT_HTTPHEADER => [
        'content-type: application/x-www-form-urlencoded',
        "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
      ],
    ]);

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return $err;
    } else {
      return $result;
    }
  }
}
