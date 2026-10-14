@extends('layouts.app')

@section('title', 'Layanan Teller')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Layanan & Informasi Siswa (Teller)</h1>
            <p class="text-xs text-slate-500 mt-1">Pencarian informasi tagihan dan status transaksi siswa</p>
        </div>
        <div class="px-3.5 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>Tidak Melayani Tunai & Tidak Ada Ubah Status Manual</span>
        </div>
    </div>

    <!-- Ringkasan Metrik Hari Ini (Poin S) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Transaksi Hari Ini</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ number_format($transaksiHariIni) }} Transaksi</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Nominal Transaksi Hari Ini</p>
                <h3 class="text-xl font-bold text-emerald-600 mt-0.5">Rp {{ number_format($nominalHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Kanal Pembayaran</p>
                <h3 class="text-sm font-bold text-indigo-700 mt-1">100% Virtual Account</h3>
            </div>
        </div>
    </div>

    <!-- Form Pencarian Cepat (Poin S & V) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <h2 class="text-sm font-bold text-slate-800 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass text-indigo-600"></i>
            <span>Pencarian Cepat Siswa & Status Pembayaran</span>
        </h2>
        <p class="text-xs text-slate-500 mb-4">
            Cari data siswa berdasarkan <strong>Nomor Virtual Account (VA)</strong>, <strong>NIS</strong>, atau <strong>Nama Siswa</strong>.
        </p>

        <form action="{{ route('teller.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" 
                       name="keyword" 
                       value="{{ $keyword }}" 
                       placeholder="Masukkan Nomor VA (contoh: 8800012345) atau NIS (12345)..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition font-mono">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-search text-xs"></i>
                <span>Cari Data</span>
            </button>
            @if($keyword)
                <a href="{{ route('teller.dashboard') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl text-sm transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>

        <!-- Hasil Pencarian (Format Sesuai Poin V Soal) -->
        @if($keyword)
            <div class="mt-6 pt-5 border-t border-slate-100">
                @if($searchResult)
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/80 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                            <div>
                                <h3 class="text-base font-bold text-slate-800">{{ $searchResult->nama }}</h3>
                                <p class="text-xs text-slate-500 font-mono">NIS: {{ $searchResult->nis }} • NISN: {{ $searchResult->nisn }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[11px] text-slate-400 block">Nomor Virtual Account</span>
                                <span class="text-sm font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100">
                                    {{ $searchResult->virtualAccount->nomor_va ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Data Kelas & Kontak -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block">Kelas:</span>
                                <span class="font-semibold text-slate-700">{{ $searchResult->kelas->nama_kelas ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Jurusan:</span>
                                <span class="font-semibold text-slate-700">{{ $searchResult->kelas->jurusan->nama_jurusan ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nama Orang Tua:</span>
                                <span class="font-semibold text-slate-700">{{ $searchResult->nama_orang_tua ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">No. HP:</span>
                                <span class="font-semibold text-slate-700">{{ $searchResult->no_hp ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Status Tagihan Per Bulan (Poin V) -->
                        <div class="pt-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Rincian Status Tagihan SPP</h4>
                            <div class="space-y-2">
                                @forelse($searchResult->tagihanSpp as $tagihan)
                                    <div class="p-3 bg-white rounded-lg border border-slate-200 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full 
                                                {{ $tagihan->status === 'LUNAS' ? 'bg-emerald-500' : '' }}
                                                {{ $tagihan->status === 'BELUM BAYAR' ? 'bg-amber-500' : '' }}
                                                {{ $tagihan->status === 'TUNGGAKAN' ? 'bg-rose-500' : '' }}
                                            "></span>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
                                                <p class="text-[11px] text-slate-400">Jatuh Tempo: {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-xs font-semibold text-slate-700">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</span>
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold
                                                {{ $tagihan->status === 'LUNAS' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                {{ $tagihan->status === 'BELUM BAYAR' ? 'bg-amber-100 text-amber-700' : '' }}
                                                {{ $tagihan->status === 'TUNGGAKAN' ? 'bg-rose-100 text-rose-700' : '' }}
                                            ">
                                                {{ $tagihan->status }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">Belum ada tagihan dibuat untuk siswa ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>Data tidak ditemukan untuk kata kunci: "<strong>{{ $keyword }}</strong>". Pastikan NIS atau Nomor VA sudah benar.</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Transaksi Terbaru (Poin S) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                <span>Transaksi Terbaru (Payment Gateway)</span>
            </h2>
            <span class="text-xs text-slate-400">Monitoring Realtime</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Transaction ID</th>
                        <th class="py-3 px-4">Virtual Account</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Nominal</th>
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
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ $trx->status_transaksi }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">
                                Belum ada transaksi terbaru hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
