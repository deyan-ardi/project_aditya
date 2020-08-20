<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGASI UTAMA</li>
    <!-- Optionally, you can add icons to the links -->
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> <span>Beranda</span></a></li>
    <li class="header">MANAJEMEN</li>
    <li><a href="{{ route('list_produk') }}"><i class="fa fa-cubes"></i> <span>Produk <span class="label bg-primary pull-right" id="jml_produk"></span></span></a></li>
    <li class="header">TRANSAKSI</li>
    <li><a href="{{route('admin_pembayaran')}}"><i class="fa fa-money"></i> <span>Pembayaran <span class="label bg-red pull-right" id="jml_pembayaran"></span></span></a></li>
    <li><a href="{{route('admin_pemesanan')}}"><i class="fa fa-shopping-cart"></i> <span>Pesanan <span class="label bg-red pull-right" id="jml_pesanan"></span></span></a></li>
    <li><a href="{{route('pengiriman_admin')}}"><i class="fa fa-truck"></i> <span>Pengiriman <span class="label bg-red pull-right" id="jml_pengiriman"></span></span></a></li>
</ul>
<!-- /.sidebar-menu -->
