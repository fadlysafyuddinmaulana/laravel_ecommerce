{{-- resources/views/auth/verify-email.blade.php --}}
@extends('auth.layouts.portal')

@section('title', 'Verify Email')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
        <div class="w-full max-w-md bg-white shadow-md rounded-lg px-6 py-8">
            <h1 class="text-2xl font-semibold text-center mb-4">
                Verifikasi Alamat Email
                {{-- resources/views/auth/verify-email.blade.php --}}
                @extends('auth.layouts.portal')

            @section('title', 'Verify Email')

            @section('content')
                <div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
                    <div class="w-full max-w-md bg-white shadow-md rounded-lg px-6 py-8">
                        <h1 class="text-2xl font-semibold text-center mb-4">
                            Verifikasi Alamat Email
                        </h1>

                        @if (session('success'))
                            <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded px-3 py-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded px-3 py-2">
                                Link verifikasi baru sudah dikirim ke alamat email kamu.
                            </div>
                        @endif

                        <p class="text-sm text-gray-700 mb-4">
                            Kami sudah mengirim email berisi link verifikasi ke alamat email yang kamu daftarkan.
                            Silakan cek inbox (atau folder spam) dan klik link tersebut untuk mengaktifkan akun.
                        </p>

                        <p class="text-sm text-gray-700 mb-6">
                            Jika kamu belum menerima email, kamu dapat meminta kami untuk mengirim ulang link verifikasi.
                        </p>

                        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endsection
