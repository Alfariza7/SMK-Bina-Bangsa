<!-- Sidebar Menu: SISWA -->
<a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('siswa.dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
    <i class="fa-solid fa-wallet w-4 text-center"></i>
    <span>Tagihan & Profil Saya</span>
</a>

<div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Histori</div>
<a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
    <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
    <span>Riwayat Pembayaran</span>
</a>
