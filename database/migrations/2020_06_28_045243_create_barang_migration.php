<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tb_kategori', function (Blueprint $table) {
      $table->id();
      $table->string('nama_kategori', 50);
      $table->string('slug', 50);
      $table->string('foto_url');
    });

    Schema::create('tb_barang', function (Blueprint $table) {
      $table->id();
      $table->string('nama_barang', 100);
      $table->unsignedBigInteger('id_kategori');
      $table->string('foto_barang')->nullable();
      // DALAM GRAM
      $table->integer('berat_barang');
      $table->double('harga_satuan');
      $table->integer('stok_barang');
      $table->timestamps();

      $table->foreign('id_kategori')->references('id')->on('tb_kategori');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tb_kategori');
    Schema::dropIfExists('tb_barang');
  }
}
