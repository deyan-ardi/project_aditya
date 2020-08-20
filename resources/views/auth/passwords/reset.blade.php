<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

@extends('pengguna.template.index')

@section('title', 'Lupa Password')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade" data-aos-delay="100">
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
        <h2 class="h3 mb-3 text-black text-center">Buat Password</h2>
      </div>
      <div class="col-md-5 mx-auto">
        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          <input type="hidden" name="token" value="{{ $token }}">
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
            <div class="form-group">
              <label for="email" class="text-black">Email</label>
              <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}"
                required autocomplete="email" autofocus>
            </div>

            <div class="form-group">
              <label for="inp_password" class="text-black">Password Baru</label>
              <input id="inp_password" type="password" class="form-control" name="password" required
                autocomplete="new-password">
              <small class="help-block">Passtikan buat password yang sulit contoh :
                <code><?=generateRandomString(16)?></code></small>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror

            </div>
            <div class="form-group">
              <label for="password-confirm" class="text-black">Ulangi Password</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
            </div>
            <div class="form-group row mt-5">
              <div class="col-lg-12">
                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Reset
                  Password</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
