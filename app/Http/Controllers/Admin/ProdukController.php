<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\M_tb_barang;

class ProdukController extends Controller
{
  public function index(Request $request)
  {
    if (Auth::user()->email) {
      $data = M_tb_barang::with('m_tb_kategori')->get();
      $kategori = DB::table('tb_kategori')->get();
      return view('admin.produk.produk', [
        'data_produk'   => $data,
        'data_kategori' => $kategori
      ]);
    } else {

      return redirect()->route('login')->with('fail', 'Harap Login Terlebih Dahulu');
    }
  }
  public function tambah_produk(Request $request)
  {
    if ($request->has('simpan')) {

      $validasi = Validator::make($request->all(), [
        'nama_barang'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
        'berat_barang'      => 'required|integer',
        'harga_satuan'      => 'required|integer',
        'stok_barang'       => 'required|integer',
        'foto_barang'       => 'required|mimes:jpg,jpeg,png'
      ]);

      if ($validasi->fails()) {

        return back()->withErrors($validasi);
      }

      if (DB::table('tb_barang')->where('nama_barang', $request->input('nama_barang'))->exists() == false) {

        $extension = $request->file('foto_barang')->getClientOriginalExtension();

        $data_barang = M_tb_barang::create([
          'nama_barang'       => $request->input('nama_barang'),
          'id_kategori'       => $request->input('id_kategori'),
          'berat_barang'      => $request->input('berat_barang'),
          'harga_satuan'      => $request->input('harga_satuan'),
          'stok_barang'       => $request->input('stok_barang'),
        ]);

        $data_barang->save();

        $data_barang->foto_barang = URL::to('/') . "/public/img/produk/" . $data_barang->id . '.' . $extension;

        $data_barang->save();

        $uploadFile = $request->file('foto_barang');
        $extension = $uploadFile->getClientOriginalExtension();

        $uploadFile->move('public/img/produk/', $data_barang->id . '.' . $extension);

        return redirect()->route('list_produk')->with('success', 'Produk Berhasil DI Simpan');
      } else {

        return back()->withErrors('Produk tidak dapat di simpan karna telah tersedia');
      }
    } else {
      return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');
    }
  }

  public function edit_produk(Request $request)
  {

    if ($request->has('simpan')) {

      $validasi = Validator::make($request->all(), [
        'nama_barang'   => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
        'berat_barang'  => 'required|integer',
        'harga_satuan'  => 'required|integer',
        'stok_barang'   => 'required|integer',
      ]);

      if ($validasi->fails()) {

        return back()->withErrors($validasi);
      }

      $data = M_tb_barang::find($request->input('id_barang'));

      if ($request->hasFile('foto_barang')) {
        $uploadFile = $request->file('foto_barang');
        $extension = $uploadFile->getClientOriginalExtension();

        $uploadFile->move('public/img/produk/', $data->id . '.' . $extension);
        
        $data->foto_barang = URL::to('/') . "/public/img/produk/" . $data->id . '.' . $extension;
      }

      $data->nama_barang = $request->input('nama_barang');
      $data->id_kategori = $request->input('id_kategori');
      $data->berat_barang = $request->input('berat_barang');
      $data->harga_satuan = $request->input('harga_satuan');
      $data->stok_barang = $request->input('stok_barang');
      $data->save();

      return redirect()->route('list_produk')->with('success', 'Produk Berhasil DI Simpan');
    } else {

      return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');
    }
  }

  public function hapus_produk(Request $request, $id_barang)
  {

    $data = DB::table('tb_barang')->where('id', $id_barang);

    Storage::delete('public/img/produk/' . $data->first()->foto_barang);

    $data->delete();

    return redirect()->route('list_produk')->with('success', 'Produk Berhasil Di Hapus');
  }

  public function get_barang_detail($id = null)
  {
    if ($id == null) {
      return M_tb_barang::with('m_tb_kategori')->get();
    }

    return M_tb_barang::with('m_tb_kategori')->find($id);
  }

  public function get_barang()
  {

    $id_barang = $_GET['id_barang'];

    $data = DB::table('tbl_barang')->where('id_barang', $id_barang)->first();

    return response()->json($data);
  }

  protected function set_id_barang()
  {
    $data = DB::table('tbl_barang')->max('id_barang');

    if (!empty($data)) {

      $no_urut = substr($data, 9, 3) + 1;

      return 'BRG' . (new Datetime)->format('ymd') . $no_urut;
    } else {
      return 'BRG' . (new Datetime)->format('ymd') . '1';
    }
  }
}
