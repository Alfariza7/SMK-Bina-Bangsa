@extends('layouts.auth')

@section('title', 'Masuk - Pembayaran SPP SMK Bina Bangsa')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-violet-100">
    <!-- Playful Decorative Floating Blobs & Emojis -->
    <div class="absolute -top-20 -left-20 w-80 h-80 bg-indigo-300/30 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-violet-300/30 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute top-1/4 right-10 text-4xl select-none opacity-40 pointer-events-none hidden md:block">✨</div>
    <div class="absolute bottom-1/4 left-10 text-4xl select-none opacity-40 pointer-events-none hidden md:block">🎒</div>
    <div class="absolute top-12 left-1/3 text-3xl select-none opacity-30 pointer-events-none hidden md:block">💳</div>

    <div class="w-full max-w-md relative z-10">
        <!-- School Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-500 text-white shadow-xl shadow-indigo-500/30 mb-3 ring-8 ring-indigo-100 transform hover:rotate-6 transition duration-300">
                <i class="fa-solid fa-graduation-cap text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center justify-center gap-1.5">
                SMK BINA BANGSA
            </h1>
            <p class="text-xs font-semibold text-indigo-600 tracking-wide uppercase mt-0.5">
                Sistem Pembayaran SPP • Virtual Account
            </p>
            <p class="text-[11px] text-slate-400 mt-1">
                Jl. Pendidikan Bangsa No. 25, Sukamaju, Sidoarjo
            </p>
        </div>

        <!-- Main Playful Card -->
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl shadow-indigo-900/10 p-7 sm:p-8 border border-white">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                    Halo, Selamat Datang! <span class="text-2xl animate-bounce">👋</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-medium">
                    Masukkan NIS dan password untuk mengakses data SPP kamu
                </p>
            </div>

            <!-- Global Alert Messages -->
            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center gap-2.5 shadow-sm">
                    <span class="text-base">🎉</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl flex items-center gap-2.5 shadow-sm">
                    <span class="text-base">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->has('error'))
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl flex items-center gap-2.5 shadow-sm">
                    <span class="text-base">🚫</span>
                    <span>{{ $errors->first('error') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- NIS Field (Revisi: Cukup NIS & Placeholder Contoh NIS) -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-id-card text-indigo-500"></i>
                        <span>NIS</span>
                        <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}"
                               placeholder="Contoh: 12345"
                               class="w-full px-4 py-3 bg-slate-50/80 border @error('username') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-2xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-200">
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
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
                               placeholder="Masukkan password kamu..."
                               class="w-full px-4 pr-11 py-3 bg-slate-50/80 border @error('password') border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-2xl text-sm font-medium focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition duration-200">
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

                <!-- Submit Button (Revisi: Cukup Tulisan "Masuk (Login)") -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 active:scale-[0.99] text-white font-bold rounded-2xl text-sm shadow-lg shadow-indigo-500/25 transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk (Login)</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Cheerful Footer -->
        <p class="text-center text-xs text-slate-400 font-medium mt-6">
            &copy; {{ date('Y') }} SMK Bina Bangsa • Layanan SPP Digital
        </p>
    </div>
</div>
@endsection
