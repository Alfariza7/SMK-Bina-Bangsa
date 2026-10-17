@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
<div class="space-y-6">
    <!-- Header Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('master.siswa.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Master Data Siswa</span>
        </a>
    </div>

    <!-- Profil Card Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-indigo-500/20">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold">
                    <span>Profil Siswa</span>
                    <span>•</span>
                    <span>Status: {{ ucfirst($siswa->status) }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">{{ $siswa->nama }}</h1>
                <p class="text-xs sm:text-sm text-indigo-200">
                    {{ $siswa->kelas->nama_kelas ?? '-' }} • {{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }} ({{ $siswa->tahunAjaran->tahun_ajaran ?? '-' }})
                </p>
            </div>

            <!-- Virtual Account -->
            <div class="bg-white/10 backdrop-blur-md p-4.5 rounded-2xl border border-white/20 text-right shrink-0">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-indigo-200 block">Nomor Virtual Account</span>
                <span class="text-2xl font-mono font-black text-amber-300 tracking-wider block mt-1">
                    {{ $siswa->virtualAccount->nomor_va ?? '-' }}
                </span>
                <span class="text-[10px] text-indigo-200">Prefix: 88000 • 5 digit akhir: {{ $siswa->nis }}</span>
            </div>
        </div>
    </div>

    <!-- Detail Informasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Pribadi & Akademik -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-indigo-600"></i>
                <span>Data Pribadi & Akademik</span>
            </h2>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">NIS</span>
                    <span class="font-mono font-bold text-slate-800">{{ $siswa->nis }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">NISN</span>
                    <span class="font-mono font-semibold text-slate-800">{{ $siswa->nisn ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Jenis Kelamin</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Tempat, Tanggal Lahir</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->tempat_lahir ?? 'Sidoarjo' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">No. Handphone / WhatsApp</span>
                    <span class="font-mono text-slate-800">{{ $siswa->no_hp ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Nama Orang Tua / Wali</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->nama_orang_tua ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Alamat Tempat Tinggal</span>
                    <span class="font-medium text-slate-800 text-right max-w-xs">{{ $siswa->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Akun Pengguna & SPP -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-user-lock text-indigo-600"></i>
                <span>Akun Pengguna & Status SPP</span>
            </h2>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Username Login</span>
                    <span class="font-mono font-bold text-slate-800">{{ $siswa->user->username ?? $siswa->nis }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Role Pengguna</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Siswa</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Status Akun</span>
                    <span class="font-bold text-emerald-600 capitalize">{{ $siswa->user->status ?? 'Aktif' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Total Tagihan Tercatat</span>
                    <span class="font-bold text-slate-800">{{ $siswa->tagihanSpp->count() }} Tagihan</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50">
                    <span class="text-slate-500">Tagihan Lunas</span>
                    <span class="font-bold text-emerald-600">{{ $siswa->tagihanSpp->where('status', 'LUNAS')->count() }} Tagihan</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Tagihan Menunggak</span>
                    <span class="font-bold text-rose-600">{{ $siswa->tagihanSpp->where('status', 'TUNGGAKAN')->count() }} Tagihan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Tagihan Siswa -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice text-indigo-600"></i>
                <span>Daftar Tagihan SPP Siswa</span>
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Bulan & Tahun</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Bukti Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($siswa->tagihanSpp as $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $t->bulan }} {{ $t->tahun }}</td>
                            <td class="py-3.5 px-4 font-medium">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ \Carbon\Carbon::parse($t->tanggal_jatuh_tempo)->format('d F Y') }}</td>
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
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
