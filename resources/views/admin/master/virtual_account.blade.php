@extends('layouts.app')

@section('title', 'Master Data Virtual Account')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Master Data Virtual Account</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar Nomor VA resmi (Prefix 88000 + 5 digit NIS siswa sesuai regulasi LSP)</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                <i class="fa-solid fa-credit-card"></i>
                <span>Total: {{ $vaList->count() }} Virtual Account</span>
            </span>
        </div>
    </div>

    <!-- Pencarian -->
    <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.va.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Nomor Virtual Account, NIS, atau Nama Siswa..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-search text-[10px]"></i>
                <span>Cari VA</span>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.va.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl text-xs transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tabel Virtual Account -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5 w-12 text-center">No</th>
                        <th class="py-3 px-5">Nomor Virtual Account</th>
                        <th class="py-3 px-5">Nama Siswa</th>
                        <th class="py-3 px-5">NIS (5 Digit Akhir)</th>
                        <th class="py-3 px-5">Kelas & Jurusan</th>
                        <th class="py-3 px-5">Status VA</th>
                        <th class="py-3 px-5 text-center">Simulasi Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($vaList as $idx => $va)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-5 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="py-3.5 px-5">
                                <span class="font-mono font-bold text-sm text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                                    {{ $va->nomor_va }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">
                                {{ $va->siswa->nama ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 font-mono font-bold text-slate-600">
                                {{ $va->siswa->nis ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                <span class="font-semibold text-slate-700">{{ $va->siswa->kelas->nama_kelas ?? '-' }}</span>
                                <span class="text-slate-400">({{ $va->siswa->kelas->jurusan->kode_jurusan ?? '-' }})</span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $va->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($va->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <a href="{{ route('payment.simulator', ['va' => $va->nomor_va]) }}" 
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-bold transition">
                                    <i class="fa-solid fa-bolt text-[10px]"></i>
                                    <span>Tes Bayar</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">Belum ada data Virtual Account.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
