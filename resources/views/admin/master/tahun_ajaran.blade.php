@extends('layouts.app')

@section('title', 'Master Data Tahun Ajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Master Data Tahun Ajaran</h1>
            <p class="text-xs text-slate-500 mt-1">Periode akademik dan tahun ajaran operasional pembayaran SPP</p>
        </div>
    </div>

    <!-- Tabel Tahun Ajaran -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5">Tahun Ajaran</th>
                        <th class="py-3 px-5">Tanggal Mulai</th>
                        <th class="py-3 px-5">Tanggal Selesai</th>
                        <th class="py-3 px-5 text-center">Total Kelas</th>
                        <th class="py-3 px-5 text-center">Total Siswa Terdaftar</th>
                        <th class="py-3 px-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tahunAjaranList as $ta)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-4 px-5 font-bold text-slate-800 text-sm">
                                {{ $ta->tahun_ajaran }}
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                {{ $ta->tanggal_mulai ? \Carbon\Carbon::parse($ta->tanggal_mulai)->format('d F Y') : '01 Juli 2026' }}
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                {{ $ta->tanggal_selesai ? \Carbon\Carbon::parse($ta->tanggal_selesai)->format('d F Y') : '30 Juni 2027' }}
                            </td>
                            <td class="py-4 px-5 text-center font-semibold text-slate-800">
                                {{ $ta->kelas_count }} Kelas
                            </td>
                            <td class="py-4 px-5 text-center font-mono font-bold text-indigo-600">
                                {{ $ta->siswa_count }} Siswa
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    {{ ucfirst($ta->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
