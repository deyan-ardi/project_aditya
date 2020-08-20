@extends('pengguna.template.index')

@section('title', 'Checkout')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <a href="{{ route('pengguna_keranjang') }}">Keranjang</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Checkout</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="col-md-12">
      @if ($errors->any())

      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="icon-ban"></i> ERROR!!</strong><br>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @elseif(session()->has('success'))

      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="fa fa-ban fa-fw"></i> SUCCESS!!</strong> {{ session('success') }} <br>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @endif
    </div>
    <form action="{{route('pengguna_tambah_pemesanan')}}" method="post" class="row">
      @csrf
      <div class="col-md-12 mb-4"><a href="{{ route('pengguna_keranjang') }}" class="btn btn-outline-info">Kembali</a>
      </div>
      <div class="col-md-6 mb-5 mb-md-0">
        <h2 class="h3 mb-3 text-black">Detail Pengiriman</h2>
        <div class="p-3 p-lg-5 border">

          <div class="form-group row">
            <div class="col-md-12">
              <h5 class="text-black">Informasi Penerima</h5>
            </div>
            <div class="col-md-12">
              <label for="inp_nama_penerima" class="text-black">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="nama_penerima" id="inp_nama_penerima" placeholder="Nama Penerima"
                class="form-control" value="{{ Auth::user()->name }}">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label for="inp_alamat_tujuan" class="text-black">Alamat <span class="text-danger">*</span></label>
              <textarea name="alamat_tujuan" id="inp_alamat_tujuan" class="form-control" rows="3"
                placeholder="Tulis Alamat Tujuan">{{ $alamat == 1 ?  Auth::user()->alamat_rumah : null}}</textarea>
            </div>
          </div>


          <div class="form-group row">
            <div class="col-md-12">
              <h5 class="text-black">Pilih Tujuan Pengiriman</h5>
            </div>
            <div class="col-md-6">
              <label for="inp_provinsi" class="text-black">Provinsi</label>
              <select class="form-control" name="provinsi" id="inp_provinsi" onchange="get_kota(this.value)"></select>
            </div>
            <div class="col-md-6">
              <label for="inp_kota" class="text-black">Kota</label>
              <select class="form-control" name="kota" id="inp_kota" onchange="get_service(this.value)"></select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label for="inp_layanan" class="text-black">Service</label>
              <select class="form-control" name="layanan" id="inp_layanan"></select>
              <input type="hidden" name="service">
              <input type="hidden" name="destinasi">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <h5 class="text-black">Informasi Transfer Bank</h5>
            </div>
            <div class="col-md-4">
              <label for="inp_bank" class="text-black">Nama Bank</label>
              <select class="form-control" name="bank" id="bank">
                <option value="Mandiri">Mandiri</option>
                <option value="BCA">BCA</option>
                <option value="MEGA">MEGA</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="inp_atas_nama" class="text-black">Atas Nama</label>
              <input type="text" name="atas_nama" class="form-control">
            </div>
            <div class="col-md-4">
              <label for="inp_atas_nama" class="text-black">No. Rekening</label>
              <input type="text" name="no_rekening" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inp_keterangan" class="text-black">Catatan Pengiriman ( Optional )</label>
            <input type="text" name="keterangan" class="form-control">
          </div>

        </div>
      </div>
      <div class="col-md-6">
        <div class="row mb-5">
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Detail Tagihan</h2>
            <div class="p-3 p-lg-5 border">
              <table class="table site-block-order-table mb-5">
                <thead>
                  <th>Product</th>
                  <th>Total</th>
                </thead>
                <tbody id="detail_pesanan">
                  <?php $biaya = 0; $berat = 0; $total_berat = 0;?>
                  @foreach ($data_keranjang as $item)
                  <?php $total_berat = $item->m_tb_barang->berat_barang * $item->jumlah_beli; ?>
                  <tr>
                    <td>
                      {{ substr($item->m_tb_barang->nama_barang,0,10) }}
                      {{strlen($item->m_tb_barang->nama_barang) > 10 ? '...' : ''}} <strong class="mx-2">x</strong>
                      {{ $item->jumlah_beli }}<br>
                      <small>Berat : {!! $item->m_tb_barang->berat_barang.'gram - <strong>Total Berat :
                          '.$total_berat.'gram</strong>'
                        !!}</small>
                    </td>
                    <td>{{ Rupiah::create($item->sub_total) }}</td>
                  </tr>
                  <?php $biaya += $item->sub_total; $berat += $total_berat; ?>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Subtotal Berat</th>
                    <th id="berat">{{ $berat.' gram' }}</th>
                    <input type="hidden" value="{{$berat}}" id="subtotal_berat">
                  </tr>
                  <tr>
                    <th>Subtotal Biaya</th>
                    <th data-biaya="{{ $biaya }}" id="biaya">{{ Rupiah::create($biaya) }}</th>
                  </tr>
                  <tr>
                    <th>Ongkos Kirim</th>
                    <th id="ongkir"></th>
                  </tr>
                </tfoot>
              </table>

              <div class="border p-3 mb-3">
                <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button"
                    aria-expanded="false" aria-controls="collapsebank">Transfer Bank</a></h3>

                <div class="collapse show" id="collapsebank">
                  <div class="py-2">
                    <p class="mb-0 text-black">
                      Silahkan Transfer Ke Rekening Di Bawah :<br>
                      <img src="{{ URL::asset('public/img/bank/mandiri.jpg') }}" alt="Logo"> 12345678910 a/n nanda
                      nurjanah<br><br>
                      <small>
                        Untuk saat ini kami hanya menggunakan rekening yang tertera di atas, <br>
                        jika anda transfer pembayaran selain menggunakan rekening di atas kami tidak bertanggung jawab.
                      </small>
                    </p>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" id="simpan" name="simpan" value="true"
                  class="btn btn-primary btn-lg py-3 btn-block">Proses Pesanan</button>
              </div>

            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
@endsection

@section('custom_js')

<script>
  $(document).ready(function(){
    $.get("{{ route('api_getListProvince') }}", function(data, status){
      data = JSON.parse(data);
      data = data.rajaongkir.results;
      elementHTML = '';

      data.forEach(element => {
        elementHTML += '<option value="' + element.province_id + '">' + element.province + '</option>';
      });

      $('select#inp_provinsi').html(elementHTML);

      get_kota(data[0].province_id);
    });
  });

  function get_kota(params) {
    $.get("{{ route('api_getListCity') }}/" + params, function(data, status){
      data = JSON.parse(data);
      data = data.rajaongkir.results;
      elementHTML = '';

      data.forEach(element => {
        elementHTML += '<option value="' + element.city_id + '">' + element.city_name + '</option>';
      });

      $('select#inp_kota').html(elementHTML);

      get_service(data[0].city_id);
    });
    
    $('#inp_layanan').click(() => {
        $('th#ongkir').html('Rp. '+$('#inp_layanan').find(':selected').val())
        $('input[name="service"]').val($('#inp_layanan').find(':selected').attr('data-layanan'))
        $('input[name="destinasi"]').val(
            $('#inp_kota').find(':selected').html()+", "+$('#inp_provinsi').find(':selected').html()
        )
    })
  }

  function get_service(id_city) {
    var berat = document.getElementById('subtotal_berat').value;

    $.get("{{ route('api_getCost') }}/" + id_city + '/' + berat, function(datas, status){
      datas = JSON.parse(datas);
      data = datas;
      data = data.rajaongkir.results[0].costs;
      elementHTML = '';

      data.forEach(element => {
        elementHTML += '<option data-layanan="'+element.service+'" value="'+element.cost[0].value+'">'+element.service+' '+element.cost[0].etd+' hari Rp. '+element.cost[0].value+'</option>'
      });

      $('select#inp_layanan').html(elementHTML);


      $('th#ongkir').html('Rp. '+$('#inp_layanan').find(':selected').val())
      $('input[name="service"]').val($('#inp_layanan').find(':selected').attr('data-layanan'))
      $('input[name="destinasi"]').val(
          $('#inp_kota').find(':selected').html()+", "+$('#inp_provinsi').find(':selected').html()
      )
    });
  }
</script>

@endsection