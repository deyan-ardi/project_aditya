<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tb_keranjang', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_pengguna');
      $table->unsignedBigInteger('id_barang');
      $table->integer('jumlah_beli');
      $table->bigInteger('sub_total');
      $table->timestamps();

      $table->foreign('id_pengguna')->references('id')->on('users');
      $table->foreign('id_barang')->references('id')->on('tb_barang');
    });

    Schema::create('tb_pemesanan', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_pengguna');
      $table->string('nama_penerima', 60);
      $table->string('alamat_tujuan');
      $table->string('keterangan')->nullable();
      $table->string('layanan');
      $table->string('ongkos_kirim', 20);
      $table->string('total_bayar', 20);
      /*
        1 : Dikonfirmasi
        2 : Dikemas
        3 : Dikirim
        4 : Sampai Tujuan
        5 : Dibatalkan
      */
      $table->string('status_pesanan', 1);
      $table->dateTime('tanggal_dikirim', 0)->nullable();
      $table->dateTime('tanggal_diterima', 0)->nullable();
      $table->timestamps();

      $table->foreign('id_pengguna')->references('id')->on('users');
    });

    Schema::create('tb_pemesanan_detail', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_pemesanan');
      $table->unsignedBigInteger('id_barang');
      $table->integer('jumlah_beli');
      $table->double('subtotal_berat');
      $table->double('subtotal_biaya');

      $table->foreign('id_pemesanan')->references('id')->on('tb_pemesanan');
      $table->foreign('id_barang')->references('id')->on('tb_barang');
    });

    Schema::create('tb_pembayaran', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_pengguna');
      $table->unsignedBigInteger('id_pemesanan');
      $table->string('bank')->nullable();
      $table->string('atas_nama')->nullable();
      $table->string('no_rekening')->nullable();
      $table->string('foto_bukti')->nullable();
      $table->string('no_resi')->nullable();
      /*
        1 : BelumDibayar
        2 : SudahDibayar
      */
      $table->integer('status_pembayaran')->default(1);
      $table->dateTime('batas_pembayaran', 0);
      $table->timestamps();

      $table->foreign('id_pengguna')->references('id')->on('users');
      $table->foreign('id_pemesanan')->references('id')->on('tb_pemesanan');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tb_keranjang');
    Schema::dropIfExists('tb_pemesanan');
    Schema::dropIfExists('tb_pemesanan_detail');
    Schema::dropIfExists('tb_pembayaran');
  }
}
