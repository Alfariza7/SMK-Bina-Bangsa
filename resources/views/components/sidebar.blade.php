<!-- Component: Master Sidebar (Fixed / Frozen Left Panel) -->
<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 h-screen border-r border-slate-800 shadow-xl z-40 overflow-y-auto">
    <div>
        <!-- School Brand Header -->
        <div class="p-5 border-b border-slate-800/80 flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-600/30">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-sm text-white leading-tight">SMK BINA BANGSA</h2>
                <span class="text-[10px] text-indigo-400 font-semibold tracking-wider uppercase">Portal SPP Digital</span>
            </div>
        </div>

        <!-- Role Indicator Pill -->
        <div class="px-4 py-3 mx-3 my-3 bg-slate-800/50 rounded-2xl border border-slate-700/40 flex items-center justify-between">
            <span class="text-[11px] font-medium text-slate-400">Hak Akses:</span>
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                {{ Auth::user()->role === 'admin' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : '' }}
                {{ Auth::user()->role === 'kepala_sekolah' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                {{ Auth::user()->role === 'teller' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : '' }}
                {{ Auth::user()->role === 'siswa' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
            ">
                {{ str_replace('_', ' ', Auth::user()->role) }}
            </span>
        </div>

        <!-- Nav Links according to Role (Modular Per-Role Components) -->
        <nav class="px-3 space-y-1 text-xs font-semibold">
            @if(view()->exists('components.sidebar.' . Auth::user()->role))
                @include('components.sidebar.' . Auth::user()->role)
            @endif
        </nav>
    </div>

    <!-- Sidebar Clean Footer Info -->
    <div class="p-4 border-t border-slate-800/60 text-center">
        <p class="text-[10px] text-slate-500 font-medium">SMK Bina Bangsa &copy; {{ date('Y') }}</p>
    </div>
</aside>
