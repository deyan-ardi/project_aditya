<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use App\M_tb_keranjang;
use App\M_tb_barang;

class KeranjangController extends Controller
{
  public function __construct()
  {
    $this->middleware('pengguna');
  }

  public function index()
  {
    $data_keranjang = M_tb_keranjang::with('m_tb_barang')->where('id_pengguna', Auth::user()->id)->get();

    return view('pengguna.pages.keranjang', ['data_keranjang' => $data_keranjang]);
  }

  public function getCount()
  {
    return array('count' => M_tb_keranjang::where('id_pengguna', Auth::user()->id)->count());
  }

  public function delete($id = null)
  {
    if ($id == null) {
      return redirect()->route('pengguna_keranjang');
    }

    M_tb_keranjang::destroy($id);
    return redirect()->route('pengguna_keranjang');
  }

  public function update(Request $request)
  {
    if ($request->has('simpan')) {
      $data = M_tb_keranjang::find($request->input('id_keranjang'));
      $barang = M_tb_barang::find($data->id_barang);

      $data->jumlah_beli = $request->input('jumlah_beli');
      $data->sub_total = $barang->harga_satuan * $request->input('jumlah_beli');

      $data->save();
    }
    return redirect()->route('pengguna_keranjang');
  }

  public function save(Request $request)
  {
    if ($request->has('simpan')) {
      $barang = M_tb_barang::find($request->input('id_produk'));

      $hasil = M_tb_keranjang::create([
        'id_pengguna' => Auth::user()->id,
        'id_barang' => $request->input('id_produk'),
        'jumlah_beli' => $request->input('jumlah_beli'),
        'sub_total' => $barang->harga_satuan * $request->input('jumlah_beli'),
      ]);

      if ($hasil->save()) {
        // $barang->stok_barang = $barang->stok_barang - $request->input('jumlah_beli');
        if ($barang->save()) {
          return back()->with('success', $barang->first()->nama_barang . ' berhasil di tambahkan ke keranjang');
        } else {
          return back()->withErrors('Terjadi kesalahan saat menyimpan');
        }
      } else {
        return back()->withErrors('Terjadi kesalahan saat menyimpan');
      }
    }

    return redirect()->route('beranda');
  }

  public function checkOutView($alamat = null)
  {
    if ($alamat == null) {
      return redirect()->route('pengguna_keranjang');
    }

    $data_keranjang = M_tb_keranjang::with('m_tb_barang')->where('id_pengguna', Auth::user()->id)->get();
    return view('pengguna.pages.keranjang_checkout', ['alamat' => $alamat, 'data_keranjang' => $data_keranjang]);
  }

  public function checkOut(Request $request)
  {
  }
}
