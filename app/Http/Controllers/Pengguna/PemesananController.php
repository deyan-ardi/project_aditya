<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\M_tb_keranjang;
use App\M_tb_pemesanan;
use App\M_tb_pemesanan_detail;
use App\M_tb_pembayaran;
use App\M_tb_barang;
use App\User;

class PemesananController extends Controller
{
  public function __construct()
  {
    $this->middleware('pengguna');
  }

  public function index()
  {
    $data_pemesanan = M_tb_pemesanan::with('m_tb_pemesanan_detail')->with('m_tb_pembayaran')->where([['id_pengguna', Auth::user()->id], ['status_pesanan', '<', 5]])->get();
    // dd($data_pemesanan);
    return view('pengguna.pages.pemesanan', ['data_pemesanan' => $data_pemesanan]);
  }

  public function getCount()
  {
    return array('count' => M_tb_pemesanan::where([['id_pengguna', Auth::user()->id], ['status_pesanan', '!=', '5']])->count());
  }
  
  public function save(Request $request)
  {
    if ($request->has('simpan')) {
      $id_pengguna = Auth::user()->id;

      $validasi = Validator::make($request->all(), [
        'nama_penerima' => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
        'alamat_tujuan' => 'required|string',
        'keterangan'    => 'nullable|string',
        'service'       => 'required|alpha',
        'destinasi'     => 'required|regex:/^[a-zA-Z\,\.\s]*$/',
        'layanan'       => 'required|integer',
        'bank'          => 'required|alpha',
        'atas_nama'     => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
        'no_rekening'   => 'required|regex:/^[0-9\-\s]*$/'
      ]);

      if ($validasi->fails()) {
        return back()->withErrors($validasi);
      }

      $keranjang = M_tb_keranjang::where('id_pengguna', Auth::user()->id)->get();

      if ($keranjang->count() > 0) {
        $pemesanan = M_tb_pemesanan::create([
          'id_pengguna'   => $id_pengguna,
          'nama_penerima' => $request->input('nama_penerima'),
          'alamat_tujuan' => $request->input('alamat_tujuan') . '|' . $request->input('destinasi'),
          'keterangan'    => !is_null($request->input('keterangan')) ? $request->input('keterangan') : NULL,
          'layanan'       => $request->input('service'),
          'ongkos_kirim'  => $request->input('layanan'),
          'total_bayar'   => $keranjang->sum('sub_total'),
          'status_pesanan' => '1'
        ]);

        if ($pemesanan->save()) {
          foreach ($keranjang as $key => $value) {
            $barang = M_tb_barang::find($value->id_barang);
            $pemesanan_detail = M_tb_pemesanan_detail::create([
              'id_pemesanan'     => $pemesanan->id,
              'id_barang'      => $value->id_barang,
              'jumlah_beli'    => $value->jumlah_beli,
              'subtotal_berat' => ($value->jumlah_beli * $barang->berat_barang),
              'subtotal_biaya' => $value->sub_total,
            ]);
            $pemesanan_detail->save();
          }

          $pembayaran = M_tb_pembayaran::create([
            'id_pemesanan'       => $pemesanan->id,
            'id_pengguna'      => $id_pengguna,
            'bank'             => $request->input('bank'),
            'atas_nama'        => $request->input('atas_nama'),
            'no_rekening'      => $request->input('no_rekening'),
            'batas_pembayaran' => Carbon::tomorrow(),
            'status_pembayaran' => '1'
          ]);

          if ($pembayaran->save()) {
            M_tb_keranjang::where('id_pengguna', Auth::user()->id)->delete();
            return back()->with('success', 'Pesanan Berhasil Di Simpan');
          }
        } else {
          return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');
        }
      } else {
        return back()->withErrors('Data Keranjang Tidak Ditemukan');
      }
    }

    return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');
  }

  public function batalkan(Request $request)
  {
    if ($request->has('simpan')) {
      $data_pemesanan = M_tb_pemesanan::find($request->input('id_batal'));

      // dd($data_pemesanan);

      if ($data_pemesanan->exists()) {
        $data_pemesanan->status_pesanan = 5;
        $data_pemesanan->tanggal_dikirim = NULL;

        $data_pemesanan->save();


        return redirect()->route('pengguna_pemesanan')->with('success', 'Pesanan berhasil di batalkan');
      }
    }
    return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');
  }
}
