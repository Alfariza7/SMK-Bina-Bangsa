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

        <!-- Nav Links according to Role (Modular Per-Role Components) -->
        <nav class="px-3 pt-3 space-y-1 text-xs font-semibold">
            @if(Auth::check() && view()->exists('components.sidebar.' . Auth::user()->role))
                @include('components.sidebar.' . Auth::user()->role)
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition">
                    <i class="fa-solid fa-arrow-right-to-bracket w-4 text-center"></i>
                    <span>Halaman Login</span>
                </a>
                <div class="pt-4 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Demo LSP</div>
                <a href="{{ route('payment.simulator') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('payment.simulator') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-slate-800/80 transition' }}">
                    <i class="fa-solid fa-bolt text-amber-400 w-4 text-center"></i>
                    <span>Simulator & Webhook</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- Sidebar Clean Footer Info -->
    <div class="p-4 border-t border-slate-800/60 text-center">
        <p class="text-[10px] text-slate-500 font-medium">SMK Bina Bangsa &copy; {{ date('Y') }}</p>
    </div>
</aside>
