<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran SPP - {{ $transaksi->siswa->nama ?? 'Siswa' }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .font-mono-receipt {
            font-family: 'Courier Prime', monospace;
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                padding: 1.5rem !important;
                max-width: 100% !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-10 flex flex-col items-center justify-center min-h-screen">

    <!-- Action Toolbar (Hidden On Print) -->
    <div class="no-print w-full max-w-2xl mb-4 flex items-center justify-between bg-white p-3.5 rounded-2xl shadow-sm border border-slate-200">
        <a href="javascript:history.back()" class="text-xs font-bold text-slate-600 hover:text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.close()" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Tutup
            </button>
            <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Kuitansi</span>
            </button>
        </div>
    </div>

    <!-- Printable Official Receipt Card -->
    <div class="receipt-card w-full max-w-2xl bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-200 relative overflow-hidden">
        
        <!-- Header: Kop Kuitansi -->
        <div class="flex items-center justify-between pb-4 border-b-2 border-slate-800 gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-14 h-14 shrink-0">
                    <img src="{{ asset('images/logo-smk-cropped.png') }}" alt="Logo SMK Bina Bangsa" class="w-full h-full object-contain">
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 tracking-tight">SMK BINA BANGSA SIDOARJO</h2>
                    <p class="text-[11px] text-slate-500 font-medium">Sistem Informasi Pembayaran SPP Digital (100% Cashless)</p>
                    <p class="text-[10px] text-slate-400">Jl. Raya Pendidikan No. 45, Waru, Sidoarjo • (031) 8856731</p>
                </div>
            </div>

            <!-- Receipt Number Badge -->
            <div class="text-right">
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-extrabold uppercase tracking-wider mb-1">
                    ✓ LUNAS TERVERIFIKASI
                </span>
                <p class="text-[10px] text-slate-400 font-mono">No. Kuitansi:</p>
                <p class="text-xs font-mono font-bold text-slate-800">
                    KWT/{{ date('Ym') }}/{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        <!-- Receipt Document Title -->
        <div class="text-center py-4">
            <h1 class="text-sm font-extrabold uppercase tracking-widest text-slate-800 border-b border-dashed border-slate-300 pb-1 inline-block">
                KUITANSI PEMBAYARAN SPP (RESMI)
            </h1>
        </div>

        <!-- Main Details Grid -->
        <div class="space-y-3 text-xs text-slate-700">
            <div class="flex items-start">
                <span class="w-40 text-slate-500 shrink-0">Telah Diterima Dari</span>
                <span class="mr-2">:</span>
                <div class="flex-1 font-bold text-slate-900">
                    {{ $transaksi->siswa->nama ?? '-' }}
                    <span class="block font-normal text-slate-500 text-[11px]">
                        NIS: {{ $transaksi->siswa->nis ?? '-' }} • NISN: {{ $transaksi->siswa->nisn ?? '-' }}
                    </span>
                </div>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">Kelas & Jurusan</span>
                <span class="mr-2">:</span>
                <span class="font-semibold text-slate-800">
                    {{ $transaksi->siswa->kelas->nama_kelas ?? '-' }} ({{ $transaksi->siswa->kelas->jurusan->nama_jurusan ?? '-' }})
                </span>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">Untuk Pembayaran</span>
                <span class="mr-2">:</span>
                <span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                    SPP Bulan {{ $tagihan->bulan ?? '-' }} {{ $tagihan->tahun ?? date('Y') }}
                </span>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">Nomor Virtual Account</span>
                <span class="mr-2">:</span>
                <span class="font-mono font-bold text-slate-800">
                    {{ $transaksi->virtual_account }}
                </span>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">Saluran Pembayaran</span>
                <span class="mr-2">:</span>
                <span class="font-semibold text-slate-800">
                    {{ str_replace('_', ' ', $transaksi->payment_channel ?? 'Bank Virtual Account') }}
                </span>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">ID Transaksi Bank</span>
                <span class="mr-2">:</span>
                <span class="font-mono text-slate-600">
                    {{ $transaksi->transaction_id }} (Ref: {{ $transaksi->reference_number ?? '-' }})
                </span>
            </div>

            <div class="flex items-center">
                <span class="w-40 text-slate-500 shrink-0">Waktu Pembayaran</span>
                <span class="mr-2">:</span>
                <span class="text-slate-800">
                    {{ $transaksi->waktu_formatted }} WIB
                </span>
            </div>
        </div>

        <!-- Terbilang Box -->
        <div class="my-5 p-3.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs">
            <span class="text-slate-500 font-semibold block text-[11px] mb-0.5">Sejumlah Uang (Terbilang):</span>
            <p class="font-serif italic font-bold text-slate-800 text-sm">
                "{{ $terbilang }}"
            </p>
        </div>

        <!-- Nominal Tag & Official Stamp Row -->
        <div class="flex items-center justify-between pt-2">
            <!-- Big Nominal Display -->
            <div class="p-4 bg-emerald-50 border-2 border-dashed border-emerald-300 rounded-2xl">
                <span class="text-[11px] font-bold text-emerald-800 uppercase block">Jumlah Lunas:</span>
                <h3 class="text-2xl font-black text-emerald-700 tracking-tight">
                    Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                </h3>
            </div>

            <!-- Digital Verification Stamp & Signature -->
            <div class="text-center">
                <p class="text-[10px] text-slate-400">Sidoarjo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <div class="h-16 flex items-center justify-center my-1 relative">
                    <img src="{{ asset('images/ttd-admin.png') }}" alt="Tanda Tangan Petugas" class="h-14 w-auto object-contain mx-auto">
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-85">
                        <div class="border border-emerald-600 rounded-lg px-2 py-0.5 bg-emerald-50/60 rotate-[-4deg]">
                            <span class="text-[8px] font-extrabold text-emerald-800 block uppercase tracking-wider">
                                ★ LUNAS OTOMATIS ★
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-xs font-bold text-slate-800 underline">Petugas Kasir / Admin SPP</p>
                <p class="text-[10px] text-slate-400 font-mono">100% Cashless Verified</p>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="mt-6 pt-3 border-t border-slate-100 text-[10px] text-slate-400 text-center leading-relaxed">
            *Kuitansi digital ini merupakan bukti transaksi pembayaran yang sah yang diterbitkan secara otomatis oleh sistem perbankan Virtual Account SMK Bina Bangsa. Tidak memerlukan tanda tangan basah.
        </div>

    </div>

</body>
</html>
