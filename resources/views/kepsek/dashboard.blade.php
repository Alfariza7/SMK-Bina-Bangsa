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
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Jumlah Siswa Aktif</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($siswaAktif) }} Orang</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Penerimaan SPP</p>
                <h3 class="text-xl font-bold text-emerald-600 mt-0.5">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tunggakan SPP</p>
                <h3 class="text-xl font-bold text-rose-600 mt-0.5">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Siswa Status Lunas</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($jumlahSiswaLunas) }} Siswa</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Siswa Belum Bayar</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($jumlahSiswaBelumBayar) }} Siswa</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Siswa Menunggak</p>
                <h3 class="text-xl font-bold text-rose-600 mt-0.5">{{ number_format($jumlahSiswaMenunggak) }} Siswa</h3>
            </div>
        </div>
    </div>

    <!-- Grafik Monitoring (Poin R) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-500"></i>
                <span>Tren Penerimaan SPP Per Bulan</span>
            </h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Juli 2026</span>
                        <span class="font-bold text-emerald-600">Rp 1.400.000</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-3 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Agustus 2026</span>
                        <span class="font-bold text-emerald-600">Rp 1.400.000</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-3 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>September 2026</span>
                        <span class="font-bold text-emerald-600">Rp 700.000</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-3 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-rose-500"></i>
                <span>Komparasi Siswa Menunggak Per Bulan</span>
            </h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>September 2026 (Masih Berjalan)</span>
                        <span class="font-bold text-amber-600">2 Siswa Belum Bayar</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-3 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Oktober 2026 (Lewat Jatuh Tempo)</span>
                        <span class="font-bold text-rose-600">1 Siswa Menunggak</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-3 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
