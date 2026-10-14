<!-- Sidebar Menu: ADMINISTRATOR -->
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-chart-pie w-4 text-center"></i>
    <span>Dashboard</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Master Data</div>
<a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-users-gear w-4 text-center"></i>
    <span>Data Pengguna (User)</span>
</a>
<a href="#" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-calendar-days w-4 text-center"></i>
    <span>Tahun Ajaran</span>
</a>
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

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Transaksi & Laporan</div>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-receipt w-4 text-center"></i>
    <span>Tagihan Siswa</span>
</a>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
    <span>Transaksi PG</span>
</a>
<a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-file-lines w-4 text-center"></i>
    <span>Laporan SPP</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Developer & Demo LSP</div>
<a href="{{ route('payment.simulator') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('payment.simulator') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-bolt text-amber-400 w-4 text-center"></i>
    <span>Simulator & Webhook</span>
</a>
