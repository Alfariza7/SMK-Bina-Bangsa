@extends('layouts.auth')

@section('title', 'Login - Sistem Pembayaran SPP SMK Bina Bangsa')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950">
    <!-- Background Glow Effects -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- School Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 mb-4 ring-4 ring-indigo-500/20">
                <i class="fa-solid fa-graduation-cap text-3xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">SMK BINA BANGSA</h1>
            <p class="text-xs font-medium text-slate-400 mt-1 uppercase tracking-wider">
                Sistem Informasi Pembayaran SPP • Virtual Account
            </p>
            <p class="text-[11px] text-slate-500 mt-1">
                Jl. Pendidikan Bangsa No. 25, Sukamaju, Sidoarjo | (031) 8856731
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-800">Masuk ke Akun</h2>
                <p class="text-xs text-slate-500 mt-1">Gunakan Username/NIS dan Password Anda</p>
            </div>

            <!-- Global Alert Messages -->
            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->has('error'))
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
                    <span>{{ $errors->first('error') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username / NIS Field -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Username / NIS <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}"
                               placeholder="Contoh: admin / 12345"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('username') border-rose-400 bg-rose-50/30 ring-1 ring-rose-400 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700">
                            Password <span class="text-rose-500">*</span>
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               placeholder="••••••••"
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border @error('password') border-rose-400 bg-rose-50/30 ring-1 ring-rose-400 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="eye-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500">
                        <span>Ingat saya</span>
                    </label>
                    <span class="text-slate-400 text-[11px]">Sertifikasi LSP SMK</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold rounded-xl text-sm shadow-md shadow-indigo-500/25 transition duration-150 flex items-center justify-center gap-2 cursor-pointer">
                    <span>Masuk ke Sistem</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Demo Helper for Examiner / Testing -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Akun Pengujian Demo (Klik Cepat)</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <button type="button" onclick="fillLogin('admin', 'admin123')" class="px-2.5 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between transition cursor-pointer">
                        <span class="font-medium">Admin</span>
                        <span class="text-[10px] text-slate-400">admin</span>
                    </button>
                    <button type="button" onclick="fillLogin('kepsek', 'kepsek123')" class="px-2.5 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between transition cursor-pointer">
                        <span class="font-medium">Kepala Sekolah</span>
                        <span class="text-[10px] text-slate-400">kepsek</span>
                    </button>
                    <button type="button" onclick="fillLogin('teller', 'teller123')" class="px-2.5 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between transition cursor-pointer">
                        <span class="font-medium">Teller</span>
                        <span class="text-[10px] text-slate-400">teller</span>
                    </button>
                    <button type="button" onclick="fillLogin('12345', 'siswa123')" class="px-2.5 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between transition cursor-pointer">
                        <span class="font-medium">Siswa (Ahmad F.)</span>
                        <span class="text-[10px] text-slate-400">12345</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            &copy; {{ date('Y') }} SMK Bina Bangsa. Hak Cipta Dilindungi.
        </p>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    function fillLogin(username, password) {
        document.getElementById('username').value = username;
        document.getElementById('password').value = password;
    }
</script>
@endsection
