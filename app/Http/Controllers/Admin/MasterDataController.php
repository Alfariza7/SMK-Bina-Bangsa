<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\TarifSpp;
use App\Models\User;
use App\Models\VirtualAccount;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Master Data: Data Kelas (9 Kelas)
     */
    public function kelas()
    {
        $kelasList = Kelas::with(['jurusan', 'tahunAjaran'])
            ->withCount('siswa')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.master.kelas', compact('kelasList'));
    }

    /**
     * Master Data: Data Jurusan (3 Jurusan: RPL, DKV, TKJ)
     */
    public function jurusan()
    {
        $jurusanList = Jurusan::withCount(['kelas', 'siswa'])
            ->orderBy('kode_jurusan')
            ->get();

        return view('admin.master.jurusan', compact('jurusanList'));
    }

    /**
     * Master Data: Data Tahun Ajaran
     */
    public function tahunAjaran()
    {
        $tahunAjaranList = TahunAjaran::withCount(['kelas', 'siswa'])
            ->orderBy('id_tahun_ajaran', 'desc')
            ->get();

        return view('admin.master.tahun_ajaran', compact('tahunAjaranList'));
    }

    /**
     * Master Data: Tarif SPP
     */
    public function tarifSpp()
    {
        $tarifList = TarifSpp::with('tahunAjaran')
            ->orderBy('id_tarif', 'desc')
            ->get();

        return view('admin.master.tarif_spp', compact('tarifList'));
    }

    /**
     * Master Data: Virtual Account (45 VA Siswa)
     */
    public function virtualAccount(Request $request)
    {
        $query = VirtualAccount::with(['siswa.kelas.jurusan']);

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where('nomor_va', 'like', "%{$keyword}%")
                  ->orWhereHas('siswa', function ($q) use ($keyword) {
                      $q->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('nis', 'like', "%{$keyword}%");
                  });
        }

        $vaList = $query->orderBy('nomor_va')->get();

        return view('admin.master.virtual_account', compact('vaList'));
    }

    /**
     * Master Data: Data Pengguna / User (Admin, Kepala Sekolah, Teller, Siswa)
     */
    public function users(Request $request)
    {
        $query = User::with('siswa.kelas');

        // Filter Role
        if ($request->filled('role') && in_array($request->role, ['admin', 'kepala_sekolah', 'teller', 'siswa'])) {
            $query->where('role', $request->role);
        }

        // Search Username / Nama
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('username', 'like', "%{$keyword}%");
            });
        }

        $userList = $query->orderBy('role')->orderBy('username')->get();

        // Hitung Ringkasan Per Role
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKepsek = User::where('role', 'kepala_sekolah')->count();
        $totalTeller = User::where('role', 'teller')->count();
        $totalSiswaUser = User::where('role', 'siswa')->count();

        return view('admin.master.users', compact(
            'userList',
            'totalUsers',
            'totalAdmin',
            'totalKepsek',
            'totalTeller',
            'totalSiswaUser'
        ));
    }
}
