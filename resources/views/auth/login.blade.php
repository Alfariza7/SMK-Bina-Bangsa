@extends('layouts.auth')

@section('title', 'Masuk - Sistem Pembayaran SPP SMK Bina Bangsa')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row bg-slate-900 overflow-hidden font-sans">
    
    <!-- PANEL KIRI: Hero Showcase & Branding (Mengisi layar dengan visual modern & interaktif) -->
    <div class="lg:w-7/12 relative flex flex-col justify-between p-8 sm:p-12 lg:p-16 bg-gradient-to-br from-indigo-950 via-slate-900 to-indigo-900 text-white overflow-hidden">
        <!-- Glow Decorative Effects -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(#312e81_1px,transparent_1px)] [background-size:24px_24px] opacity-20 pointer-events-none"></div>

        <!-- Header Brand Sekolah -->
        <div class="relative z-10 flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white flex items-center justify-center text-xl shadow-lg shadow-indigo-500/30 ring-4 ring-indigo-500/20">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h2 class="text-lg font-black tracking-tight text-white leading-tight">SMK BINA BANGSA</h2>
                <p class="text-[11px] font-semibold text-indigo-300 tracking-wider uppercase">Portal Pembayaran SPP & Virtual Account</p>
            </div>
        </div>

        <!-- Content Tengah: Headline & Kartu Showcase Interaktif -->
        <div class="relative z-10 my-10 lg:my-0 max-w-xl">
            <!-- Badge Sambutan -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-xs font-semibold mb-5 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Sistem Pembayaran 100% Cashless & Otomatis</span>
            </div>

            <!-- Headline Utama -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                Bayar SPP Lebih Praktis <br class="hidden sm:inline">
                dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-sky-300 to-violet-400">Virtual Account</span>
            </h1>

            <p class="mt-4 text-sm text-slate-300 leading-relaxed max-w-lg">
                Tidak perlu antre dan tanpa konfirmasi manual. Setiap siswa memiliki nomor Virtual Account unik yang terhubung langsung dengan sistem Payment Gateway.
            </p>

            <!-- Mock Kartu Virtual Account Interaktif (Membuat halaman penuh gaya & tidak kosong) -->
            <div class="mt-8 p-5 rounded-3xl bg-gradient-to-br from-slate-800/80 to-indigo-950/80 border border-indigo-500/30 backdrop-blur-md shadow-2xl relative overflow-hidden group">
                <div class="absolute right-0 top-0 translate-x-8 -translate-y-8 w-40 h-40 bg-indigo-500/10 rounded-full blur-xl pointer-events-none"></div>
                
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-5 rounded bg-amber-400/80 flex items-center justify-center text-[9px] font-bold text-amber-950 shadow-inner">
                            CHIP
                        </div>
                        <span class="text-xs font-mono font-bold tracking-widest text-slate-300">VIRTUAL ACCOUNT SISWA</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-[9px]"></i> Otomatis
                    </span>
                </div>

                <div class="my-4">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Nomor Pembayaran (5 Digit Akhir = NIS):</span>
                    <p class="text-xl sm:text-2xl font-mono font-black text-amber-300 tracking-wider mt-0.5">
                        88000 <span class="text-white underline decoration-amber-400 decoration-2 underline-offset-4">12345</span>
                    </p>
                </div>

                <div class="flex items-center justify-between pt-1 text-xs text-slate-300">
                    <div>
                        <span class="text-[9px] text-slate-400 block uppercase">Nama Siswa:</span>
                        <span class="font-bold text-white">Ahmad Fauzan</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 block uppercase">Status Terkini:</span>
                        <span class="font-bold text-emerald-400">LUNAS • Rp 350.000</span>
                    </div>
                </div>
            </div>

            <!-- 3 Poin Keunggulan Sistem -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mt-6">
                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-indigo-400 text-base mb-1">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Verifikasi Kilat</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Callback otomatis detik itu juga</p>
                </div>

                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-emerald-400 text-base mb-1">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Data Transparan</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Histori tercatat rapi & valid</p>
                </div>

                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-amber-400 text-base mb-1">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Jatuh Tempo</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Otomatis deteksi tunggakan</p>
                </div>
            </div>
        </div>

        <!-- Footer Info Lokasi Sekolah -->
        <div class="relative z-10 pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-400 gap-2">
            <span>📍 Jl. Pendidikan Bangsa No. 25, Sukamaju, Sidoarjo</span>
            <span>📞 (031) 8856731</span>
        </div>
    </div>

    <!-- PANEL KANAN: Form Login (Pas, Elegan, Tidak Ada Ruang Kosong yang Canggung) -->
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
