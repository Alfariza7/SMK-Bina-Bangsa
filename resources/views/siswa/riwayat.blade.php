@extends('layouts.app')

@section('title', 'Riwayat Pembayaran SPP')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header & Ringkasan Identitas Siswa -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-indigo-600 mb-1">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>HISTORI & BUKTI BAYAR RESMI</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Riwayat Pembayaran SPP Siswa
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Catatan resmi seluruh tagihan, transaksi, dan kuitansi digital milik <strong class="text-slate-700">{{ $siswa->nama }}</strong> (NIS: <span class="font-mono font-semibold">{{ $siswa->nis }}</span>).
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('siswa.dashboard') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition shadow-xs">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Finansial Siswa -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Total Lunas -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Lunas Terbayar</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="mt-3 text-xl font-extrabold text-emerald-600">
                Rp {{ number_format($totalLunas, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Pembayaran terverifikasi lunas</p>
        </div>

        <!-- Total Tunggakan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tunggakan</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
            </div>
            <div class="mt-3 text-xl font-extrabold text-rose-600">
                Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Melewati tanggal akhir bulan</p>
        </div>

        <!-- Total Tagihan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Periode Tercatat</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <div class="mt-3 text-xl font-extrabold text-indigo-700">
                {{ $riwayatTagihan->count() }} <span class="text-xs font-medium text-slate-500">Bulan</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Tahun Ajaran {{ $siswa->tahunAjaran->tahun_ajaran ?? '2026/2027' }}</p>
        </div>
    </div>

    <!-- Tabel Riwayat Pembayaran Lengkap -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-indigo-600"></i>
                    <span>DAFTAR TRANSAKSI & STATUS TAGIHAN</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Filter dan telusuri bukti pembayaran untuk masing-masing periode</p>
            </div>

            <!-- Tab Filter Cepat (Client-side) -->
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl text-xs font-semibold self-start sm:self-auto">
                <button type="button" onclick="filterStatus('all')" id="btn-filter-all" class="filter-btn px-3 py-1 rounded-lg bg-white text-slate-800 shadow-xs">Semua</button>
                <button type="button" onclick="filterStatus('LUNAS')" id="btn-filter-lunas" class="filter-btn px-3 py-1 rounded-lg text-slate-500 hover:text-slate-800">Lunas</button>
                <button type="button" onclick="filterStatus('TUNGGAKAN')" id="btn-filter-tunggakan" class="filter-btn px-3 py-1 rounded-lg text-slate-500 hover:text-slate-800">Tunggakan</button>
                <button type="button" onclick="filterStatus('BELUM BAYAR')" id="btn-filter-belum" class="filter-btn px-3 py-1 rounded-lg text-slate-500 hover:text-slate-800">Belum Bayar</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5">Bulan & Tahun</th>
                        <th class="py-3 px-5">Nominal</th>
                        <th class="py-3 px-5">Jatuh Tempo</th>
                        <th class="py-3 px-5">Tanggal Pembayaran</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5">No. Transaksi / Referensi</th>
                        <th class="py-3 px-5 text-center">Bukti Kuitansi</th>
                    </tr>
                </thead>
                <tbody id="table-riwayat-body" class="divide-y divide-slate-100 text-slate-700">
                    @forelse($riwayatTagihan as $item)
                        @php
                            $pembayaran = $item->pembayaran;
                            $trx = $pembayaran ? $pembayaran->transaksiPaymentGateway : null;
                        @endphp
                        <tr class="item-row hover:bg-slate-50/80 transition" data-status="{{ $item->status }}">
                            <td class="py-3.5 px-5 font-semibold text-slate-800 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $item->status === 'LUNAS' ? 'bg-emerald-500' : ($item->status === 'TUNGGAKAN' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                    <span>{{ $item->bulan }} {{ $item->tahun }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-800 whitespace-nowrap">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                @if($item->status === 'LUNAS' && $pembayaran && $pembayaran->tanggal_pembayaran)
                                    <div class="text-emerald-700 font-medium inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-[10px] text-emerald-500"></i>
                                        <span>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y') }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $item->status === 'LUNAS' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $item->status === 'BELUM BAYAR' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $item->status === 'TUNGGAKAN' ? 'bg-rose-100 text-rose-700' : '' }}
                                ">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                @if($trx && $trx->transaction_id)
                                    <span class="font-bold text-slate-700">{{ $trx->transaction_id }}</span>
                                @elseif($pembayaran && $pembayaran->id_transaksi)
                                    <span class="font-bold text-slate-700">TRX-{{ $pembayaran->id_transaksi }}</span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                @if($item->status === 'LUNAS' && $pembayaran && $pembayaran->id_transaksi)
                                    <a href="{{ route('transaksi.kuitansi', $pembayaran->id_transaksi) }}" target="_blank"
                                       title="Buka Kuitansi Resmi"
                                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition">
                                        <i class="fa-solid fa-receipt text-[10px]"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                @else
                                    <span class="text-slate-300 text-[11px] italic">Belum tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Belum ada catatan riwayat pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Catatan & Kebijakan Hak Akses Siswa (Sesuai Poin O & W Dokumen LSP) -->
    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-xs text-slate-600 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-shield-halved text-xs"></i>
            </div>
            <div>
                <span class="font-bold text-slate-700">Integritas Data Transaksi:</span>
                <span class="text-slate-500">
                    Sistem 100% cashless. Pembayaran diverifikasi langsung oleh payment gateway bank via Nomor Virtual Account.
                </span>
            </div>
        </div>
        <div class="font-mono text-[11px] text-slate-400 shrink-0">
            VA Siswa: <strong class="text-slate-700">{{ $siswa->virtualAccount->nomor_va ?? ('88000'.$siswa->nis) }}</strong>
        </div>
    </div>
</div>

<script>
    function filterStatus(status) {
        // Update active class on buttons
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-white', 'text-slate-800', 'shadow-xs');
            btn.classList.add('text-slate-500');
        });

        if (status === 'all') {
            document.getElementById('btn-filter-all').classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            document.getElementById('btn-filter-all').classList.remove('text-slate-500');
        } else if (status === 'LUNAS') {
            document.getElementById('btn-filter-lunas').classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            document.getElementById('btn-filter-lunas').classList.remove('text-slate-500');
        } else if (status === 'TUNGGAKAN') {
            document.getElementById('btn-filter-tunggakan').classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            document.getElementById('btn-filter-tunggakan').classList.remove('text-slate-500');
        } else if (status === 'BELUM BAYAR') {
            document.getElementById('btn-filter-belum').classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            document.getElementById('btn-filter-belum').classList.remove('text-slate-500');
        }

        // Filter rows
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
