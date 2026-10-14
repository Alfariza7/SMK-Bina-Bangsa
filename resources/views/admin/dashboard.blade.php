@extends('layouts.app')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Dashboard Administrator</h1>
            <p class="text-xs text-slate-500 mt-1">Ringkasan data operasional pembayaran SPP SMK Bina Bangsa</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Tahun Ajaran 2026/2027 Aktif
            </span>
        </div>
    </div>

    <!-- 5 Ringkasan Metrik (Poin Q Soal) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Siswa</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($totalSiswa) }}</h3>
            </div>
        </div>

        <!-- Total Tagihan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tagihan</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($totalTagihan) }}</h3>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Terbayar</p>
                <h3 class="text-xl font-bold text-emerald-600 mt-0.5">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Total Tunggakan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tunggakan</p>
                <h3 class="text-xl font-bold text-rose-600 mt-0.5">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Transaksi Hari Ini</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($transaksiHariIni) }}</h3>
            </div>
        </div>
    </div>

    <!-- Visualisasi Grafik Pembayaran & Tunggakan (Poin Q) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-indigo-500"></i>
                    <span>Grafik Penerimaan SPP Per Bulan</span>
                </h2>
                <span class="text-[11px] text-slate-400">Tahun 2026</span>
            </div>
            <div class="space-y-3 pt-2">
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Juli 2026</span>
                        <span class="font-bold text-slate-700">Rp 1.400.000 (100%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Agustus 2026</span>
                        <span class="font-bold text-slate-700">Rp 1.400.000 (100%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>September 2026</span>
                        <span class="font-bold text-slate-700">Rp 700.000 (50%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-rose-500"></i>
                    <span>Grafik Status Tunggakan</span>
                </h2>
                <span class="text-[11px] text-slate-400">Tahun 2026</span>
            </div>
            <div class="space-y-3 pt-2">
                <div>
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span>Oktober 2026 (Jatuh Tempo Terlewati)</span>
                        <span class="font-bold text-rose-600">Rp 350.000 (1 Siswa)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-2.5 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
                <div class="p-3.5 bg-amber-50/70 border border-amber-200/80 rounded-xl mt-4">
                    <p class="text-xs text-amber-800 font-medium leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Sistem otomatis mengubah status tagihan menjadi <strong>TUNGGAKAN</strong> saat tanggal memasuki tanggal 1 bulan berikutnya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru (Poin Q) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                <span>Transaksi Payment Gateway Terbaru</span>
            </h2>
            <span class="text-xs text-slate-400">Otomatis via Webhook</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Transaction ID</th>
                        <th class="py-3 px-4">Nomor VA</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 font-mono font-medium">{{ $trx->transaction_id }}</td>
                            <td class="py-3 px-4 font-mono text-indigo-600 font-medium">{{ $trx->virtual_account }}</td>
                            <td class="py-3 px-4 font-medium">{{ $trx->siswa->nama ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ $trx->status_transaksi }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">
                                Belum ada transaksi tercatat. Demonstrasi Payment Gateway dapat dicoba di menu simulator.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
