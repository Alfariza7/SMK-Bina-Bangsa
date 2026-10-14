<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Pembayaran SPP - SMK Bina Bangsa</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
                margin: 0 !important;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Floating Action Toolbar (Hidden When Printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white p-4 rounded-2xl shadow-md border border-slate-200">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-xs font-bold text-slate-700">Pratinjau Dokumen Cetak Resmi (LSP)</span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.close()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Tutup Jendela
            </button>
            <button type="button" onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Dokumen Sekarang</span>
            </button>
        </div>
    </div>

    <!-- Main Printable Sheet -->
    <div class="print-container max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-lg border border-slate-200 text-slate-800">
        
        <!-- KOP SURAT RESMI SEKOLAH -->
        <div class="flex items-center justify-between pb-4 border-b-2 border-slate-900 gap-4">
            <div class="w-20 h-20 shrink-0">
                <img src="{{ asset('images/logo-smk-cropped.png') }}" alt="Logo SMK Bina Bangsa" class="w-full h-full object-contain">
            </div>
            <div class="text-center flex-1">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-600">PEMERINTAH PROVINSI JAWA TIMUR</h3>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600">DINAS PENDIDIKAN DAN KEBUDAYAAN</h4>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight mt-0.5">SMK BINA BANGSA SIDOARJO</h1>
                <p class="text-[11px] text-slate-600 mt-1">
                    Jl. Raya Pendidikan No. 45, Kecamatan Waru, Kabupaten Sidoarjo, Jawa Timur 61256
                </p>
                <p class="text-[10px] text-slate-500">
                    Telepon: (031) 8856731 • Website: smkbinabangsa.sch.id • Email: info@smkbinabangsa.sch.id • NPSN: 20512345
                </p>
            </div>
            <div class="w-20 shrink-0 hidden sm:block"></div>
        </div>

        <div class="w-full h-0.5 bg-slate-900 mt-0.5 mb-6"></div>

        <!-- Document Title -->
        <div class="text-center mb-6">
            <h2 class="text-base font-extrabold tracking-wider uppercase underline underline-offset-4 text-slate-900">
                LAPORAN REKAPITULASI PEMBAYARAN SPP
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Sistem Pembayaran 100% Cashless via Bank Virtual Account & Payment Gateway
            </p>
        </div>

        <!-- Metadata Info -->
        <div class="mb-4 text-xs space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-200">
            <div class="flex justify-between">
                <span><strong>Kriteria Filter:</strong> {{ implode(' • ', $filterDeskripsi) }}</span>
                <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
            </div>
            <div class="flex justify-between text-[11px] text-slate-500">
                <span>Dicetak oleh: <strong>{{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})</strong></span>
                <span>Waktu Cetak: {{ date('H:i') }} WIB</span>
            </div>
        </div>

        <!-- Table Data -->
        <table class="w-full text-left text-xs border border-slate-300 border-collapse mb-6">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-300 text-slate-700 font-bold">
                    <th class="py-2.5 px-3 border-r border-slate-300 text-center w-8">No</th>
                    <th class="py-2.5 px-3 border-r border-slate-300">NIS & Nama Siswa</th>
                    <th class="py-2.5 px-3 border-r border-slate-300">Kelas</th>
                    <th class="py-2.5 px-3 border-r border-slate-300">Virtual Account</th>
                    <th class="py-2.5 px-3 border-r border-slate-300">Bulan</th>
                    <th class="py-2.5 px-3 border-r border-slate-300 text-right">Nominal</th>
                    <th class="py-2.5 px-3 border-r border-slate-300 text-center">Status</th>
                    <th class="py-2.5 px-3 text-center">Waktu Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-slate-800">
                @forelse($tagihanList as $index => $item)
                    <tr>
                        <td class="py-2 px-3 border-r border-slate-200 text-center">{{ $index + 1 }}</td>
                        <td class="py-2 px-3 border-r border-slate-200">
                            <strong>{{ $item->siswa->nama ?? '-' }}</strong>
                            <span class="block text-[10px] text-slate-500">NIS: {{ $item->siswa->nis ?? '-' }}</span>
                        </td>
                        <td class="py-2 px-3 border-r border-slate-200">
                            {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                        </td>
                        <td class="py-2 px-3 border-r border-slate-200 font-mono text-[11px]">
                            {{ $item->siswa->virtualAccount->nomor_va ?? '-' }}
                        </td>
                        <td class="py-2 px-3 border-r border-slate-200">
                            {{ $item->bulan }} {{ $item->tahun }}
                        </td>
                        <td class="py-2 px-3 border-r border-slate-200 text-right font-semibold">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>
                        <td class="py-2 px-3 border-r border-slate-200 text-center font-bold">
                            @if($item->status === 'LUNAS')
                                <span class="text-emerald-700">LUNAS</span>
                            @elseif($item->status === 'TUNGGAKAN')
                                <span class="text-rose-700">TUNGGAKAN</span>
                            @else
                                <span class="text-amber-700">BELUM BAYAR</span>
                            @endif
                        </td>
                        <td class="py-2 px-3 text-center text-[11px] text-slate-600 font-mono">
                            {{ $item->pembayaran->transaksiPaymentGateway->waktu_formatted ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 text-center text-slate-400">
                            Tidak ada data transaksi atau tagihan untuk kriteria ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-slate-50 font-bold border-t-2 border-slate-300">
                    <td colspan="5" class="py-2.5 px-3 text-right">TOTAL NOMINAL TAGIHAN:</td>
                    <td class="py-2.5 px-3 text-right text-indigo-700 font-extrabold">
                        Rp {{ number_format($totalNominal, 0, ',', '.') }}
                    </td>
                    <td colspan="2" class="py-2.5 px-3 text-center text-[11px] text-slate-500">
                        {{ $tagihanList->count() }} Data
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Ringkasan Keuangan Kotak -->
        <div class="grid grid-cols-2 gap-4 mb-8 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <span class="text-slate-500 font-medium">Total Penerimaan Dana Lunas:</span>
                <p class="text-base font-extrabold text-emerald-700 mt-0.5">
                    Rp {{ number_format($nominalLunas, 0, ',', '.') }}
                </p>
                <span class="text-[10px] text-slate-400">Terverifikasi otomatis via Payment Gateway</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <span class="text-slate-500 font-medium">Total Piutang / Tunggakan SPP:</span>
                <p class="text-base font-extrabold text-rose-700 mt-0.5">
                    Rp {{ number_format($nominalTunggakan, 0, ',', '.') }}
                </p>
                <span class="text-[10px] text-slate-400">Status Belum Bayar atau Jatuh Tempo</span>
            </div>
        </div>

        <!-- Kolom Tanda Tangan Resmi -->
        <div class="grid grid-cols-2 gap-8 text-xs text-center mt-10 pt-4">
            <div>
                <p class="text-slate-600">Mengetahui,</p>
                <p class="font-bold text-slate-900 mt-0.5">Kepala SMK Bina Bangsa</p>
                <div class="h-24 flex items-center justify-center my-2 relative">
                    <img src="{{ asset('images/ttd-kepsek.png') }}" alt="Tanda Tangan Kepala Sekolah" class="h-20 w-auto object-contain mx-auto">
                </div>
                <p class="font-extrabold text-slate-900 underline">Drs. H. Mulyadi, M.Pd.</p>
                <p class="text-[10px] text-slate-500">NIP. 19680514 199403 1 004</p>
            </div>

            <div>
                <p class="text-slate-600">Sidoarjo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-slate-900 mt-0.5">Petugas / Administrator SPP</p>
                <div class="h-24 flex items-center justify-center my-2 relative">
                    <img src="{{ asset('images/ttd-admin.png') }}" alt="Tanda Tangan Administrator" class="h-20 w-auto object-contain mx-auto">
                </div>
                <p class="font-extrabold text-slate-900 underline">{{ Auth::user()->nama }}</p>
                <p class="text-[10px] text-slate-500">NIP / ID: {{ Auth::user()->username }}</p>
            </div>
        </div>

    </div>

</body>
</html>
