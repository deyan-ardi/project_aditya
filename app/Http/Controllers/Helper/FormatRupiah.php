<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormatRupiah extends Controller
{
  public static function create($jumlah)
  {
    return 'Rp ' . number_format($jumlah, 0, ',', '.');
  }
}
