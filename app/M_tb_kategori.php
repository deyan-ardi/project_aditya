<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_kategori extends Model
{
  protected $table = 'tb_kategori';
  protected $guarded = [];

  public function m_tb_barang()
  {
    return $this->hasMany('App\M_tb_barang');
  }
}
