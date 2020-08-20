<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\M_tb_pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }

  public function index()
  {
    $data_pesanan = M_tb_pemesanan::all();

    $stat_label = [
      'bg-gray', 'label-info', 'bg-blue'
    ];

    $stat_notif = [
      'Belum di Proses', 'Sedang Di Proses', 'Siap Dikirim'
    ];

    return view('admin.transaksi.pesanan', ['data_pesanan' => $data_pesanan, 'stat_label' => $stat_label, 'stat_notif' => $stat_notif]);
  }

  public function proses(Request $request)
  {
    if ($request->input('id_pesanan') == null) {
      return redirect()->route('admin_pemesanan');
    }

    $data_pesanan = M_tb_pemesanan::find($request->input('id_pesanan'));

    if (!$data_pesanan->exists()) {
      return redirect()->route('admin_pemesanan');
    }

    $data_pesanan->status_pesanan = 2;
    if ($data_pesanan->save()) {
      return redirect()->route('admin_pemesanan')->with('success', 'Data berhasil diperbaharui');
    } else {
      return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');
    }
  }

  public function kirim($id = null)
  {
    if ($id == null) {
      return redirect()->route('admin_pemesanan');
    }

    $data_pesanan = M_tb_pemesanan::find($id);

    if (!$data_pesanan->exists()) {
      return redirect()->route('admin_pemesanan');
    }
    
    $data_pesanan->status_pesanan = 3;
    $data_pesanan->tanggal_dikirim = date('Y-m-d H:i:s');
    if ($data_pesanan->save()) {
      return redirect()->route('admin_pemesanan')->with('success', 'Data berhasil diperbaharui');
    } else {
      return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');
    }
  }
}
