<!-- Sidebar Menu: KEPALA SEKOLAH -->
<a href="{{ route('kepsek.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('kepsek.dashboard') ? 'bg-amber-600 text-white shadow-md shadow-amber-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-chart-line w-4 text-center"></i>
    <span>Dashboard Monitoring</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Monitoring & Laporan</div>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-user-graduate w-4 text-center"></i>
    <span>Data Siswa</span>
</a>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-receipt w-4 text-center"></i>
    <span>Monitoring Tagihan</span>
</a>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
    <span>Monitoring Transaksi</span>
</a>
<a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'bg-amber-600 text-white shadow-md shadow-amber-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i>
    <span>Laporan Rekap</span>
</a>
