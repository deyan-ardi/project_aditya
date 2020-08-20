@extends('pengguna.template.index')


@section('title', 'Pesanan')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Pesanan</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row mb-5">
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
        </div>master
        @elseif(session()->has('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong><i class="fa fa-ban fa-fw"></i> SUCCESS!!</strong> {{ session('success') }} <br>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
        <div class="row">
          <div class="col-md-12">
            <h3 class="text-black">Daftar Pesanan</h3>
          </div>
        </div>
        <hr>

      </div>
      <div class="site-blocks-table col-md-12">
        <div class="alert alert-success">
          <h5>INFO PEMBAYARAN!</h5>
          <div class="py-2">
            <p class="mb-0 text-black">
              Silahkan Transfer Ke Rekening Di Bawah :<br>

              <img src="{{ URL::asset('public/img/bank/mandiri.jpg') }}" alt="Logo"><br> 12345678910 a/n nanda
              nurjanah<br>


              Untuk saat ini kami hanya menggunakan rekening yang tertera di atas, <br>
              jika anda transfer pembayaran selain rekening di atas kami tidak bertanggung jawab.
              <hr>
              <strong>Note : Setelah transfer pembayaran pada rekening di atas di harapkan untuk segera mengupload bukti
                pembayaran.</strong>
            </p>
          </div>
        </div>
      </div>
      <div class="site-blocks-table col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="py-2">No</th>
              <th class="py-2">Kode Pesanan</th>
              <th class="py-2">Bukti Pembayaran</th>
              <th class="py-2">Total Pembayaran</th>
              <th class="py-2">Status</th>
              <th class="py-2">Batalkan</th>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1;?>
            <?php $status = ['Belum Di Proses', 'Dikonfirmasi', 'Dikemas',
                                'Dikirim', 'Sampai Tujuan', 'Dibatalkan'] ?>
            @forelse ($data_pemesanan as $item)
            <tr>
              <td class="py-2" rowspan="2">{{ '#'.$count }}</td>
              <td class="py-2">
                {{ '#'.$item->id }}
              </td>
              <?php $carbon = new Carbon\Carbon(); ?>
              @if($carbon::parse(explode(' ',$carbon::now())[0])->lessThanOrEqualTo($carbon::parse($item->m_tb_pembayaran->batas_pembayaran)) ||
              !is_null($item->m_tb_pembayaran->foto_bukti))
              <td class="py-2">
                @if($item->status_pesanan == 5)
                <span class="badge badge-danger">
                  <i class="fa fa-close fa-fw"></i> Dibatalkan
                </span>
                @elseif($item->m_tb_pembayaran->foto_bukti == NULL)
                <a href="{{route('pengguna_pembayaran_upload_bukti')}}/{{$item->id}}" class="btn btn-outline-warning btn-xs py-1">
                  <i class="fa fa-upload fa-fw"></i> Upload Bukti
                </a><br>
                <small class="help-block">Upload bukti pembayaran.</small>
                @elseif($item->m_tb_pembayaran->foto_bukti != NULL && $item->status_pembayaran == 0)
                <span class="badge badge-secondary">
                  <i class="fa fa-close fa-fw"></i> Menunggu Verifikasi
                </span>
                @else
                {{-- <a href="{{ route('invoice', ['id_invoice' => $inv->id]) }}" target="_blank"
                class="btn btn-outline-info btn-xs py-1">
                <i class="fa fa-search fa-fw"></i> INV{{ $inv->id_pemesanan }}
                </a> --}}
                <span class="badge badge-secondary">
                  <i class="fa fa-close fa-fw"></i> Sudah diverifikasi
                </span>
                @endif
              </td>
              <td class="py-2">{{ Rupiah::create($item->total_bayar) }}</td>
              <td class="py-2">
                <b>@if($item->status_pesanan != 5)<?=$status[$item->status_pesanan]?>@else Dibatalkan @endif</b>
              </td>
              <td class="py-2">
                @if($item->status_pesanan >= 3)
                <span class="badge badge-danger">
                  <i class="fa fa-close fa-fw"></i> Tidak Dapat Dibatalkan
                </span>
                @elseif($item->status_pesanan == 5)
                <span class="badge badge-danger">
                  <i class="fa fa-close fa-fw"></i> Dibatalkan
                </span>
                @else
                <form action="{{route('pengguna_batalkan_pemesanan')}}" method="post">
                  @csrf
                  <input type="hidden" name="id_batal" value="{{$item->id}}">
                  <input type="submit" class="btn btn-danger btn-xs py-1" name="simpan" value="Batalkan">
                </form>
                @endif
              </td>
              @else
              <td class="py-2 text-center" colspan="6">
                <code>TELAH MELAMPAUI BATAS PEMBAYARAN</code>
              </td>
              @endif
            </tr>
            @if($item->status_pesanan == 5)
            <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
              <td class="py-2 text-left" colspan="6">
                <code>Pesanan Telah Di Batalkan</code>
              </td>
            </tr>
            @else
            @if($item->status_pesanan >= 3 && $item->status_pesanan < 5)
              <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                <td class="py-2 text-left" colspan="6">
                  <b>Resi Pengiriman : </b> <code>{{ $item->m_tb_pembayaran->no_resi }}</code> | Dikirim Pada :
                  {{ $item->tanggal_dikirim }} |
                  Layanan Pengiriman : JNE - {{ $item->layanan }}
                  @if($item->status_pesanan == 4)
                  | Diterima Pada : {{ $item->tanggal_diterima }}
                  @else
                  <br> <i><small>Jika Barang telah di terima harap konfirmasi pnerimaan pesanan</small></i>
                  <span class="badge badge-warning"><a href=""
                      class="text-black">Konfirmasi Pesanan</a></span>
                  <i><small> | Track Pesanan : </small></i><span class="badge badge-warning"><a href="https://jne.co.id"
                      target="_blank" class="text-black">Tracking Pesanan</a></span>
                  <br><code>NOTE:</code>Jika kedapatan masalah saat pengiriman atau ingin mengajukan pembatalan pesanan
                  silahkan hubungi kami pada kontak di bawah.</a>
                  @endif
                </td>
              </tr>
              @elseif(empty($item->m_tb_pembayaran->foto_bukti) && $item->status_pesanan != 5)
              <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                <td class="py-2 text-left" colspan="6">
                  Batas Waktu Pembayaran : <code>{{ $item->m_tb_pembayaran->batas_pembayaran }}</code>
                </td>
              </tr>
              @else
              <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                <td class="py-2 text-left" colspan="6">
                  <code>PERHATIAN!! Pembatalan Pesanan Dapat Di Lakukan Sebelum Pesanan Di Kirim.
                                    </td>
                                </tr>
                                @endif
                            @endif

                                {{-- @if($item->status_pesanan <= 2 && $item->status_pesanan > 0 && $item->dibatalkan == 0)
                                <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                    <td class="py-2 text-left" colspan="6">
                                        <code>PERHATIAN!! Pembatalan Pesanan Dapat Di Lakukan Sebelum Pesanan Di Kirim. <br> Silahkan Hubungi Kontak Di Bawah Sebelum Melakukan Pembatalan.
                                    </td>
                                </tr>
                                @endif --}}

                            <?php $count++; ?>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-2">Tidak Ada Data...</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="text-black">
                    <b>NOTE:</b> Jika ingin mencabut status pembatalan silahkan hubungi kontak di bawah.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection