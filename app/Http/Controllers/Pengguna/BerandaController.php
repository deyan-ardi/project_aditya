<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
  public function index()
  {
    return view('pengguna.pages.beranda');
  }
}