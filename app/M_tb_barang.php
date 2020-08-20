<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_barang extends Model
{
  protected $table = 'tb_barang';
  protected $guarded = [];

  public function m_tb_kategori()
  {
    return $this->belongsTo('App\M_tb_kategori', 'id_kategori');
  }

  public function m_tb_keranjang()
  {
    return $this->hasMany('App\M_tb_keranjang');
  }
}
