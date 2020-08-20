<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      'name' => "Administrator",
      'email' => "admin@admin.com",
      'password' => Hash::make('12345678'),
      'jenis_kelamin' => "Wanita",
      'foto' => 'https://www.accountingweb.co.uk/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png',
      'role' => "1",
    ]);
    DB::table('users')->insert([
      'name' => "Yogi Satya",
      'email' => "yogisatyamahayana@gmail.com",
      'password' => Hash::make('12345678'),
      'jenis_kelamin' => "Pria",
      'role' => "2",
    ]);

    DB::table('tb_kategori')->insert([
      'id' => "1",
      'nama_kategori' => "Tas",
      'slug' => "tas",
      'foto_url' => "https://ecs7.tokopedia.net/img/cache/700/product-1/2017/10/17/0/0_3d38ff30-2795-4e7f-8717-96ef254bc357_700_700.jpg",
    ]);
    DB::table('tb_kategori')->insert([
      'id' => "2",
      'nama_kategori' => "Sepatu",
      'slug' => "sepatu",
      'foto_url' => "https://id-test-11.slatic.net/p/e6f9ef570654a4d78dcc1ea918958388.jpg",
      ]);
    DB::table('tb_kategori')->insert([
      'id' => "3",
      'nama_kategori' => "Accesoris",
      'slug' => "Accesoris",
      'foto_url' => "https://ecs7.tokopedia.net/img/cache/700/product-1/2019/2/11/5274113/5274113_64d91d85-5f21-4488-b845-a59bbd525744.png",
      ]);

    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "WAJAN BIMA - PENGGORENGAN BIMA AL079NS",
    //   'id_kategori' =>  "1",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2018/1/23/24486072/24486072_06a8b194-43bd-4a1a-a175-e7abd3671660_521_521.png",
    //   'berat_barang' => "4000",
    //   'harga_satuan' => "181000",
    //   'stok_barang' =>  "100",
    // ]);
    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "Parutan Serbaguna Multifungsi Putih 4 in 1/ Alat Pemotong Buah & Sayur",
    //   'id_kategori' =>  "1",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2020/5/9/100745686/100745686_73a3e745-9ab3-4651-858a-6c06c2f1d377_670_670.jpg",
    //   'berat_barang' => "200",
    //   'harga_satuan' => "11000",
    //   'stok_barang' =>  "140",
    // ]);

    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "Dell Monitor S2415H",
    //   'id_kategori' =>  "2",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2017/8/14/21566017/21566017_7702959f-283a-4d9f-9441-a48a50fc4b93_450_450.jpg",
    //   'berat_barang' => "12000",
    //   'harga_satuan' => "2675000",
    //   'stok_barang' =>  "50",
    // ]);
    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "keyboard komputer kabel usb",
    //   'id_kategori' =>  "2",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2018/1/18/229280192/229280192_64d36baa-0b4a-4c53-80ea-a7ab3366c98d_960_960.jpg",
    //   'berat_barang' => "650",
    //   'harga_satuan' => "35000",
    //   'stok_barang' =>  "100",
    // ]);
    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "Asus P2430U - Core i5 - GeForce 920M",
    //   'id_kategori' =>  "2",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2019/5/14/5860512/5860512_e530ddf1-f889-4958-a335-f3bcae988723_700_700.jpg",
    //   'berat_barang' => "3000",
    //   'harga_satuan' => "5050000",
    //   'stok_barang' =>  "80",
    // ]);

    // DB::table('tb_barang')->insert([
    //   'nama_barang' =>  "Obeng Multi 8 in One + LED /Obeng set 8 in 1/ Obeng Serbaguna",
    //   'id_kategori' =>  "3",
    //   'foto_barang' =>  "https://ecs7.tokopedia.net/img/cache/700/product-1/2018/7/19/4918174/4918174_d1554ce7-cd03-49bc-b026-3cf7190a63da_700_700.jpg",
    //   'berat_barang' => "249",
    //   'harga_satuan' => "30000",
    //   'stok_barang' =>  "100",
    // ]);
  }
}
