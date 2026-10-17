@extends('layouts.app')

@section('title', 'Transaksi Payment Gateway & VA')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Transaksi Payment Gateway & VA</h1>
            <p class="text-xs text-slate-500 mt-1">Histori transaksi digital otomatis melalui sinyal Callback Webhook perbankan</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                100% Cashless • Real-Time Logging
            </span>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Transaksi -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Total Transaksi</span>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ number_format($totalTransaksi) }} Trx</h3>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Transaksi Berhasil (PAID)</span>
            <h3 class="text-xl font-black text-emerald-600 mt-1">{{ number_format($totalPaid) }} Trx</h3>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Nominal Terverifikasi</span>
            <h3 class="text-base sm:text-lg font-black text-indigo-700 mt-1">Rp {{ number_format($totalNominalPaid, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Transaksi Ditolak/Gagal</span>
            <h3 class="text-xl font-black text-rose-600 mt-1">{{ number_format($totalFailed) }} Trx</h3>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('transaksi.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
            <!-- Filter Status -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Status Transaksi</label>
                <select name="status" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="PAID" {{ request('status') === 'PAID' ? 'selected' : '' }}>PAID (Berhasil)</option>
                    <option value="FAILED" {{ request('status') === 'FAILED' ? 'selected' : '' }}>FAILED (Gagal)</option>
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Tanggal Transaksi</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 text-xs">
            </div>

            <!-- Search -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Transaction ID / VA / Siswa..." 
                       class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono text-xs">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['status', 'tanggal', 'search']))
                    <a href="{{ route('transaksi.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Transaksi Payment Gateway -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Transaction ID</th>
                        <th class="py-3 px-4">Nomor VA</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Kanal / Bank</th>
                        <th class="py-3 px-4">Waktu Transaksi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($transaksiList as $trx)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-4 font-mono font-semibold text-slate-800">
                                {{ $trx->transaction_id }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">
                                {{ $trx->virtual_account }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $trx->siswa->nama ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $trx->siswa->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-black text-slate-800">
                                Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $trx->payment_channel ?? 'VIRTUAL_ACCOUNT' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $trx->waktu_formatted }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $trx->status_transaksi === 'PAID' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}
                                ">
                                    {{ $trx->status_transaksi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('transaksi.show', $trx->id_transaksi) }}" 
                                       class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </a>
                                    @if($trx->status_transaksi === 'PAID')
                                        <a href="{{ route('transaksi.kuitansi', $trx->id_transaksi) }}" target="_blank"
                                           class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-[11px] font-bold transition">
                                            <i class="fa-solid fa-print text-[10px]"></i>
                                            <span>Kuitansi</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">
                                Belum ada transaksi yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
