<!-- Sidebar Menu: TELLER -->
<a href="{{ route('teller.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('teller.dashboard') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-magnifying-glass-dollar w-4 text-center"></i>
    <span>Layanan & Pencarian</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Layanan Transaksi</div>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
    <span>Riwayat Transaksi</span>
</a>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-print w-4 text-center"></i>
    <span>Cetak Laporan</span>
</a>
