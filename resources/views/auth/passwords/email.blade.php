@extends('pengguna.template.index')

@section('title', 'Lupa Password')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('beranda') }}">Beranda</a>
        <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Lupa Password</strong>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="site-section">
  <div class="container">
    <div class="row" data-aos="fade" data-aos-delay="100">
      <div class="col-md-12">
        <h2 class="h3 mb-3 text-black text-center">Lupa Password</h2>
      </div>
      <div class="col-md-5 mx-auto">
        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="p-3 p-lg-5 border">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong><i class="fa fa-ban fa-fw"></i> ERROR!!</strong><br>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><i class="fa fa-ban fa-fw"></i> Pesan</strong><br>
              <li>{{ session('status') }}</li>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif

            <div class="form-group">
              <label for="inp_email" class="text-black">Email</label>
              <input id="inp_email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                required autocomplete="email" autofocus>
            </div>
            <div class="form-group row mt-5">
              <div class="col-lg-12">
                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Proses
                  Permintaan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
