@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Selamat Datang & Profil Siswa Lengkap (Poin a & b Panduan LSP) -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-indigo-500/20">
        <div class="absolute right-0 top-0 translate-x-12 -translate-y-12 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <!-- Profil Siswa: Nama, Kelas, Jurusan, NIS, NISN, Tahun Ajaran -->
            <div class="space-y-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-2">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Portal Pembayaran Siswa</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        {{ $siswa->nama }}
                    </h1>
                    <p class="text-xs sm:text-sm text-indigo-200 mt-1 flex items-center gap-2">
                        <span class="font-bold text-white">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                        <span>•</span>
                        <span>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</span>
                    </p>
                </div>

                <!-- Grid Data Atribut Siswa (Poin a: NIS, NISN, Kelas, Tahun Ajaran) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1 text-xs">
                    <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-xl border border-white/10">
                        <span class="text-[10px] text-indigo-300 font-semibold uppercase tracking-wider block">NIS</span>
                        <span class="font-mono font-bold text-white text-sm">{{ $siswa->nis }}</span>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-xl border border-white/10">
                        <span class="text-[10px] text-indigo-300 font-semibold uppercase tracking-wider block">NISN</span>
                        <span class="font-mono font-bold text-white text-sm">{{ $siswa->nisn ?? '-' }}</span>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-xl border border-white/10">
                        <span class="text-[10px] text-indigo-300 font-semibold uppercase tracking-wider block">Kelas</span>
                        <span class="font-bold text-white text-sm">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-xl border border-white/10">
                        <span class="text-[10px] text-indigo-300 font-semibold uppercase tracking-wider block">Tahun Ajaran</span>
                        <span class="font-bold text-white text-sm">{{ $siswa->tahunAjaran->tahun_ajaran ?? '2026/2027' }}</span>
                    </div>
                </div>
            </div>

            <!-- Virtual Account Display Card (Poin b: VA Milik Masing-Masing Murid) -->
            <div class="bg-gradient-to-br from-white/[0.12] to-white/[0.04] backdrop-blur-md p-5 rounded-2xl border border-white/20 shadow-lg flex flex-col justify-between shrink-0 lg:w-80">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-indigo-500/25 border border-indigo-400/30 flex items-center justify-center text-indigo-300">
                            <i class="fa-solid fa-wallet text-xs"></i>
                        </div>
                        <span class="text-xs font-bold text-white tracking-wide">Virtual Account Saya</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[10px] font-semibold text-emerald-300 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Aktif
                    </span>
                </div>

                <div class="my-3">
                    <span class="text-[10px] font-medium uppercase tracking-wider text-indigo-200/80 block mb-1.5">Nomor Rekening Pembayaran</span>
                    <div class="flex items-center justify-between gap-2 bg-black/30 px-3.5 py-2.5 rounded-xl border border-white/10">
                        <span id="va-number" class="text-lg sm:text-xl font-mono font-bold text-white tracking-widest selection:bg-indigo-500">
                            {{ $siswa->virtualAccount->nomor_va ?? 'Belum ada' }}
                        </span>
                        <button type="button" id="copy-btn" onclick="copyVA()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-lg text-xs font-semibold transition cursor-pointer shrink-0 shadow-sm">
                            <i class="fa-regular fa-copy text-xs" id="copy-icon"></i>
                            <span id="copy-text">Salin</span>
                        </button>
                    </div>
                </div>

                <div class="pt-2 text-[11px] text-indigo-200/80 flex items-center justify-between">
                    <span class="text-[10px] text-slate-300">Bank Transfer / Finnet</span>
                    <span class="text-[10px] text-indigo-300 font-medium">ATM • M-Banking</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dua Kolom: Tagihan Bulan Ini & Total Tunggakan (Poin P) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tagihan Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">TAGIHAN BULAN INI</span>
                <span class="text-xs font-medium text-slate-500">
                    {{ $tagihanBulanIni->bulan ?? 'September' }} {{ $tagihanBulanIni->tahun ?? 2026 }}
                </span>
            </div>

            <div class="my-5">
                <p class="text-xs text-slate-500 font-medium">Nominal Tagihan:</p>
                <h2 class="text-3xl font-black text-slate-800 mt-1">
                    Rp {{ number_format($tagihanBulanIni->nominal ?? 350000, 0, ',', '.') }}
                </h2>
                <div class="mt-3 flex items-center justify-between">
                    <span class="text-xs text-slate-500">
                        Jatuh Tempo: <strong>{{ isset($tagihanBulanIni->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($tagihanBulanIni->tanggal_jatuh_tempo)->format('d F Y') : '30 September 2026' }}</strong>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold
                        {{ ($tagihanBulanIni->status ?? 'BELUM BAYAR') === 'LUNAS' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}
                    ">
                        {{ $tagihanBulanIni->status ?? 'BELUM BAYAR' }}
                    </span>
                </div>
            </div>

            @if(($tagihanBulanIni->status ?? 'BELUM BAYAR') === 'LUNAS')
                <div class="p-3.5 bg-emerald-50 rounded-xl border border-emerald-200 text-emerald-800 text-[11px] leading-relaxed flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-base"></i>
                    <div>
                        <p class="font-bold text-xs">Pembayaran bulan ini telah LUNAS terverifikasi otomatis!</p>
                        <p class="text-[10px] text-emerald-700 mt-0.5">Histori transaksi resmi telah tercatat di Payment Gateway perbankan.</p>
                    </div>
                </div>

                @if($tagihanBulanIni->pembayaran && $tagihanBulanIni->pembayaran->id_transaksi)
                    <a href="{{ route('transaksi.kuitansi', $tagihanBulanIni->pembayaran->id_transaksi) }}" target="_blank"
                       class="mt-3.5 w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Bukti Pembayaran (Kuitansi Lunas)</span>
                    </a>
                @endif
            @else
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-600 text-[11px] leading-relaxed">
                    <i class="fa-solid fa-circle-info text-indigo-500 mr-1"></i>
                    Lakukan transfer melalui ATM / M-Banking ke <strong>Nomor Virtual Account</strong> di atas. Status tagihan akan otomatis berubah menjadi <strong>LUNAS</strong> detik itu juga setelah transfer berhasil diverifikasi oleh bank.
                </div>
            @endif
        </div>

        <!-- Total Tunggakan (Poin P) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">TOTAL TUNGGAKAN</span>
                    <span class="text-xs font-medium text-rose-500 font-semibold">
                        {{ $daftarTunggakan->count() }} Tagihan Tertunggak
                    </span>
                </div>

                <div class="my-5">
                    <p class="text-xs text-slate-500 font-medium">Akumulasi Tunggakan:</p>
                    <h2 class="text-3xl font-black {{ $totalTunggakan > 0 ? 'text-rose-600' : 'text-emerald-600' }} mt-1">
                        Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
                    </h2>
                </div>

                @if($daftarTunggakan->count() > 0)
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold text-slate-500 uppercase">Rincian Bulan Menunggak:</span>
                        @foreach($daftarTunggakan as $tunggak)
                            <div class="flex justify-between items-center text-xs p-2 bg-rose-50 text-rose-800 rounded-lg border border-rose-100 font-medium">
                                <span>{{ $tunggak->bulan }} {{ $tunggak->tahun }}</span>
                                <span class="font-bold">Rp {{ number_format($tunggak->nominal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-700 text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>Hebat! Anda tidak memiliki tunggakan SPP.</span>
                    </div>
                @endif
            </div>

            <p class="text-[11px] text-slate-400 mt-4">
                *Tagihan yang melewati tanggal akhir bulan otomatis tercatat sebagai tunggakan.
            </p>
        </div>
    </div>

    <!-- Riwayat Pembayaran (Poin P) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-indigo-600"></i>
                <span>RIWAYAT PEMBAYARAN SPP</span>
            </h2>
            <span class="text-xs text-slate-400">Seluruh Periode</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5">Bulan & Tahun</th>
                        <th class="py-3 px-5">Nominal</th>
                        <th class="py-3 px-5">Jatuh Tempo</th>
                        <th class="py-3 px-5">Tanggal Pembayaran</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-center">Bukti Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($riwayatTagihan as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-5 font-semibold text-slate-800">
                                {{ $item->bulan }} {{ $item->tahun }}
                            </td>
                            <td class="py-3.5 px-5 font-medium">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500">
                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d F Y') }}
                            </td>
                            <td class="py-3.5 px-5">
                                @if($item->status === 'LUNAS' && $item->pembayaran && $item->pembayaran->tanggal_pembayaran)
                                    <span class="text-emerald-700 font-medium inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-[10px] text-emerald-500"></i>
                                        <span>{{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d F Y') }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold
                                    {{ $item->status === 'LUNAS' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $item->status === 'BELUM BAYAR' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $item->status === 'TUNGGAKAN' ? 'bg-rose-100 text-rose-700' : '' }}
                                ">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                @if($item->status === 'LUNAS' && $item->pembayaran && $item->pembayaran->id_transaksi)
                                    <a href="{{ route('transaksi.kuitansi', $item->pembayaran->id_transaksi) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition">
                                        <i class="fa-solid fa-receipt text-[10px]"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">
                                Belum ada data riwayat tagihan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Catatan Hak Akses Siswa Terproteksi (Poin f Panduan LSP) -->
    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/70 text-slate-500 text-[11px] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-indigo-500 text-sm"></i>
            <span><strong>Catatan Keamanan Siswa:</strong> Seluruh riwayat transaksi bersifat permanen (read-only) dan diverifikasi otomatis oleh callback Payment Gateway perbankan.</span>
        </div>
        <span class="inline-flex items-center gap-1 text-[10px] bg-slate-200/60 text-slate-600 px-2.5 py-1 rounded-full font-semibold shrink-0">
            <i class="fa-solid fa-lock text-[9px]"></i> Read-Only Mode
        </span>
    </div>
</div>

<script>
    function copyVA() {
        const vaElement = document.getElementById('va-number');
        if (!vaElement) return;
        const va = vaElement.innerText.trim();

        navigator.clipboard.writeText(va).then(() => {
            const btn = document.getElementById('copy-btn');
            const icon = document.getElementById('copy-icon');
            const text = document.getElementById('copy-text');

            if (btn && icon && text) {
                btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-500');
                btn.classList.add('bg-emerald-600', 'hover:bg-emerald-500');
                icon.className = 'fa-solid fa-check text-xs';
                text.innerText = 'Tersalin!';

                setTimeout(() => {
                    btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-500');
                    btn.classList.add('bg-indigo-600', 'hover:bg-indigo-500');
                    icon.className = 'fa-regular fa-copy text-xs';
                    text.innerText = 'Salin';
                }, 2000);
            }
        });
    }
</script>
@endsection
