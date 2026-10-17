@extends('layouts.app')

@section('title', 'Monitoring Kepala Sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Monitoring & Evaluasi SPP</h1>
            <p class="text-xs text-slate-500 mt-1">Laporan eksekutif penerimaan SPP siswa SMK Bina Bangsa</p>
        </div>
        <div class="px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-eye"></i>
            <span>Mode Monitoring Eksekutif</span>
        </div>
    </div>

    <!-- 6 Metrik Eksekutif (Poin R Soal) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Siswa Aktif -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Jumlah Siswa Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                {{ number_format($siswaAktif) }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
            </h3>
        </div>

        <!-- Total Penerimaan -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Penerimaan SPP</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
            </div>
            <h3 class="text-lg font-black text-emerald-600 tracking-tight whitespace-nowrap">
                Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}
            </h3>
        </div>

        <!-- Total Tunggakan -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Tunggakan SPP</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <h3 class="text-lg font-black text-rose-600 tracking-tight whitespace-nowrap">
                Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
            </h3>
        </div>

        <!-- Siswa Status Lunas -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Siswa Status Lunas</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                {{ number_format($jumlahSiswaLunas) }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
            </h3>
        </div>

        <!-- Siswa Belum Bayar -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Siswa Belum Bayar</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                {{ number_format($jumlahSiswaBelumBayar) }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
            </h3>
        </div>

        <!-- Siswa Menunggak -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Siswa Menunggak</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-rose-600 tracking-tight whitespace-nowrap">
                {{ number_format($jumlahSiswaMenunggak) }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
            </h3>
        </div>
    </div>

    <!-- Grafik Monitoring (Poin R) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tren Penerimaan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-500"></i>
                    <span>Tren Penerimaan SPP Per Bulan</span>
                </h2>
                <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Terkonfirmasi</span>
            </div>
            <div class="space-y-4">
                @forelse($trenPenerimaan as $item)
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1">
                            <span class="font-semibold text-slate-700">{{ $item->bulan }} {{ $item->tahun }}</span>
                            <span class="font-bold text-emerald-600">Rp {{ number_format($item->total_nominal, 0, ',', '.') }} ({{ $item->jumlah_siswa }} Siswa)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-3 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada penerimaan pembayaran tercatat.</p>
                @endforelse
            </div>
        </div>

        <!-- Komparasi Siswa Menunggak (100% Sinkron dengan Metrik) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-rose-500"></i>
                    <span>Komparasi Siswa Menunggak Per Bulan</span>
                </h2>
                <span class="text-[11px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                    {{ $jumlahSiswaMenunggak }} Siswa Menunggak
                </span>
            </div>
            <div class="space-y-4">
                @forelse($komparasiTunggakan as $tunggak)
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1">
                            <span class="font-semibold text-slate-700">{{ $tunggak->bulan }} {{ $tunggak->tahun }} (Lewat Jatuh Tempo)</span>
                            <span class="font-bold text-rose-600">{{ $tunggak->jumlah_siswa }} Siswa • Rp {{ number_format($tunggak->total_nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-3 rounded-full" style="width: {{ $totalTunggakan > 0 ? min(100, round(($tunggak->total_nominal / $totalTunggakan) * 100)) : 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-700 text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>Seluruh siswa tertib membayar SPP. Tidak ada data tunggakan.</span>
                    </div>
                @endforelse

                <div class="p-3.5 bg-amber-50/70 border border-amber-200/80 rounded-xl mt-4">
                    <p class="text-[11px] text-amber-800 font-medium leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        <strong>Pengingat:</strong> Setiap tagihan SPP akan jatuh tempo di akhir bulan. Tagihan yang belum lunas otomatis berstatus <strong>TUNGGAKAN</strong> saat awal bulan berikutnya.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
