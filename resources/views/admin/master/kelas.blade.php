@extends('layouts.app')

@section('title', 'Master Data Kelas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Master Data Kelas</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar kelas pembelajaran aktif di SMK Bina Bangsa (3 Jurusan x 3 Tingkatan)</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                <i class="fa-solid fa-school"></i>
                <span>Total: {{ $kelasList->count() }} Kelas</span>
            </span>
        </div>
    </div>

    <!-- Grid Kartu Kelas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($kelasList as $kelas)
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                            {{ $kelas->tingkat }}
                        </span>
                        <h3 class="font-extrabold text-base text-slate-800">{{ $kelas->nama_kelas }}</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase
                        {{ $kelas->jurusan->kode_jurusan === 'RPL' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $kelas->jurusan->kode_jurusan === 'DKV' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $kelas->jurusan->kode_jurusan === 'TKJ' ? 'bg-emerald-100 text-emerald-700' : '' }}
                    ">
                        {{ $kelas->jurusan->kode_jurusan ?? '-' }}
                    </span>
                </div>

                <div class="pt-3.5 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Jurusan:</span>
                        <span class="font-medium text-slate-800 text-right">{{ $kelas->jurusan->nama_jurusan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Tahun Ajaran:</span>
                        <span class="font-medium text-slate-800">{{ $kelas->tahunAjaran->tahun_ajaran ?? '2026/2027' }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-50">
                        <span class="text-slate-500">Jumlah Siswa:</span>
                        <span class="font-mono font-bold text-sm text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg">
                            {{ $kelas->siswa_count }} Murid
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('master.siswa.index', ['id_kelas' => $kelas->id_kelas]) }}" 
                       class="w-full py-2 bg-slate-50 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-users text-[10px]"></i>
                        <span>Lihat 5 Siswa di Kelas Ini</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
