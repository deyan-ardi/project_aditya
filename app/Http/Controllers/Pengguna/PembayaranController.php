<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\M_tb_pembayaran;
use App\M_tb_pemesanan;
use App\M_tb_barang;

class PembayaranController extends Controller
{
  public function __construct()
  {
    $this->middleware('pengguna');
  }

  public function index()
  {
    $data_pembayaran = M_tb_pembayaran::with(['m_tb_pemesanan' => function ($q) {
      $q->where('status_pesanan', '<', 5);
    }])->where('id_pengguna', Auth::user()->id)->get();

    // dd($data_pembayaran);
    return view('pengguna.pages.pembayaran', ['data_pembayaran' => $data_pembayaran]);
  }

  public function getCount()
  {
    // return array('count' => M_tb_pembayaran::where('id_pengguna', Auth::user()->id)->count());
    return array('count' => M_tb_pemesanan::where([['id_pengguna', Auth::user()->id], ['status_pesanan', '!=', '5']])->count());
  }

  public function upload_bukti($id = null)
  {
    if ($id == null) {
      return redirect()->route('pengguna_pemesanan');
    }

    $data_pembayaran = M_tb_pembayaran::where('id_pemesanan', $id)->first();

    if (Carbon::parse(explode(' ', Carbon::now())[0])->gt(Carbon::parse($data_pembayaran->batas_pembayaran))) {
      return back()->withErrors('Pesanan "' . $id . '" Sudah Melampaui Batas Waktu');
    }

    if ($data_pembayaran->foto_bukti != NULL) {
      return redirect()->route('pesanan');
    }

    return view('pengguna.pages.pemesanan_upload_bukti', ['id_pesanan' => $id]);
  }

  public function upload_bukti_post(Request $request)
  {
    $validasi = Validator::make($request->all(), [
      'bukti_pembayaran'  => 'required|mimes:jpg,jpeg,png'
    ]);

    if ($validasi->fails()) {

      return back()->withErrors($validasi);
    }

    $data_pembayaran = M_tb_pembayaran::where('id_pemesanan', $request->input('id_pemesanan'))->first();
    $data_pemesanan = M_tb_pemesanan::with('m_tb_pemesanan_detail')->find($request->input('id_pemesanan'));

    foreach ($data_pemesanan->m_tb_pemesanan_detail as $key => $value) {
      $data_barang = M_tb_barang::find($value->id_barang);
      if ($data_barang->stok_barang < $value->jumlah_beli) {
        return back()->withErrors('stok "' . $data_barang->nama_barang . '" kosong / telah habis.');
      }
    }

    if ($data_pembayaran->exists() && $data_pembayaran->foto_bukti == null) {
      $uploadFile = $request->file('bukti_pembayaran');
      $extension = $uploadFile->getClientOriginalExtension();

      $uploadFile->move('public/img/pembayaran/', $data_pemesanan->id . '.' . $extension);

      $data_pembayaran->foto_bukti = URL::to('/') . "/public/img/pembayaran/" . $data_pemesanan->id . '.' . $extension;

      if (!$data_pembayaran->save()) {
        return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Foto');
      }
    }

    foreach ($data_pemesanan->m_tb_pemesanan_detail as $key => $value) {
      $data_barang = M_tb_barang::find($value->id_barang);
      $data_barang->stok_barang -= $value->jumlah_beli;

      if (!$data_barang->save()) {
        return back()->withErrors('Terjadi Kesalahan Saat Memperbaharui Stok Barang');
      }
    }

    return redirect()->route('pengguna_pemesanan')->with('success', 'Bukti pembayaran berhasil di upload, menunggu pembayaran diverifikasi.');
  }
}
