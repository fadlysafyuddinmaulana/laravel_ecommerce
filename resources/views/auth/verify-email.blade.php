@extends('auth.layouts.portal')

@section('content')
    <div class="register-box" style="width: 70%;">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <p>Silakan cek email untuk link verifikasi. Jika belum menerima email, klik tombol di bawah untuk kirim
                    ulang.</p>

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Kirim ulang email verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
