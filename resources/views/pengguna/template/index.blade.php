<!DOCTYPE html>
<html lang="en">

<head>
  <title>MyShop &mdash; @yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @include('pengguna.template.static_css')
  @yield('custom_css')
  <style>
    .site-navbar .site-navigation .site-menu>li>a.btn:hover {
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="site-wrap">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="{{ route('api_getPencarianProduk') }}" method="get" class="site-block-top-search">
                <span class="icon icon-search2"></span>
                <input type="text" name="cari" class="form-control border-0" placeholder="Cari Barang...">
                @if(!empty($_GET['kategori']))
                <input type="hidden" name="kategori" value="{{ $_GET['kategori'] }}">
                @endif
              </form>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="{{route('beranda')}}" class="js-logo-clone">MyShop</a>
              </div>
            </div>
            @guest
            @else
            <div class="col-6 col-md-4 order-4 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                  <li><a href="{{route('pengguna_detail_akun')}}"><span class="icon icon-person"
                        title="Detail Akun"></span></a>
                  </li>
                  <li>
                    <a href="{{route('pengguna_keranjang')}}" class="site-cart" title="Keranjang" id="getCountKeranjang">
                    </a>
                  </li>
                  <li>
                    <a href="{{route('pengguna_pembayaran')}}" class="site-cart" title="Pembayaran" id="getCountPembayaran">
                    </a>
                  </li>
                  <li>
                    <a href="{{route('pengguna_pemesanan')}}" class="site-cart" title="Pesanan" id="getCountPemesanan">
                    </a>
                  </li>
                  <li class="d-inline d-md-none ml-md-0">
                    <a href="#" class="site-menu-toggle js-menu-toggle ml-2">
                      <span class="icon-menu"></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            @endguest
          </div>
        </div>
      </div>
      @include('pengguna.template.navbar')
    </header>
    @yield('breadcrumb')
    @yield('content')
    @yield('modal')
    <footer class="site-footer border-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 mb-5 mb-lg-0" id="kontak">
            <form action="" method="get">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="footer-heading mb-4">Hubungi Kami</h3>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Pengguna">
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Pengguna">
                  </div>
                </div>
                <div class="col-md-6 col-lg-12">
                  <div class="form-group">
                    <input type="text" name="subject" class="form-control" placeholder="subject">
                  </div>
                </div>
                <div class="col-md-6 col-lg-12">
                  <div class="form-group">
                    <input type="text" name="pesan" class="form-control" placeholder="Isi Pesan">
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Kirim Pesan">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Info Kontak</h3>
              <ul class="list-unstyled">
                <li class="address">Universitas PENDIDIKAN GANESHA, SINGARAJA, BALI.</li>
                <li class="phone"><a href="tel://+6212345678910">+62 123 4567 8910</a></li>
                <li class="email">devs@MyShop.com</li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Tentang Kami</h3>
              <p class="text-justify">
                Online Shop menyediakan barang-barang kebutuhan anda, ayo cepat beli dan rasakan kenyamanan berbelanja
                online
              </p>
            </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script data-cfasync="false"
                src="https://www.cloudflare.com/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
              </script>
              <script>
                document.write(new Date().getFullYear());
              </script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i>
              by <a href="https://colorlib.com" target="_blank" class="text-primary">Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
  @include('pengguna.template.static_js')


  <script>
    $(document).ready(function(){
      $.get("{{ route('api_getListKategori') }}", function(data, status){
        var elementMenu = '';
        data.forEach(element => {
          elementMenu += '<li><a href="{{ route('api_getProduk') }}?kategori='+element.slug+'">'+element.nama_kategori+'</a></li>'
        });
        $('ul#kategori').html(elementMenu);
      });

      $.get("{{ route('api_pengguna_getCountKeranjang') }}", function(data, status){
        var elementHTML = '';
        
        elementHTML += '<span class="icon icon-shopping_cart"></span>' +
        '<span class="count" data="keranjang">'+ data.count +'</span>';
        
        $('#getCountKeranjang').html(elementHTML);
      });

      $.get("{{ route('api_pengguna_getCountPemesanan') }}", function(data, status){
        var elementHTML = '';
        
        elementHTML += '<span class="icon icon-shopping-basket"></span>' +
        '<span class="count" data="pesanan">'+ data.count +'</span>';
        
        $('#getCountPemesanan').html(elementHTML);
      });

      $.get("{{ route('api_pengguna_getCountPembayaran') }}", function(data, status){
        var elementHTML = '';
        
        elementHTML += '<span class="icon icon-money"></span>' +
        '<span class="count" data="pembayaran">'+ data.count +'</span>';
        
        $('#getCountPembayaran').html(elementHTML);
      });
    })
  </script>

  @yield('custom_js')
</body>

</html>