<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SMK Bina Bangsa SPP</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 min-h-screen border-r border-slate-800 shadow-xl">
        <div>
            <!-- School Brand Header -->
            <div class="p-5 border-b border-slate-800/80 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-600/30">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-sm text-white leading-tight">SMK BINA BANGSA</h2>
                    <span class="text-[10px] text-indigo-400 font-semibold tracking-wider uppercase">SPP Virtual Account</span>
                </div>
            </div>

            <!-- Role Indicator Card -->
            <div class="p-4 mx-3 my-3 bg-slate-800/60 rounded-xl border border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-indigo-400 text-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama }}</p>
                        <span class="inline-block px-2 py-0.5 mt-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                            {{ Auth::user()->role === 'admin' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : '' }}
                            {{ Auth::user()->role === 'kepala_sekolah' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                            {{ Auth::user()->role === 'teller' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : '' }}
                            {{ Auth::user()->role === 'siswa' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
                        ">
                            {{ str_replace('_', ' ', Auth::user()->role) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nav Links according to Role -->
            <nav class="px-3 space-y-1 text-xs font-medium">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/20">
                        <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Master Data</div>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-user-graduate w-4 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-school w-4 text-center"></i>
                        <span>Kelas & Jurusan</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-money-bill-wave w-4 text-center"></i>
                        <span>Tarif SPP</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-credit-card w-4 text-center"></i>
                        <span>Virtual Account</span>
                    </a>
                    <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Transaksi & Laporan</div>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-receipt w-4 text-center"></i>
                        <span>Tagihan Siswa</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
                        <span>Transaksi PG</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-file-lines w-4 text-center"></i>
                        <span>Laporan SPP</span>
                    </a>
                @elseif(Auth::user()->role === 'kepala_sekolah')
                    <a href="{{ route('kepsek.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-amber-600 text-white font-semibold shadow-md shadow-amber-600/20">
                        <i class="fa-solid fa-chart-line w-4 text-center"></i>
                        <span>Dashboard Monitoring</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-user-graduate w-4 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-receipt w-4 text-center"></i>
                        <span>Monitoring Tagihan</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i>
                        <span>Laporan & Rekap</span>
                    </a>
                @elseif(Auth::user()->role === 'teller')
                    <a href="{{ route('teller.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-cyan-600 text-white font-semibold shadow-md shadow-cyan-600/20">
                        <i class="fa-solid fa-magnifying-glass-dollar w-4 text-center"></i>
                        <span>Layanan & Pencarian</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-print w-4 text-center"></i>
                        <span>Cetak Laporan</span>
                    </a>
                @elseif(Auth::user()->role === 'siswa')
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20">
                        <i class="fa-solid fa-wallet w-4 text-center"></i>
                        <span>Tagihan & Profil Saya</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
                        <span>Riwayat Pembayaran</span>
                    </a>
                @endif
            </nav>
        </div>

        <!-- Sidebar Footer & Logout -->
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 hover:text-rose-300 border border-rose-500/20 text-xs font-semibold transition cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100">
                    Sistem Uji Kompetensi Keahlian (LSP)
                </span>
                <span class="text-xs text-slate-400 hidden sm:inline">|</span>
                <span class="text-xs text-slate-500 hidden sm:inline">
                    Simulasi Payment Gateway & Virtual Account
                </span>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->nama }}</p>
                    <p class="text-[10px] text-slate-400">{{ Auth::user()->username }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Main Body Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-3 px-6 text-center text-xs text-slate-400 border-t border-slate-200 bg-white">
            &copy; {{ date('Y') }} SMK Bina Bangsa • Sistem Pembayaran SPP Berbasis Web
        </footer>
    </div>

</body>
</html>
