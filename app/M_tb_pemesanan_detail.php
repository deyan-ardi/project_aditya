<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_tb_pemesanan_detail extends Model
{
  protected $table = 'tb_pemesanan_detail';
  protected $guarded = [];
  public $timestamps = false;

  public function m_tb_pemesanan()
  {
    return $this->belongsTo('App\M_tb_pemesanan');
  }
}
