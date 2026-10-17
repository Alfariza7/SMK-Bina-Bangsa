@extends('layouts.app')

@section('title', 'Data Tagihan & Tunggakan SPP')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Tagihan & Tunggakan SPP</h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring status tagihan seluruh siswa (Lunas, Belum Bayar, dan Tunggakan)</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Tunggakan: Rp {{ number_format($nominalTunggakan, 0, ',', '.') }}</span>
            </span>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Tagihan -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Total Tagihan</span>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ number_format($totalTagihan) }} Invoice</h3>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Tagihan Lunas</span>
            <h3 class="text-xl font-black text-emerald-600 mt-1">{{ number_format($totalLunas) }} Invoice</h3>
            <span class="text-[10px] text-emerald-600 font-semibold">Rp {{ number_format($nominalLunas, 0, ',', '.') }}</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Belum Bayar (Aktif)</span>
            <h3 class="text-xl font-black text-amber-600 mt-1">{{ number_format($totalBelumBayar) }} Invoice</h3>
            <span class="text-[10px] text-amber-600 font-semibold">Rp {{ number_format($nominalBelumBayar, 0, ',', '.') }}</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Menunggak (Lewat Tempo)</span>
            <h3 class="text-xl font-black text-rose-600 mt-1">{{ number_format($totalTunggakan) }} Invoice</h3>
            <span class="text-[10px] text-rose-600 font-semibold">Rp {{ number_format($nominalTunggakan, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('tagihan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3 text-xs">
            <!-- Filter Status -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Status</label>
                <select name="status" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="LUNAS" {{ request('status') === 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                    <option value="BELUM BAYAR" {{ request('status') === 'BELUM BAYAR' ? 'selected' : '' }}>BELUM BAYAR</option>
                    <option value="TUNGGAKAN" {{ request('status') === 'TUNGGAKAN' ? 'selected' : '' }}>TUNGGAKAN</option>
                </select>
            </div>

            <!-- Filter Kelas -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Kelas</label>
                <select name="id_kelas" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Bulan -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Bulan</label>
                <select name="bulan" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Bulan</option>
                    @foreach(['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'] as $b)
                        <option value="{{ $b }}" {{ request('bulan') === $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-slate-600 font-semibold mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Nama / NIS / VA..." 
                       class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono text-xs">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['status', 'id_kelas', 'bulan', 'search']))
                    <a href="{{ route('tagihan.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Tagihan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">NIS</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Virtual Account</th>
                        <th class="py-3 px-4">Periode Tagihan</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Kuitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tagihanList as $idx => $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $t->siswa->nama ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-slate-600">{{ $t->siswa->nis ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $t->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">
                                {{ $t->siswa->virtualAccount->nomor_va ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $t->bulan }} {{ $t->tahun }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($t->tanggal_jatuh_tempo)->format('d/m/Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $t->status === 'LUNAS' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $t->status === 'BELUM BAYAR' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $t->status === 'TUNGGAKAN' ? 'bg-rose-100 text-rose-700' : '' }}
                                ">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($t->status === 'LUNAS' && $t->pembayaran && $t->pembayaran->id_transaksi)
                                    <a href="{{ route('transaksi.kuitansi', $t->pembayaran->id_transaksi) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition">
                                        <i class="fa-solid fa-print text-[10px]"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-slate-400">
                                Tidak ada data tagihan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
