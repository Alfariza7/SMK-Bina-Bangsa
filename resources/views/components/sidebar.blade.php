<!-- Component: Master Sidebar (Fixed / Frozen Left Panel) -->
<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 h-screen border-r border-slate-800 shadow-xl z-40 overflow-y-auto">
    <div>
        <!-- School Brand Header -->
        <div class="p-5 border-b border-slate-800/80 flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-white p-1 flex items-center justify-center shadow-md shadow-indigo-950/40 shrink-0 ring-1 ring-white/20">
                <img src="{{ asset('images/logo-smk-cropped.png') }}" alt="Logo SMK Bina Bangsa" class="w-full h-full object-contain">
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
                {{ (Auth::user()?->role ?? '') === 'admin' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : '' }}
                {{ (Auth::user()?->role ?? '') === 'kepala_sekolah' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                {{ (Auth::user()?->role ?? '') === 'teller' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : '' }}
                {{ (Auth::user()?->role ?? '') === 'siswa' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
                {{ !Auth::check() ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : '' }}
            ">
                {{ Auth::check() ? str_replace('_', ' ', Auth::user()->role) : 'PENGUJI / ASESOR' }}
            </span>
        </div>

        <!-- Nav Links according to Role (Modular Per-Role Components) -->
        <nav class="px-3 space-y-1 text-xs font-semibold">
            @if(Auth::check() && view()->exists('components.sidebar.' . Auth::user()->role))
                @include('components.sidebar.' . Auth::user()->role)
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                    <i class="fa-solid fa-arrow-right-to-bracket w-4 text-center"></i>
                    <span>Halaman Login</span>
                </a>
            @endif

            <!-- Link Universal Simulator Payment Gateway -->
            <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Gateway Simulator</div>
            <a href="{{ route('payment.simulator') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('payment.simulator') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
                <i class="fa-solid fa-bolt text-amber-400 w-4 text-center"></i>
                <span>Simulator & Webhook</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Clean Footer Info -->
    <div class="p-4 border-t border-slate-800/60 text-center">
        <p class="text-[10px] text-slate-500 font-medium">SMK Bina Bangsa &copy; {{ date('Y') }}</p>
    </div>
</aside>
