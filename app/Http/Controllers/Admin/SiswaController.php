<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Tampilkan data siswa (Dapat diakses Admin dan Kepala Sekolah)
     */
    public function index(Request $request)
    {
        $jurusanList = Jurusan::orderBy('kode_jurusan')->get();
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();

        $query = Siswa::with(['kelas.jurusan', 'tahunAjaran', 'virtualAccount', 'user']);

        // Filter Jurusan
        if ($request->filled('id_jurusan')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('id_jurusan', $request->id_jurusan);
            });
        }

        // Filter Kelas
        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        // Pencarian Nama / NIS / NISN / No VA
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nis', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%")
                  ->orWhereHas('virtualAccount', function ($vaQ) use ($keyword) {
                      $vaQ->where('nomor_va', 'like', "%{$keyword}%");
                  });
            });
        }

        $siswaList = $query->orderBy('id_kelas')->orderBy('nis')->get();

        return view('admin.siswa.index', compact('siswaList', 'kelasList', 'jurusanList'));
    }

    /**
     * Detail Siswa
     */
    public function show($id)
    {
        $siswa = Siswa::with([
            'kelas.jurusan',
            'tahunAjaran',
            'virtualAccount',
            'user',
            'tagihanSpp' => fn($q) => $q->orderBy('tahun', 'desc')->orderBy('bulan', 'desc'),
            'transaksiPaymentGateway' => fn($q) => $q->latest()
        ])->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }
}
