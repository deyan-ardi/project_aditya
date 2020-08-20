<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email', 191)->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('alamat_rumah')->nullable();
      $table->string('no_telp')->nullable();
      $table->string('foto')->nullable();
      $table->string('jenis_kelamin');
      // 1 : Admin
      // 2 : Pengguna
      $table->integer('role')->default('2');
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
