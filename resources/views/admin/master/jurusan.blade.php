@extends('layouts.app')

@section('title', 'Master Data Jurusan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Master Data Jurusan</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar program keahlian kejuruan resmi di SMK Bina Bangsa</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Total: {{ $jurusanList->count() }} Jurusan</span>
            </span>
        </div>
    </div>

    <!-- 3 Kartu Jurusan Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($jurusanList as $j)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg
                            {{ $j->kode_jurusan === 'RPL' ? 'bg-blue-50 text-blue-600' : '' }}
                            {{ $j->kode_jurusan === 'DKV' ? 'bg-purple-50 text-purple-600' : '' }}
                            {{ $j->kode_jurusan === 'TKJ' ? 'bg-emerald-50 text-emerald-600' : '' }}
                        ">
                            {{ $j->kode_jurusan }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                            Aktif
                        </span>
                    </div>

                    <h2 class="text-lg font-extrabold text-slate-800 mt-4">{{ $j->nama_jurusan }}</h2>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $j->keterangan ?? 'Program keahlian kejuruan' }}</p>

                    <div class="grid grid-cols-2 gap-2 mt-5 pt-4 border-t border-slate-100 text-xs">
                        <div class="bg-slate-50 p-2.5 rounded-xl">
                            <span class="text-[10px] text-slate-400 block font-semibold">Total Kelas</span>
                            <span class="text-base font-bold text-slate-800">{{ $j->kelas_count }} Kelas</span>
                        </div>
                        <div class="bg-indigo-50/70 p-2.5 rounded-xl">
                            <span class="text-[10px] text-indigo-400 block font-semibold">Total Siswa</span>
                            <span class="text-base font-bold text-indigo-700">{{ $j->siswa_count }} Murid</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100">
                    <a href="{{ route('master.siswa.index', ['id_jurusan' => $j->id_jurusan]) }}" 
                       class="w-full py-2.5 bg-slate-900 hover:bg-indigo-600 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                        <span>Lihat Semua Siswa {{ $j->kode_jurusan }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
