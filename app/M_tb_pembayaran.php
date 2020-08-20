<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_pembayaran extends Model
{
  protected $table = 'tb_pembayaran';
  protected $guarded = [];

  public function m_tb_pemesanan()
  {
    return $this->hasOne('App\M_tb_pemesanan', 'id');
  }
}
