@extends('layouts.auth')

@section('title', 'Masuk - Sistem Pembayaran SPP SMK Bina Bangsa')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row bg-slate-900 overflow-hidden font-sans">
    
    <!-- PANEL KIRI: Banner Full Edge-to-Edge di Atas, Text Center, & 3 Keunggulan -->
    <div class="lg:w-7/12 relative flex flex-col justify-between bg-gradient-to-br from-indigo-950 via-slate-900 to-indigo-900 text-white overflow-hidden">
        <!-- Glow Decorative Effects -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(#312e81_1px,transparent_1px)] [background-size:24px_24px] opacity-20 pointer-events-none"></div>

        <!-- 1. GAMBAR BANNER FULL BLEED (EDGE-TO-EDGE, TANPA JARAK/SPACE) -->
        <div class="relative z-10 w-full overflow-hidden">
            <img src="{{ asset('images/banner-smk.jpg') }}" 
                 alt="Header Banner SMK Bina Bangsa" 
                 class="w-full h-auto max-h-[320px] object-cover block">
            <!-- Efek Fade Lembut di Bawah Banner Menyatu ke Konten -->
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
        </div>

        <!-- 2. CONTENT TEXT DI BAWAH BANNER (SEMUA POSISI CENTER, DENGAN PADDING) -->
        <div class="relative z-10 text-center max-w-xl mx-auto flex flex-col items-center w-full px-6 sm:px-10 lg:px-12 pb-10 pt-2 my-auto">
            <!-- Headline Utama (Center) -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight mt-1">
                Bayar SPP Lebih Praktis <br class="hidden sm:inline">
                dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-sky-300 to-violet-400">Virtual Account</span>
            </h1>

            <!-- Subtitle Paragraf (Center) -->
            <p class="mt-3 text-xs sm:text-sm text-slate-300 leading-relaxed max-w-lg mx-auto">
                Tidak perlu antre dan tanpa konfirmasi manual. Setiap siswa memiliki nomor Virtual Account unik yang terhubung langsung dengan sistem Payment Gateway.
            </p>

            <!-- 3 Poin Keunggulan Sistem -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 w-full mt-7 text-left">
                <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-indigo-400 text-base mb-1.5">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Verifikasi Kilat</h4>
                    <p class="text-[10px] text-slate-400 mt-0.5">Callback otomatis detik itu juga</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-emerald-400 text-base mb-1.5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Data Transparan</h4>
                    <p class="text-[10px] text-slate-400 mt-0.5">Histori tercatat rapi & valid</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-amber-400 text-base mb-1.5">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Jatuh Tempo</h4>
                    <p class="text-[10px] text-slate-400 mt-0.5">Otomatis deteksi tunggakan</p>
                </div>
            </div>

        </div>

        <div></div>
    </div>

    <!-- PANEL KANAN: Form Login (Tetap Sesuai Desain yang Sudah Bagus) -->
    <div class="lg:w-5/12 flex items-center justify-center p-6 sm:p-10 lg:p-14 bg-slate-50 relative">
        <div class="w-full max-w-md">
            
            <!-- Box Putih Bersih Form Login -->
            <div class="bg-white rounded-3xl p-7 sm:p-9 shadow-xl shadow-slate-200/60 border border-slate-200/80">
                <div class="mb-6">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 inline-block mb-3">
                        Portal Masuk Akun
                    </span>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                        Masuk ke Akun Anda
                    </h2>
                    <p class="text-xs text-slate-500 mt-1 font-medium">
                        Masukkan NIS dan Password Anda untuk melanjutkan
                    </p>
                </div>

                <!-- Global Alert Notifications -->
                @if(session('success'))
                    <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->has('error'))
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
                        <span>{{ $errors->first('error') }}</span>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Field NIS -->
                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-id-card text-indigo-500"></i>
                            <span>NIS</span>
                            <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}"
                               placeholder="Contoh: 12345"
                               class="w-full px-4 py-3 bg-slate-50 border @error('username') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-2xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-150">
                        @error('username')
                            <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Field Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-lock text-indigo-500"></i>
                            <span>Password</span>
                            <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" 
                                   name="password" 
                                   id="password" 
                                   placeholder="Masukkan password Anda..."
                                   class="w-full px-4 pr-11 py-3 bg-slate-50 border @error('password') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-2xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-150">
                            <button type="button" 
                                    @click="show = !show" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-indigo-600 focus:outline-none transition cursor-pointer">
                                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Masuk (Login) -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 active:scale-[0.99] text-white font-bold rounded-2xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center gap-2 cursor-pointer">
                            <span>Masuk (Login)</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </form>

                <!-- Info Bantuan Bawah -->
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Lupa password atau kendala akun? <br>
                        <span class="text-indigo-600 font-semibold">Silakan hubungi staf Tata Usaha SMK Bina Bangsa</span>
                    </p>
                </div>
            </div>

            <p class="text-center text-xs text-slate-400 mt-6">
                &copy; {{ date('Y') }} SMK Bina Bangsa • All Rights Reserved
            </p>
        </div>
    </div>
</div>
@endsection
