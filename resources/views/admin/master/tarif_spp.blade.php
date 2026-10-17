@extends('layouts.app')

@section('title', 'Master Data Tarif SPP')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Master Data Tarif SPP</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar besaran nominal SPP reguler per tahun ajaran</p>
        </div>
    </div>

    <!-- Tabel Tarif SPP -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5">Tahun Ajaran</th>
                        <th class="py-3 px-5">Nominal Tarif SPP</th>
                        <th class="py-3 px-5">Keterangan</th>
                        <th class="py-3 px-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tarifList as $tarif)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-5 font-bold text-slate-800">
                                {{ $tarif->tahunAjaran->tahun_ajaran ?? '2026/2027' }}
                            </td>
                            <td class="py-4 px-5 font-black text-indigo-700 text-base">
                                Rp {{ number_format($tarif->nominal, 0, ',', '.') }}
                                <span class="text-[11px] font-normal text-slate-400">/ bulan</span>
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                {{ $tarif->keterangan ?? 'Tarif SPP Reguler' }}
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ ucfirst($tarif->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">Belum ada data tarif SPP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
