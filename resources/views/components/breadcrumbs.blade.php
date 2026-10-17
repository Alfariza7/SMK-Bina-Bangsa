@php
    $user = Auth::user();
    $role = $user->role ?? 'guest';
    
    // Tentukan URL Home sesuai peran pengguna
    $homeUrl = route('login');
    if ($role === 'admin') {
        $homeUrl = route('admin.dashboard');
    } elseif ($role === 'kepala_sekolah') {
        $homeUrl = route('kepsek.dashboard');
    } elseif ($role === 'teller') {
        $homeUrl = route('teller.dashboard');
    } elseif ($role === 'siswa') {
        $homeUrl = route('siswa.dashboard');
    }

    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $category = null;
    $categoryUrl = null;
    $currentPage = 'Dashboard';
    $currentIcon = 'fa-solid fa-house';

    // Pemetaan rute ke breadcrumbs terstruktur
    if ($currentRoute === 'admin.dashboard') {
        $currentPage = 'Dashboard Admin';
        $currentIcon = 'fa-solid fa-gauge-high';
    } elseif ($currentRoute === 'kepsek.dashboard') {
        $currentPage = 'Dashboard Eksekutif';
        $currentIcon = 'fa-solid fa-chart-line';
    } elseif ($currentRoute === 'teller.dashboard') {
        $currentPage = 'Layanan & Pencarian';
        $currentIcon = 'fa-solid fa-magnifying-glass-dollar';
    } elseif ($currentRoute === 'siswa.dashboard') {
        $currentPage = 'Tagihan & Profil Saya';
        $currentIcon = 'fa-solid fa-wallet';
    } elseif ($currentRoute === 'admin.users.index') {
        $category = 'Master Data';
        $currentPage = 'Data Pengguna';
        $currentIcon = 'fa-solid fa-users-gear';
    } elseif ($currentRoute === 'admin.kelas.index') {
        $category = 'Master Data';
        $currentPage = 'Data Kelas';
        $currentIcon = 'fa-solid fa-chalkboard-user';
    } elseif ($currentRoute === 'admin.jurusan.index') {
        $category = 'Master Data';
        $currentPage = 'Data Jurusan';
        $currentIcon = 'fa-solid fa-graduation-cap';
    } elseif ($currentRoute === 'admin.tahun_ajaran.index') {
        $category = 'Master Data';
        $currentPage = 'Tahun Ajaran';
        $currentIcon = 'fa-solid fa-calendar-days';
    } elseif ($currentRoute === 'admin.tarif_spp.index') {
        $category = 'Master Data';
        $currentPage = 'Tarif SPP';
        $currentIcon = 'fa-solid fa-tags';
    } elseif ($currentRoute === 'admin.va.index') {
        $category = 'Master Data';
        $currentPage = 'Virtual Account';
        $currentIcon = 'fa-solid fa-credit-card';
    } elseif ($currentRoute === 'master.siswa.index') {
        $category = 'Data Siswa';
        $currentPage = 'Daftar Siswa & VA';
        $currentIcon = 'fa-solid fa-user-graduate';
    } elseif ($currentRoute === 'master.siswa.show') {
        $category = 'Data Siswa';
        $categoryUrl = route('master.siswa.index');
        $currentPage = 'Detail Profil Siswa';
        $currentIcon = 'fa-solid fa-id-card';
    } elseif ($currentRoute === 'tagihan.index') {
        $category = 'Keuangan';
        $currentPage = 'Monitoring Tagihan & Tunggakan';
        $currentIcon = 'fa-solid fa-file-invoice-dollar';
    } elseif ($currentRoute === 'transaksi.index') {
        $category = 'Transaksi';
        $currentPage = 'Riwayat Transaksi PG & VA';
        $currentIcon = 'fa-solid fa-clock-rotate-left';
    } elseif ($currentRoute === 'transaksi.show') {
        $category = 'Transaksi';
        $categoryUrl = route('transaksi.index');
        $currentPage = 'Detail Transaksi';
        $currentIcon = 'fa-solid fa-receipt';
    } elseif ($currentRoute === 'laporan.index') {
        $category = 'Laporan';
        $currentPage = 'Rekapitulasi Pembayaran';
        $currentIcon = 'fa-solid fa-print';
    } elseif ($currentRoute === 'transaksi.kuitansi') {
        $category = 'Transaksi';
        $categoryUrl = route('transaksi.index');
        $currentPage = 'Kuitansi Digital';
        $currentIcon = 'fa-solid fa-receipt';
    } else {
        $currentPage = trim($__env->yieldContent('title', 'Halaman'));
        $currentIcon = 'fa-solid fa-layer-group';
    }
@endphp

<nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs">
    <!-- 1. Home / Root Icon -->
    <a href="{{ $homeUrl }}" 
       title="Kembali ke Dashboard Utama" 
       class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-600 hover:text-slate-900 transition-colors shadow-xs shrink-0">
        <i class="fa-solid fa-house text-xs"></i>
    </a>

    <!-- Separator -->
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 shrink-0"></i>

    <!-- 2. Kategori Induk (Jika Ada) -->
    @if($category)
        @if($categoryUrl)
            <a href="{{ $categoryUrl }}" class="text-slate-500 hover:text-slate-900 font-medium transition-colors hidden sm:inline-block">
                {{ $category }}
            </a>
        @else
            <span class="text-slate-500 font-medium hidden sm:inline-block">
                {{ $category }}
            </span>
        @endif
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 shrink-0 hidden sm:inline-block"></i>
    @endif

    <!-- 3. Active Breadcrumb Filled Background Pill (Sesuai Referensi Dribbble) -->
    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-indigo-50/80 border border-indigo-100/90 text-indigo-700 font-bold text-xs shadow-xs">
        <i class="{{ $currentIcon }} text-indigo-500 text-[11px]"></i>
        <span class="tracking-tight">{{ $currentPage }}</span>
    </div>
</nav>
