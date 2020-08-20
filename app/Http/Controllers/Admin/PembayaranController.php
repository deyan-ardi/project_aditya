<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\M_tb_pembayaran;
use App\M_tb_pemesanan;

class PembayaranController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }

  public function index()
  {
    $data_pembayaran_belum = M_tb_pembayaran::all()->where('status_pembayaran', 1);
    $data_pembayaran_sudah = M_tb_pembayaran::all()->where('status_pembayaran', 2);

    return view('admin.transaksi.pembayaran', ['data_pembayaran_belum' => $data_pembayaran_belum, 'data_pembayaran_sudah' => $data_pembayaran_sudah]);
  }

  public function proses($id = null)
  {
    if ($id == null) {
      return redirect()->route('admin_pembayaran');
    }

    $data_pembayaran = M_tb_pembayaran::find($id);

    if (!$data_pembayaran->exists()) {
      return redirect()->route('admin_pembayaran');
    }
    
    $data_pembayaran->status_pembayaran = 2;
    if ($data_pembayaran->save()) {

      $data_pesanan = M_tb_pemesanan::find($data_pembayaran->id_pemesanan);
      $data_pesanan->status_pesanan = 2;
      $data_pesanan->save();

      return redirect()->route('admin_pembayaran')->with('success', 'Data berhasil diperbaharui');
    } else {
      return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');
    }
  }
}
