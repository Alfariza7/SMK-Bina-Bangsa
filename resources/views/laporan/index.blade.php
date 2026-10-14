@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi SPP')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Laporan Rekapitulasi Pembayaran SPP</h1>
            <p class="text-xs text-slate-500 mt-1">Rekapitulasi transaksi penerimaan SPP dan monitoring status tunggakan siswa</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('laporan.cetak', request()->query()) }}" target="_blank" 
               class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm shadow-indigo-600/20 cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Dokumen Resmi (PDF/Print)</span>
            </a>
        </div>
    </div>

    <!-- Filter Form Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-filter text-indigo-500"></i>
            <span>Filter Laporan</span>
        </h2>
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas & Jurusan</label>
                <select name="id_kelas" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ request('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }} ({{ $kelas->jurusan->kode_jurusan ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                    <option value="">-- Semua Status --</option>
                    <option value="LUNAS" {{ request('status') === 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                    <option value="BELUM BAYAR" {{ request('status') === 'BELUM BAYAR' ? 'selected' : '' }}>BELUM BAYAR</option>
                    <option value="TUNGGAKAN" {{ request('status') === 'TUNGGAKAN' ? 'selected' : '' }}>TUNGGAKAN</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Jatuh Tempo Dari</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Jatuh Tempo Sampai</label>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
            </div>

            <div class="sm:col-span-2 lg:col-span-4 flex items-center justify-end gap-2 pt-2 border-t border-slate-100 mt-1">
                <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Reset Filter
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Metrics Card -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tagihan Terdata</p>
                <h3 class="text-lg font-black text-slate-800 mt-0.5">{{ $totalTagihan }} Tagihan</h3>
                <p class="text-[11px] font-semibold text-slate-500">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Penerimaan Lunas</p>
                <h3 class="text-lg font-black text-emerald-600 mt-0.5">Rp {{ number_format($nominalLunas, 0, ',', '.') }}</h3>
                <p class="text-[11px] font-semibold text-emerald-700">{{ $totalLunas }} Tagihan Lunas</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Sisa Tunggakan</p>
                <h3 class="text-lg font-black text-rose-600 mt-0.5">Rp {{ number_format($nominalTunggakan, 0, ',', '.') }}</h3>
                <p class="text-[11px] font-semibold text-rose-700">{{ $totalTunggakan }} Belum / Menunggak</p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-table-list text-slate-400"></i>
                <span>Daftar Rincian Tagihan & Transaksi SPP</span>
            </h2>
            <span class="text-xs text-slate-400">Menampilkan {{ $tagihanList->count() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Siswa (NIS)</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Virtual Account</th>
                        <th class="py-3 px-4">Bulan Tagihan</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi / Kuitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tagihanList as $index => $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <p class="font-bold text-slate-800">{{ $item->siswa->nama ?? '-' }}</p>
                                <span class="font-mono text-[11px] text-slate-400">NIS: {{ $item->siswa->nis ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-medium">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</span>
                                <span class="block text-[10px] text-slate-400">{{ $item->siswa->kelas->jurusan->kode_jurusan ?? '' }}</span>
                            </td>
                            <td class="py-3 px-4 font-mono font-medium text-indigo-600">
                                {{ $item->siswa->virtualAccount->nomor_va ?? '-' }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $item->bulan }} {{ $item->tahun }}
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-800">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4">
                                @if($item->status === 'LUNAS')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                        LUNAS
                                    </span>
                                @elseif($item->status === 'TUNGGAKAN')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                                        TUNGGAKAN
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                                        BELUM BAYAR
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($item->status === 'LUNAS' && $item->pembayaran && $item->pembayaran->id_transaksi)
                                    <a href="{{ route('transaksi.kuitansi', $item->pembayaran->id_transaksi) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-[11px] font-bold transition">
                                        <i class="fa-solid fa-receipt text-[10px]"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                @else
                                    <span class="text-slate-300 text-[11px]">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">
                                Tidak ada data tagihan yang sesuai dengan filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
