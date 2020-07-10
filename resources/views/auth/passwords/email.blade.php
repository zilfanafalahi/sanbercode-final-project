@extends('adminlte.app')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            Final Project <b>Kelompok 67</b>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __('Reset Password') }}</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-block btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-block btn-warning">Kembali</a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
@endsection
