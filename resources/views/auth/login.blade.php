@extends('layouts.auth')

@section('title', 'Masuk - Sistem Pembayaran SPP SMK Bina Bangsa')

@section('content')
<div class="min-h-screen lg:h-screen flex flex-col lg:flex-row bg-white lg:overflow-hidden font-sans">
    
    <!-- PANEL KIRI: Visual Branding, Banner & Keunggulan Sistem -->
    <div class="lg:w-7/12 relative flex flex-col justify-between text-white overflow-hidden lg:h-screen" style="background: linear-gradient(180deg, #131129 0%, #0d0c1d 100%);">
        
        <!-- Subtle Background Glows -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- 1. Header Logo Sekolah (Pojok Kiri Atas) -->
        <div class="relative z-20 flex items-center gap-3 px-6 sm:px-10 pt-6 pb-2">
            <div class="w-10 h-10 rounded-2xl bg-white p-1 flex items-center justify-center shadow-lg shadow-black/30 ring-1 ring-white/20 shrink-0">
                <img src="{{ asset('images/logo-smk-cropped.png') }}" alt="Logo SMK Bina Bangsa" class="w-full h-full object-contain">
            </div>
            <div>
                <h2 class="text-sm font-black tracking-tight text-white leading-tight">SMK BINA BANGSA</h2>
                <span class="text-[10px] text-indigo-300 font-semibold tracking-wider uppercase">Portal SPP Digital</span>
            </div>
        </div>

        <!-- 2. Gambar Banner dengan Fade Halus ke Latar Belakang -->
        <div class="relative z-10 w-full overflow-hidden shrink-0">
            <img src="{{ asset('images/banner-smk.jpg') }}" 
                 alt="Gedung SMK Bina Bangsa" 
                 class="w-full h-40 sm:h-48 lg:h-52 object-cover object-top block">
            <!-- Fade Overlay Bawah (Menghilangkan Garis Potong Kaku) -->
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-[#131129] via-[#131129]/85 to-transparent pointer-events-none"></div>
        </div>

        <!-- 3. Informasi Layanan Sekolah & Program Keahlian (Desain Cardless & Terbuka) -->
        <div class="relative z-10 px-8 sm:px-12 pb-8 pt-1 max-w-xl mx-auto w-full my-auto space-y-5">
            <!-- Tajuk Portal Resmi -->
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[11px] font-semibold mb-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Resmi Pembayaran SPP Online</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                    Sistem Pembayaran Cepat & Terverifikasi Otomatis
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1.5 leading-relaxed">
                    Setiap siswa memiliki nomor Virtual Account unik untuk mempermudah transaksi secara mandiri tanpa perlu antre di sekolah.
                </p>
            </div>

            <!-- Daftar 3 Program Keahlian (Identitas Sekolah) -->
            <div class="pt-4 border-t border-white/10">
                <span class="text-[10px] font-bold text-indigo-300 uppercase tracking-wider block mb-2.5">
                    Program Keahlian Terdaftar
                </span>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <div class="p-2.5 rounded-xl bg-white/[0.04] border border-white/10">
                        <span class="font-mono font-bold text-blue-400 text-xs block">RPL</span>
                        <span class="text-[10px] text-slate-300 block leading-tight mt-0.5">Rekayasa Perangkat Lunak</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/[0.04] border border-white/10">
                        <span class="font-mono font-bold text-purple-400 text-xs block">DKV</span>
                        <span class="text-[10px] text-slate-300 block leading-tight mt-0.5">Desain Komunikasi Visual</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/[0.04] border border-white/10">
                        <span class="font-mono font-bold text-emerald-400 text-xs block">TKJ</span>
                        <span class="text-[10px] text-slate-300 block leading-tight mt-0.5">Teknik Komputer Jaringan</span>
                    </div>
                </div>
            </div>

            <!-- Keterangan Operasional Sekolah -->
            <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-300">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-indigo-400 text-sm shrink-0"></i>
                    <span class="text-[11px] leading-tight">Transfer via ATM, M-Banking, dan E-Wallet 24 Jam</span>
                </div>
                <div class="flex items-center gap-1.5 text-slate-400 text-[11px]">
                    <i class="fa-solid fa-headset text-slate-400 text-xs"></i>
                    <span>Bantuan TU: Hari Kerja 07.30 - 15.30</span>
                </div>
            </div>
        </div>

        <!-- Spacer Bawah -->
        <div class="h-2"></div>
    </div>

    <!-- PANEL KANAN: Form Login Cardless (Bersih, Lega, Bebas Scrollbar Desktop) -->
    <div class="lg:w-5/12 flex flex-col justify-center px-8 sm:px-12 lg:px-16 py-6 lg:py-8 bg-white relative lg:h-screen lg:overflow-hidden">
        <div class="w-full max-w-sm mx-auto">
            
            <!-- Header Form (Clean, Tanpa Badge Redundan) -->
            <div class="mb-5">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Masuk ke Akun Anda
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                    Masukkan NIS atau Username beserta Password Anda
                </p>
            </div>

            <!-- Global Alert Notifications -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->has('error'))
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm shrink-0"></i>
                    <span>{{ $errors->first('error') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Field NIS / Username (Label Bersih, Ikon di Dalam Input) -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">
                        NIS / Username <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-id-card text-sm"></i>
                        </span>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}"
                               placeholder="Masukkan NIS (Siswa) atau Username..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('username') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-150">
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Field Password (Label Bersih, Ikon di Dalam Input) -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               placeholder="Masukkan password Anda..."
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border @error('password') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-150">
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

                <!-- Tombol Masuk ke Portal (Tegas Berbahasa Indonesia Sesuai LSP) -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 active:scale-[0.99] text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-600/25 transition duration-150 flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk ke Portal</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <!-- Info Bantuan dengan CTA WhatsApp Aktif -->
            <div class="mt-6 pt-4 border-t border-slate-100 text-center space-y-1">
                <p class="text-xs text-slate-500">Lupa password atau kendala akun?</p>
                <a href="https://wa.me/62318856731?text=Halo%20Staf%20TU%20SMK%20Bina%20Bangsa,%20saya%20mengalami%20kendala%20login%20Portal%20SPP%20dengan%20NIS/Username:%20" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Hubungi Tata Usaha via WhatsApp ↗</span>
                </a>
            </div>

            <!-- Footer Hak Cipta -->
            <p class="text-center text-[11px] text-slate-400 mt-5">
                &copy; {{ date('Y') }} SMK Bina Bangsa • All Rights Reserved
            </p>
        </div>
    </div>
</div>
@endsection
