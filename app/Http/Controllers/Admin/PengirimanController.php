<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PengirimanController extends Controller
{
  public function index()
  {

    if (Auth::user()) {

      $data = DB::table('tb_pemesanan')
        ->select(
          'id',
          'nama_penerima',
          'alamat_tujuan',
          'layanan',
          'tanggal_diterima',
          'status_pesanan',
          'tanggal_dikirim'
        )->get();

      return view('admin.transaksi.pengiriman', ['data_pengiriman' => $data]);
    } else {

      return redirect()->route('login')->with('fail', 'Harap Login Terlebih Dahulu');
    }
  }
}
