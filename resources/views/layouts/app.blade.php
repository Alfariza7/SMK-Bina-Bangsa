<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SMK Bina Bangsa SPP</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smk-cropped.png') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar Navigation (Fixed Stay Component) -->
    @include('components.sidebar')

    <!-- Main Content Area (Independently Scrollable) -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto overflow-x-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm/50">
            <!-- Left Header: Breadcrumb info (Revisi: Tanpa tulisan sistem uji kompetensi siswa) -->
            <div class="flex items-center gap-2.5">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-800 tracking-tight">SMK BINA BANGSA</span>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-indigo-600">Sistem Informasi Pembayaran SPP</span>
            </div>

            <!-- Right Header: User Profile Dropdown Menu or Guest Login -->
            @if(Auth::check())
            <div class="relative" x-data="{ open: false }">
                <button type="button" 
                        @click="open = !open" 
                        class="flex items-center gap-3 p-1.5 pr-3 rounded-full hover:bg-slate-100 transition duration-150 focus:outline-none cursor-pointer">
                    <!-- User Avatar with Online Dot -->
                    <div class="relative">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-bold flex items-center justify-center text-xs shadow-md shadow-indigo-500/20">
                            {{ Auth::user()->initial }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                    </div>

                    <!-- User Name & Role Text -->
                    <div class="text-left hidden sm:block">
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->nama }}</p>
                        <p class="text-[10px] text-slate-400 capitalize">
                            <i class="fa fa-user-graduate"></i>
                            <span class="ml-1">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                        </p>
                    </div>

                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <!-- Profile Dropdown Content -->
                <div x-show="open" 
                     @click.outside="open = false" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 p-5 z-50 text-slate-700"
                     style="display: none;">
                    
                    <!-- Dropdown Header Info -->
                    <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-bold flex items-center justify-center text-base shadow-md shadow-indigo-500/20 shrink-0">
                            {{ Auth::user()->initial }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->nama }}</h4>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mt-1
                                {{ Auth::user()->role === 'admin' ? 'bg-rose-50 text-rose-600 border border-rose-200' : '' }}
                                {{ Auth::user()->role === 'kepala_sekolah' ? 'bg-amber-50 text-amber-600 border border-amber-200' : '' }}
                                {{ Auth::user()->role === 'teller' ? 'bg-cyan-50 text-cyan-600 border border-cyan-200' : '' }}
                                {{ Auth::user()->role === 'siswa' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : '' }}
                            ">
                                {{ str_replace('_', ' ', Auth::user()->role) }}
                            </span>
                        </div>
                    </div>

                    <!-- Divider & Logout Button -->
                    <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs transition duration-150 cursor-pointer">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar (Logout)</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                <span>Masuk ke Akun</span>
            </a>
            @endif
        </header>

        <!-- Flash Notifications -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <span class="text-base">🎉</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-900 p-1 cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mx-6 mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <span class="text-base">⚠️</span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-900 p-1 cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        <!-- Main Body Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-3 px-6 text-center text-xs text-slate-400 border-t border-slate-200 bg-white">
            &copy; {{ date('Y') }} SMK Bina Bangsa • Sistem Informasi Pembayaran SPP
        </footer>
    </div>

</body>
</html>
