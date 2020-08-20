<nav class="site-navigation text-right text-md-center" role="navigation">
  <div class="container">
    <ul class="site-menu js-clone-nav d-none d-md-block">
      <li><a href="{{ route('beranda') }}">Beranda</a></li>
      <li class="has-children">
        <a href="#">Kategori</a>
        <ul class="dropdown" id="kategori">
        </ul>
      </li>
      <li><a href="{{ route('api_getProduk') }}">Lihat Katalog</a></li>
      <li><a href="#kontak">Kontak Kami</a></li>
      @guest
      <li><a href="{{ route('register') }}">Daftar</a> / <a href="{{ route('login') }}"
          class="btn btn-xs btn-outline-primary ml-2 py-1">Masuk</a></li>
      @else
      <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Keluar</a></li>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      @endguest
    </ul>
  </div>
</nav>