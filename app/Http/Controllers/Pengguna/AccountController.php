<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\User;

class AccountController extends Controller
{
  public function __construct()
  {
    $this->middleware('pengguna');
  }

  public function index()
  {
    return view('pengguna.pages.akun');
  }

  public function edit(Request $request)
  {
    if ($request->has('simpan')) {
      $validasi = Validator::make($request->all(), [
        'nama_lengkap'  => 'required|string|max:30',
        'jenis_kelamin' => 'required|alpha',
        'alamat_rumah'  => 'required|string',
        'email'         => 'required|email|max:30',
        'no_telepon'    => 'required|regex:/^[0-9\s\-\+]*$/|max:20',
        'password'      => 'required|alpha_num|max:18',
      ]);

      if ($validasi->fails()) {
        return back()->withErrors($validasi);
      }

      $data = User::where('id', Auth::user()->id)->first();

      if ($data->exists() && Hash::check($request->input('password'), $data->password)) {
        $data->name = $request->input('nama_lengkap');
        $data->jenis_kelamin = $request->input('jenis_kelamin');
        $data->email = $request->input('email');
        $data->no_telp = $request->input('no_telepon');
        $data->alamat_rumah = $request->input('alamat_rumah');
        if ($data->save()) {
          return back()->with('success', 'Password berhasil diperbaharui');
        } else {
          return back()->withErrors('Terjadi kesalahan saat menyimpan');
        }
      } else {
        return back()->withErrors('Password Konfirmasi Salah');
      }
    }

    return view('pengguna.pages.akun_edit');
  }

  public function reset_password(Request $request)
  {
    if ($request->has('simpan')) {
      $validasi = Validator::make($request->all(), [
        'password_lama'                 => 'required|alpha_num|max:50',
        'password_baru'                 => 'required|alpha_num|max:50|confirmed',
        'password_baru_confirmation'    => 'required|alpha_num|max:50'
      ]);

      if ($validasi->fails()) {
        return back()->withErrors($validasi);
      }

      $data = User::where('id', Auth::user()->id)->first();

      if (Hash::check($request->input('password_lama'), $data->password) && !Hash::check($request->input('password_baru'), $data->password)) {
        $data->password = Hash::make($request->input('password_baru'));
        if ($data->save()) {
          return back()->with('success', 'Password berhasil diperbaharui');
        } else {
          return back()->withErrors('Terjadi kesalahan saat menyimpan');
        }
      } else {
        return back()->withErrors('Password lama tidak cocok atau password baru sama dengan password lama');
      }
    }

    return view('pengguna.pages.akun_reset');
  }
}
