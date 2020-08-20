@extends('pengguna.template.index')

@section('title', 'Beranda')

@section('content')
<div class="site-blocks-cover" style="background-image: url({{ asset('public/user_assets/images/back.jpg') }});"
  data-aos="fade">
  <div class="container">
    <div class="row align-items-start align-items-md-center justify-content-end">
      <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
        <h1 class="mb-2 text-white">Temukan Barang Favorite Anda.</h1>
        <div class="intro-text text-center text-md-left">
          <p class="mb-4 text-white">menjual berbagai kebutuhan anda </p>
          <p>
            {{-- <a href="{{route('produk')}}" class="btn btn-sm btn-primary">Belanja Sekarang</a> --}}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section site-section-sm site-blocks-1">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
        <h2>Kenapa Harus Di MyShop?</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
        <div class="icon mr-4 align-self-start">
          <span class="icon-truck"></span>
        </div>
        <div class="text">
          <h2 class="text-uppercase">Pengiriman Cepat</h2>
          <p>Pengiriman cepat dengan banyak pilihan</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
        <div class="icon mr-4 align-self-start">
          <span class="icon-shield"></span>
        </div>
        <div class="text">
          <h2 class="text-uppercase">Aman & Terpercaya</h2>
          <p>Barang terjamin sampai ditujuan dengan aman</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
        <div class="icon mr-4 align-self-start">
          <span class="icon-help"></span>
        </div>
        <div class="text">
          <h2 class="text-uppercase">Layanan Pelanggan</h2>
          <p>Layanan selalu on time</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section site-blocks-2">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
        <h2>Lihat Koleksi Terbaru</h2>
      </div>
    </div>
    <div class="row" id="list_kategori">
    </div>
  </div>
</div>
@endsection

@section('custom_js')
<script>
  $(document).ready(function(){
      $.get("{{ route('api_getListKategori') }}", function(data, status){
        var elementHTML = '';
        data.forEach(element => {
          elementHTML += 
          '<div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">' +
          '  <a class="block-2-item item3" href="{{ route('api_getPencarianProduk') }}?kategori='+element.slug+'">' +
          '    <figure class="image">' +
          '      <img src="'+element.foto_url+'" alt="" class="img-fluid">' +
          '    </figure>' +
          '    <div class="text">' +
          '      <span class="text-uppercase">Lihat Koleksi</span>' +
          '      <h3>'+element.nama_kategori+'</h3>' +
          '    </div>' +
          '  </a>' +
          '</div>';
        });
        $('#list_kategori').html(elementHTML);
      });
    }
  )
</script>
@endsection