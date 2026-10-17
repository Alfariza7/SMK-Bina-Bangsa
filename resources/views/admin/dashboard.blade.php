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
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Siswa</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                {{ number_format($totalSiswa) }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
            </h3>
        </div>

        <!-- Total Tagihan -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Tagihan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                {{ number_format($totalTagihan) }} <span class="text-xs font-semibold text-slate-400">Invoice</span>
            </h3>
        </div>

        <!-- Total Pembayaran -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Terbayar</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <h3 class="text-lg font-black text-emerald-600 tracking-tight whitespace-nowrap">
                Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
            </h3>
        </div>

        <!-- Total Tunggakan -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Tunggakan</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <h3 class="text-lg font-black text-rose-600 tracking-tight whitespace-nowrap">
                Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
            </h3>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500">Total Transaksi</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight whitespace-nowrap">
                    {{ number_format($totalTransaksi) }} <span class="text-xs font-semibold text-slate-400">Trx</span>
                </h3>
                <span class="text-[10px] text-amber-600 font-semibold block mt-0.5">
                    +{{ number_format($transaksiHariIni) }} Transaksi Hari Ini
                </span>
            </div>
        </div>
    </div>

    <!-- Visualisasi Grafik Pembayaran & Tunggakan (Poin Q) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Penerimaan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-indigo-500"></i>
                    <span>Grafik Penerimaan SPP Per Bulan</span>
                </h2>
                <span class="text-[11px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Lunas</span>
            </div>
            <div class="space-y-3 pt-2">
                @forelse($penerimaanPerBulan as $penerimaan)
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1">
                            <span class="font-semibold text-slate-700">{{ $penerimaan->bulan }} {{ $penerimaan->tahun }}</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($penerimaan->total_nominal, 0, ',', '.') }} ({{ $penerimaan->jumlah_siswa }} Siswa)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada penerimaan pembayaran yang tercatat.</p>
                @endforelse
            </div>
        </div>

        <!-- Grafik Status Tunggakan (100% Sinkron dengan Total Tunggakan) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-rose-500"></i>
                    <span>Grafik Status Tunggakan SPP</span>
                </h2>
                <span class="text-[11px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                    Total: {{ $totalSiswaMenunggak ?? 0 }} Siswa
                </span>
            </div>
            <div class="space-y-3 pt-2">
                @forelse($tunggakanPerBulan as $tunggak)
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1">
                            <span class="font-semibold text-slate-700">{{ $tunggak->bulan }} {{ $tunggak->tahun }} (Lewat Jatuh Tempo)</span>
                            <span class="font-bold text-rose-600">Rp {{ number_format($tunggak->total_nominal, 0, ',', '.') }} ({{ $tunggak->jumlah_siswa }} Siswa)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-2.5 rounded-full" style="width: {{ $totalTunggakan > 0 ? min(100, round(($tunggak->total_nominal / $totalTunggakan) * 100)) : 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-700 text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>Tertib! Tidak ada data tunggakan SPP tercatat saat ini.</span>
                    </div>
                @endforelse

                <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-xl mt-4">
                    <p class="text-[11px] text-amber-800 font-medium leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Sistem otomatis mengubah status tagihan menjadi <strong>TUNGGAKAN</strong> saat tanggal memasuki tanggal 1 bulan berikutnya setelah jatuh tempo.
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
                        <th class="py-3 px-4 text-center">Kuitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 font-mono font-medium">{{ $trx->transaction_id }}</td>
                            <td class="py-3 px-4 font-mono text-indigo-600 font-medium">{{ $trx->virtual_account }}</td>
                            <td class="py-3 px-4 font-medium">{{ $trx->siswa->nama ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $trx->waktu_formatted }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ $trx->status_transaksi }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('transaksi.kuitansi', $trx->id_transaksi) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition">
                                    <i class="fa-solid fa-print text-[10px]"></i>
                                    <span>Cetak</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">
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
