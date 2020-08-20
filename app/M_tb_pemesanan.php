<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_pemesanan extends Model
{
  protected $table = 'tb_pemesanan';
  protected $guarded = [];

  public function m_tb_pemesanan_detail()
  {
    return $this->hasMany('App\M_tb_pemesanan_detail', 'id_pemesanan');
  }

  public function m_tb_pembayaran()
  {
    return $this->hasOne('App\M_tb_pembayaran', 'id_pemesanan');
  }
}
