@extends('layouts.app')

@section('title', 'Master Data Pengguna (User)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Data Pengguna & Hak Akses</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar seluruh akun pengguna yang terdaftar pada sistem pembayaran SPP</p>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Pengguna -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-rose-300 transition">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Administrator</span>
            <h3 class="text-xl font-black text-rose-600 mt-1">{{ $totalAdmin }} User</h3>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'kepala_sekolah']) }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-amber-300 transition">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Kepala Sekolah</span>
            <h3 class="text-xl font-black text-amber-600 mt-1">{{ $totalKepsek }} User</h3>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'teller']) }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-cyan-300 transition">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Teller</span>
            <h3 class="text-xl font-black text-cyan-600 mt-1">{{ $totalTeller }} User</h3>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-emerald-300 transition">
            <span class="text-[11px] font-semibold text-slate-500 uppercase">Siswa Terdaftar</span>
            <h3 class="text-xl font-black text-emerald-600 mt-1">{{ $totalSiswaUser }} User</h3>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 text-xs">
            <!-- Filter Role -->
            <div class="w-full sm:w-48">
                <select name="role" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Role Pengguna</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kepala_sekolah" {{ request('role') === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="teller" {{ request('role') === 'teller' ? 'selected' : '' }}>Teller</option>
                    <option value="siswa" {{ request('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
            </div>

            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Username atau Nama Pengguna..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
            </div>

            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>Terapkan</span>
            </button>
            @if(request()->anyFilled(['role', 'search']))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl text-xs transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tabel Pengguna -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5 w-12 text-center">No</th>
                        <th class="py-3 px-5">Nama Lengkap</th>
                        <th class="py-3 px-5">Username (Login)</th>
                        <th class="py-3 px-5">Role Pengguna</th>
                        <th class="py-3 px-5">Keterangan / Kelas</th>
                        <th class="py-3 px-5">Status Akun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($userList as $idx => $u)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-5 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">
                                {{ $u->nama }}
                            </td>
                            <td class="py-3.5 px-5 font-mono font-semibold text-slate-600">
                                {{ $u->username }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $u->role === 'admin' ? 'bg-rose-50 text-rose-600 border border-rose-200' : '' }}
                                    {{ $u->role === 'kepala_sekolah' ? 'bg-amber-50 text-amber-600 border border-amber-200' : '' }}
                                    {{ $u->role === 'teller' ? 'bg-cyan-50 text-cyan-600 border border-cyan-200' : '' }}
                                    {{ $u->role === 'siswa' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : '' }}
                                ">
                                    {{ str_replace('_', ' ', $u->role) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-slate-500">
                                @if($u->role === 'siswa' && $u->siswa)
                                    <span class="font-semibold text-slate-700">{{ $u->siswa->kelas->nama_kelas ?? '-' }}</span>
                                @else
                                    <span class="text-slate-400">Pegawai Sekolah</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $u->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($u->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
