<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
  public function index()
  {

    if (Auth::user()->email) {

      $content = [
        'pengguna'              => DB::table('users')->count(),
        'barang'                => DB::table('tb_barang')->where('stok_barang', '>', 0)->count(),
        'pendapatan_sekarang'   => DB::table('tb_pemesanan')->where([
          ['created_at', 'LIKE', '%' . explode(' ', Carbon::now())[0] . '%'],
          ['status_pesanan', '>', '3']
        ])->sum('total_bayar'),
        'pendapatan_kemarin'  => DB::table('tb_pemesanan')->where([
          ['created_at', 'LIKE', '%' . explode(' ', Carbon::yesterday())[0] . '%'],
          ['status_pesanan', '>', '3']
        ])->sum('total_bayar'),
        'admin'                 => DB::table('users')->where('role', 1)->count()
      ];

      return view('admin.beranda', $content);
    } else {

      return redirect()->route('login')->withErrors('Harus login terlebih dahulu');
    }
  }
}
