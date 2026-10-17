@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $transaksi->transaction_id)

@section('content')
<div class="space-y-6">
    <!-- Header Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat Transaksi</span>
        </a>
        @if($transaksi->status_transaksi === 'PAID')
            <a href="{{ route('transaksi.kuitansi', $transaksi->id_transaksi) }}" target="_blank"
               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Kuitansi Resmi</span>
            </a>
        @endif
    </div>

    <!-- Status Banner -->
    <div class="p-6 rounded-3xl text-white shadow-xl relative overflow-hidden
        {{ $transaksi->status_transaksi === 'PAID' ? 'bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900' : 'bg-gradient-to-r from-rose-900 via-rose-950 to-slate-900' }}
    ">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider block text-slate-300">Detail Transaksi Payment Gateway</span>
                <h1 class="text-2xl sm:text-3xl font-black mt-1 font-mono tracking-tight">{{ $transaksi->transaction_id }}</h1>
                <p class="text-xs text-slate-200 mt-1">
                    Virtual Account: <span class="font-mono font-bold">{{ $transaksi->virtual_account }}</span> • Siswa: <span class="font-bold">{{ $transaksi->siswa->nama ?? '-' }}</span>
                </p>
            </div>
            <div class="text-right shrink-0">
                <span class="text-[11px] text-slate-300 block">Nominal Pembayaran</span>
                <span class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                </span>
                <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-bold uppercase
                    {{ $transaksi->status_transaksi === 'PAID' ? 'bg-emerald-400/20 text-emerald-200 border border-emerald-400/30' : 'bg-rose-400/20 text-rose-200 border border-rose-400/30' }}
                ">
                    Status: {{ $transaksi->status_transaksi }}
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Transaksi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3 text-xs">
            <h2 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-receipt text-indigo-600"></i>
                <span>Parameter Transaksi Perbankan</span>
            </h2>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Transaction ID</span>
                <span class="font-mono font-bold text-slate-800">{{ $transaksi->transaction_id }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Nomor Virtual Account</span>
                <span class="font-mono font-bold text-indigo-600">{{ $transaksi->virtual_account }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Kanal Pembayaran</span>
                <span class="font-mono text-slate-800">{{ $transaksi->payment_channel ?? 'VIRTUAL_ACCOUNT' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Nomor Referensi Bank</span>
                <span class="font-mono text-slate-800">{{ $transaksi->reference_number ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Tanggal Transaksi</span>
                <span class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y') }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-slate-500">Waktu Pembayaran</span>
                <span class="font-mono font-medium text-slate-800">{{ $transaksi->waktu_transaksi }} WIB</span>
            </div>
        </div>

        <!-- Informasi Siswa & Tagihan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3 text-xs">
            <h2 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-user-graduate text-indigo-600"></i>
                <span>Data Siswa Terkait</span>
            </h2>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Nama Siswa</span>
                <span class="font-bold text-slate-800">{{ $transaksi->siswa->nama ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">NIS / NISN</span>
                <span class="font-mono text-slate-800">{{ $transaksi->siswa->nis ?? '-' }} / {{ $transaksi->siswa->nisn ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Kelas & Jurusan</span>
                <span class="font-semibold text-slate-800">{{ $transaksi->siswa->kelas->nama_kelas ?? '-' }} ({{ $transaksi->siswa->kelas->jurusan->nama_jurusan ?? '-' }})</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-50">
                <span class="text-slate-500">Tagihan Yang Dilunasi</span>
                <span class="font-bold text-emerald-700">
                    {{ $transaksi->pembayaran->tagihanSpp->bulan ?? '-' }} {{ $transaksi->pembayaran->tagihanSpp->tahun ?? '' }}
                </span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-slate-500">Status Tagihan Sekarang</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                    {{ $transaksi->pembayaran->tagihanSpp->status ?? 'LUNAS' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Raw Webhook Payload Callback (Poin W & H) -->
    <div class="bg-slate-900 rounded-2xl p-5 text-white shadow-sm border border-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
            <span class="text-xs font-bold text-slate-300 flex items-center gap-2">
                <i class="fa-solid fa-code text-indigo-400"></i>
                <span>Payload Callback Webhook (JSON Asli Dari Payment Gateway)</span>
            </span>
            <span class="text-[10px] text-slate-500 font-mono">Immutable Audit Trail</span>
        </div>
        <pre class="font-mono text-xs text-indigo-200 bg-slate-950/80 p-4 rounded-xl overflow-x-auto">{{ json_encode($transaksi->raw_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '// Tidak ada payload mentah' }}</pre>
    </div>
</div>
@endsection
