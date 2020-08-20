<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_keranjang extends Model
{
  protected $table = 'tb_keranjang';
  protected $guarded = [];

  public function m_tb_barang()
  {
    return $this->belongsTo('App\M_tb_barang', 'id_barang');
  }
}
