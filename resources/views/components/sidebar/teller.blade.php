<!-- Sidebar Menu: TELLER -->
<a href="{{ route('teller.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('teller.dashboard') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-magnifying-glass-dollar w-4 text-center"></i>
    <span>Layanan & Pencarian</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Layanan Siswa & Data</div>
<a href="{{ route('master.siswa.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('master.siswa.*') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-user-graduate w-4 text-center"></i>
    <span>Data Siswa & VA</span>
</a>
<a href="{{ route('tagihan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('tagihan.*') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i>
    <span>Tagihan & Tunggakan</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Layanan Transaksi</div>
<a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('transaksi.*') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
    <span>Riwayat Transaksi</span>
</a>
<a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-print w-4 text-center"></i>
    <span>Cetak Laporan</span>
</a>

