@extends('layouts.app')

@section('title', 'Simulator Payment Gateway & Webhook')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="paymentSimulator()">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>LSP Gateway Sandbox • 100% Cashless System</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Simulator Payment Gateway & Webhook Tester
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl leading-relaxed">
                    Sistem otomatisasi verifikasi pembayaran SPP via Virtual Account. Sesuai ketentuan sertifikasi LSP, pelunasan tagihan <strong>hanya terjadi</strong> saat menerima sinyal Callback Webhook yang valid dari Payment Gateway.
                </p>
            </div>

            <!-- Quick Rule Highlights -->
            <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/10 shrink-0 space-y-2 text-xs">
                <div class="flex items-center gap-2 text-indigo-200">
                    <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                    <span>Anti-Duplikasi (Transaction ID Unik)</span>
                </div>
                <div class="flex items-center gap-2 text-indigo-200">
                    <i class="fa-solid fa-fingerprint text-indigo-400"></i>
                    <span>5 Digit Akhir VA Wajib Sesuai NIS</span>
                </div>
                <div class="flex items-center gap-2 text-indigo-200">
                    <i class="fa-solid fa-lock text-amber-400"></i>
                    <span>Tanpa Tombol Lunas Manual di UI</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tab Navigation -->
    <div class="flex items-center gap-2 border-b border-slate-200 bg-white p-2 rounded-2xl shadow-sm">
        <button type="button" 
                @click="activeTab = 'banking'"
                :class="activeTab === 'banking' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition duration-150 cursor-pointer">
            <i class="fa-solid fa-mobile-screen-button"></i>
            <span>Simulasi M-Banking / ATM (Nasabah)</span>
        </button>

        <button type="button" 
                @click="activeTab = 'webhook'"
                :class="activeTab === 'webhook' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition duration-150 cursor-pointer">
            <i class="fa-solid fa-terminal"></i>
            <span>Webhook Tester & Raw JSON (Asesor / Dev)</span>
        </button>

        <button type="button" 
                @click="activeTab = 'logs'; refreshTransactions()"
                :class="activeTab === 'logs' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition duration-150 cursor-pointer">
            <i class="fa-solid fa-list-check"></i>
            <span>Log Transaksi Gateway</span>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: SIMULATOR M-BANKING (POV SISWA/ORANG TUA) -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'banking'" x-transition class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Panel: Input & Inquiry Form -->
            <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-indigo-600"></i>
                            <span>Portal Virtual Account</span>
                        </h2>
                        <span class="text-[11px] font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-full">Bank Partner</span>
                    </div>

                    <!-- Quick Select Siswa (Untuk Kemudahan Penguji/Asesor) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Pilih Siswa Cepat (Preset LSP):
                        </label>
                        <select @change="selectStudentPreset($event)" class="w-full text-xs rounded-xl border border-slate-200 px-3 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Pilih Siswa Untuk Demo --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->virtualAccount->nomor_va ?? '' }}" 
                                    {{ ($selectedVa ?? '') === ($s->virtualAccount->nomor_va ?? '') ? 'selected' : '' }}
                                    data-nis="{{ $s->nis }}"
                                    data-nama="{{ $s->nama }}">
                                    {{ $s->nama }} (NIS: {{ $s->nis }}) - VA: {{ $s->virtualAccount->nomor_va ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">
                            *Pilihan otomatis mengisi nomor Virtual Account terdaftar di bawah.
                        </p>
                    </div>

                    <!-- Input Nomor Virtual Account -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nomor Virtual Account (10-16 Digit):
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="vaNumber" 
                                   placeholder="Contoh: 8800012345" 
                                   class="w-full font-mono text-sm tracking-wider font-bold rounded-xl border border-slate-200 pl-3.5 pr-24 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-800">
                            <button type="button" 
                                    @click="runInquiry()" 
                                    :disabled="loadingInquiry"
                                    class="absolute right-1.5 top-1.5 bottom-1.5 px-3 bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 text-white font-bold text-xs rounded-lg transition duration-150 cursor-pointer flex items-center gap-1.5">
                                <span x-show="!loadingInquiry"><i class="fa-solid fa-magnifying-glass"></i> Cek</span>
                                <span x-show="loadingInquiry"><i class="fa-solid fa-spinner animate-spin"></i></span>
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">
                            *Prefix Bank + 5 digit terakhir adalah NIS siswa (Contoh NIS 12345 &rarr; VA 8800012345)
                        </p>
                    </div>

                    <!-- Bank Channel Selection -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Pilih Saluran Pembayaran (Channel Bank):
                        </label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-slate-50 transition"
                                   :class="paymentChannel === 'BCA_VA' ? 'border-indigo-600 bg-indigo-50/50 text-indigo-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="channel" value="BCA_VA" x-model="paymentChannel" class="text-indigo-600">
                                <span>BCA Virtual Account</span>
                            </label>

                            <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-slate-50 transition"
                                   :class="paymentChannel === 'MANDIRI_VA' ? 'border-indigo-600 bg-indigo-50/50 text-indigo-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="channel" value="MANDIRI_VA" x-model="paymentChannel" class="text-indigo-600">
                                <span>Mandiri VA</span>
                            </label>

                            <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-slate-50 transition"
                                   :class="paymentChannel === 'BNI_VA' ? 'border-indigo-600 bg-indigo-50/50 text-indigo-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="channel" value="BNI_VA" x-model="paymentChannel" class="text-indigo-600">
                                <span>BNI Virtual Account</span>
                            </label>

                            <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-slate-50 transition"
                                   :class="paymentChannel === 'BRI_VA' ? 'border-indigo-600 bg-indigo-50/50 text-indigo-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="channel" value="BRI_VA" x-model="paymentChannel" class="text-indigo-600">
                                <span>BRI Virtual Account</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="executePayment()"
                            :disabled="!inquiryResult || !inquiryResult.tagihan || loadingPayment"
                            class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-200 disabled:text-slate-400 text-white font-extrabold text-xs tracking-wider uppercase transition shadow-lg shadow-emerald-600/20 disabled:shadow-none flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-paper-plane" x-show="!loadingPayment"></i>
                        <i class="fa-solid fa-spinner animate-spin" x-show="loadingPayment"></i>
                        <span x-text="loadingPayment ? 'Memproses Transaksi...' : 'Konfirmasi Bayar & Kirim Callback'"></span>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-2">
                        Simulasi transfer langsung memicu API Webhook detik itu juga.
                    </p>
                </div>
            </div>

            <!-- Right Panel: Inquiry Result & Live Invoice Preview -->
            <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Hasil Pengecekan Tagihan (Inquiry)</span>
                        <template x-if="inquiryResult && inquiryResult.tagihan">
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full"
                                  :class="inquiryResult.tagihan.status === 'TUNGGAKAN' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700'"
                                  x-text="inquiryResult.tagihan.status">
                            </span>
                        </template>
                    </div>

                    <!-- Placeholder Before Inquiry -->
                    <div x-show="!inquiryResult" class="py-14 text-center space-y-3">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">Belum Ada Tagihan yang Dicek</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">
                            Pilih siswa pada menu sebelah kiri atau masukkan nomor Virtual Account, lalu klik <strong>Cek</strong> untuk memeriksa tagihan aktif.
                        </p>
                    </div>

                    <!-- Invoice Details After Inquiry -->
                    <div x-show="inquiryResult" class="mt-5 space-y-4" style="display: none;">
                        <!-- Student Profile Snapshot -->
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Siswa:</span>
                                <h3 class="text-sm font-black text-slate-800" x-text="inquiryResult?.siswa?.nama"></h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    NIS: <strong class="font-mono text-indigo-600" x-text="inquiryResult?.siswa?.nis"></strong> • 
                                    Kelas: <span x-text="inquiryResult?.siswa?.kelas"></span>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Virtual Account:</span>
                                <p class="text-sm font-mono font-bold text-slate-800" x-text="inquiryResult?.virtual_account"></p>
                            </div>
                        </div>

                        <!-- Active Billing Info -->
                        <template x-if="inquiryResult && inquiryResult.tagihan">
                            <div class="p-5 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-[11px] font-semibold text-indigo-700">Tagihan SPP:</span>
                                        <h4 class="text-base font-extrabold text-indigo-950">
                                            Bulan <span x-text="inquiryResult.tagihan.bulan"></span> <span x-text="inquiryResult.tagihan.tahun"></span>
                                        </h4>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[11px] font-semibold text-slate-500">Jatuh Tempo:</span>
                                        <p class="text-xs font-bold text-slate-700" x-text="formatDate(inquiryResult.tagihan.tanggal_jatuh_tempo)"></p>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-indigo-100 flex items-center justify-between">
                                    <span class="text-xs font-bold text-indigo-900">Total Nominal Pembayaran:</span>
                                    <span class="text-2xl font-black text-indigo-700" x-text="formatRupiah(inquiryResult.tagihan.nominal)"></span>
                                </div>
                            </div>
                        </template>

                        <!-- If No Active Bill -->
                        <template x-if="inquiryResult && !inquiryResult.tagihan">
                            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                                <div>
                                    <h5 class="font-bold">Semua Tagihan Sudah LUNAS</h5>
                                    <p class="text-[11px] text-emerald-700">Siswa ini tidak memiliki tagihan aktif yang perlu dibayar.</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Live Payment Result Alert -->
                <div x-show="paymentSuccessMessage" class="mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs space-y-2" style="display: none;">
                    <div class="flex items-center gap-2 text-emerald-800 font-bold">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span x-text="paymentSuccessMessage"></span>
                    </div>
                    <div class="text-[11px] text-slate-600 space-y-1 pt-2 border-t border-emerald-100">
                        <p>ID Transaksi: <strong class="font-mono" x-text="lastTrxData?.transaction_id"></strong></p>
                        <p>Channel: <span class="font-semibold" x-text="lastTrxData?.payment_channel"></span></p>
                        <p>Status Tagihan: <span class="px-2 py-0.5 rounded bg-emerald-200 text-emerald-900 font-black">LUNAS</span></p>
                    </div>
                </div>

                <!-- Error Message Alert -->
                <div x-show="errorMessage" class="mt-4 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-800 flex items-start gap-2" style="display: none;">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 mt-0.5"></i>
                    <span x-text="errorMessage"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: WEBHOOK TESTER & RAW JSON (POV ASESOR / DEV) -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'webhook'" x-transition class="space-y-6" style="display: none;">
        <!-- Preset Scenario Buttons -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block">
                Skenario Uji Cepat Penguji / Asesor LSP:
            </span>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2.5 text-xs">
                <!-- Case 1: Normal Success -->
                <button type="button" 
                        @click="setScenario('normal')" 
                        class="p-3 text-left rounded-2xl border border-emerald-200 bg-emerald-50/60 hover:bg-emerald-100/80 transition duration-150 cursor-pointer">
                    <div class="flex items-center gap-2 text-emerald-800 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Kasus Normal (PAID)</span>
                    </div>
                    <p class="text-[10px] text-emerald-700 mt-1">Status 200 OK • Tagihan Berubah Lunas</p>
                </button>

                <!-- Case 2: Anti-Duplication -->
                <button type="button" 
                        @click="setScenario('duplicate')" 
                        class="p-3 text-left rounded-2xl border border-amber-200 bg-amber-50/60 hover:bg-amber-100/80 transition duration-150 cursor-pointer">
                    <div class="flex items-center gap-2 text-amber-800 font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Uji Anti Duplikasi</span>
                    </div>
                    <p class="text-[10px] text-amber-700 mt-1">Status 409 Conflict • Trx ID Pernah Dipakai</p>
                </button>

                <!-- Case 3: Invalid VA NIS Match -->
                <button type="button" 
                        @click="setScenario('invalid_va')" 
                        class="p-3 text-left rounded-2xl border border-rose-200 bg-rose-50/60 hover:bg-rose-100/80 transition duration-150 cursor-pointer">
                    <div class="flex items-center gap-2 text-rose-800 font-bold">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        <span>Uji VA Tidak Cocok</span>
                    </div>
                    <p class="text-[10px] text-rose-700 mt-1">Status 422 • 5 Digit VA ≠ NIS Siswa</p>
                </button>

                <!-- Case 4: Wrong Nominal -->
                <button type="button" 
                        @click="setScenario('wrong_amount')" 
                        class="p-3 text-left rounded-2xl border border-rose-200 bg-rose-50/60 hover:bg-rose-100/80 transition duration-150 cursor-pointer">
                    <div class="flex items-center gap-2 text-rose-800 font-bold">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        <span>Uji Nominal Salah</span>
                    </div>
                    <p class="text-[10px] text-rose-700 mt-1">Status 422 • Nominal Tidak Sesuai</p>
                </button>

                <!-- Case 5: Failed Status -->
                <button type="button" 
                        @click="setScenario('failed')" 
                        class="p-3 text-left rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 transition duration-150 cursor-pointer">
                    <div class="flex items-center gap-2 text-slate-800 font-bold">
                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                        <span>Uji Status FAILED</span>
                    </div>
                    <p class="text-[10px] text-slate-600 mt-1">Status 200 • Tagihan Tidak Diubah</p>
                </button>
            </div>
        </div>

        <!-- Two Column Editor & Live Response -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Request Payload Editor -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Request Body (JSON Webhook Callback)</span>
                            <p class="text-[11px] text-slate-400">Format payload resmi sesuai Dokumen LSP Poin H</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 font-mono text-[10px] font-bold">
                            POST /payment-gateway/callback
                        </span>
                    </div>

                    <div class="relative">
                        <textarea x-model="webhookPayload" 
                                  rows="12" 
                                  class="w-full font-mono text-xs p-4 bg-slate-900 text-emerald-400 rounded-2xl border border-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 leading-relaxed"></textarea>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button type="button" 
                            @click="generateNewTrxId()" 
                            class="px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-shuffle"></i>
                        <span>Generate Trx ID Baru</span>
                    </button>

                    <button type="button" 
                            @click="sendWebhook()" 
                            :disabled="loadingWebhook"
                            class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 text-white font-bold text-xs transition shadow-md shadow-indigo-600/20 cursor-pointer flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane" x-show="!loadingWebhook"></i>
                        <i class="fa-solid fa-spinner animate-spin" x-show="loadingWebhook"></i>
                        <span x-text="loadingWebhook ? 'Mengirim Callback...' : 'Kirim Webhook Callback'"></span>
                    </button>
                </div>
            </div>

            <!-- Live Response Viewer -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Response Server & HTTP Status</span>
                            <p class="text-[11px] text-slate-400">Respon aktual yang dikembalikan oleh backend Laravel</p>
                        </div>
                        <template x-if="webhookResponseStatus">
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-black"
                                  :class="{
                                      'bg-emerald-100 text-emerald-700': webhookResponseStatus >= 200 && webhookResponseStatus < 300,
                                      'bg-amber-100 text-amber-700': webhookResponseStatus === 409,
                                      'bg-rose-100 text-rose-700': webhookResponseStatus >= 400 && webhookResponseStatus !== 409
                                  }"
                                  x-text="'HTTP ' + webhookResponseStatus">
                            </span>
                        </template>
                    </div>

                    <div class="relative">
                        <textarea readonly 
                                  x-model="webhookResponseBody" 
                                  rows="12" 
                                  placeholder="// Respon Webhook dari server akan tampil di sini..." 
                                  class="w-full font-mono text-xs p-4 bg-slate-900 text-indigo-200 rounded-2xl border border-slate-800 focus:outline-none leading-relaxed"></textarea>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Waktu Respon: <strong class="font-mono" x-text="responseTime ? responseTime + ' ms' : '-'"></strong></span>
                    <button type="button" 
                            @click="activeTab = 'logs'; refreshTransactions()" 
                            class="text-indigo-600 hover:text-indigo-800 font-bold transition flex items-center gap-1 cursor-pointer">
                        <span>Lihat Log Database</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 3: LOG RIWAYAT TRANSAKSI GATEWAY -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'logs'" x-transition class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-indigo-600"></i>
                    <span>Tabel Riwayat Transaksi Payment Gateway</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Tercatat di tabel database <code>transaksi_payment_gateway</code></p>
            </div>
            <button type="button" 
                    @click="refreshTransactions()" 
                    :disabled="loadingLogs"
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate" :class="loadingLogs ? 'animate-spin' : ''"></i>
                <span>Segarkan Data</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-5">Transaction ID</th>
                        <th class="py-3 px-5">Virtual Account</th>
                        <th class="py-3 px-5">Nama Siswa / NIS</th>
                        <th class="py-3 px-5">Nominal</th>
                        <th class="py-3 px-5">Channel</th>
                        <th class="py-3 px-5">Tanggal & Waktu</th>
                        <th class="py-3 px-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="item in transactionsList" :key="item.id_transaksi">
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-5 font-mono font-bold text-indigo-600" x-text="item.transaction_id"></td>
                            <td class="py-3.5 px-5 font-mono" x-text="item.virtual_account"></td>
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-800 block" x-text="item.siswa ? item.siswa.nama : '-'"></span>
                                <span class="text-[10px] text-slate-400" x-text="'NIS: ' + (item.siswa ? item.siswa.nis : '-')"></span>
                            </td>
                            <td class="py-3.5 px-5 font-bold" x-text="formatRupiah(item.nominal)"></td>
                            <td class="py-3.5 px-5">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[10px]" x-text="item.payment_channel"></span>
                            </td>
                            <td class="py-3.5 px-5 text-slate-500" x-text="item.tanggal_transaksi + ' ' + (item.waktu_transaksi || '')"></td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold"
                                      :class="{
                                          'bg-emerald-100 text-emerald-700': item.status_transaksi === 'PAID',
                                          'bg-rose-100 text-rose-700': item.status_transaksi === 'FAILED',
                                          'bg-amber-100 text-amber-700': item.status_transaksi === 'EXPIRED'
                                      }"
                                      x-text="item.status_transaksi">
                                </span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="transactionsList.length === 0">
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Belum ada riwayat transaksi yang tercatat.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function paymentSimulator() {
    return {
        activeTab: 'banking',
        vaNumber: '{{ $selectedVa ?? "8800012345" }}',
        paymentChannel: 'BCA_VA',
        inquiryResult: null,
        loadingInquiry: false,
        loadingPayment: false,
        paymentSuccessMessage: '',
        errorMessage: '',
        lastTrxData: null,

        // Webhook Tester State
        webhookPayload: '',
        webhookResponseStatus: null,
        webhookResponseBody: '',
        loadingWebhook: false,
        responseTime: null,

        // Transactions Log State
        transactionsList: @json($riwayatTransaksi),
        loadingLogs: false,

        init() {
            this.setScenario('normal');
            if (this.vaNumber) {
                this.runInquiry();
            }
        },

        selectStudentPreset(e) {
            const va = e.target.value;
            if (va) {
                this.vaNumber = va;
                this.runInquiry();
                this.updateWebhookPayload(va, 350000);
            }
        },

        async runInquiry() {
            if (!this.vaNumber) {
                this.errorMessage = 'Silakan masukkan nomor Virtual Account terlebih dahulu.';
                return;
            }

            this.loadingInquiry = true;
            this.errorMessage = '';
            this.paymentSuccessMessage = '';

            try {
                const res = await fetch('{{ route("payment.inquiry") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ virtual_account: this.vaNumber })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    this.inquiryResult = data.data;
                    if (data.data.tagihan) {
                        this.updateWebhookPayload(data.data.virtual_account, data.data.tagihan.nominal);
                    }
                } else {
                    this.inquiryResult = null;
                    this.errorMessage = data.message || 'Virtual Account tidak ditemukan.';
                }
            } catch (err) {
                this.errorMessage = 'Gagal menghubungi server inquiry.';
            } finally {
                this.loadingInquiry = false;
            }
        },

        async executePayment() {
            if (!this.inquiryResult || !this.inquiryResult.tagihan) {
                return;
            }

            this.loadingPayment = true;
            this.errorMessage = '';
            this.paymentSuccessMessage = '';

            const trxId = 'TRX-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.random().toString(36).substring(2, 7).toUpperCase();
            
            const payload = {
                virtual_account: this.inquiryResult.virtual_account,
                amount: this.inquiryResult.tagihan.nominal,
                transaction_id: trxId,
                status: 'PAID',
                payment_channel: this.paymentChannel,
                paid_at: new Date().toISOString().slice(0, 19).replace('T', ' ')
            };

            try {
                const res = await fetch('{{ route("payment.callback") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    this.paymentSuccessMessage = data.message;
                    this.lastTrxData = data.data;
                    // Re-inquiry to refresh status
                    this.runInquiry();
                    this.refreshTransactions();
                } else {
                    this.errorMessage = data.message || 'Pembayaran gagal diproses.';
                }
            } catch (err) {
                this.errorMessage = 'Terjadi kesalahan sistem saat mengirim callback.';
            } finally {
                this.loadingPayment = false;
            }
        },

        // Webhook Tester Functions
        setScenario(type) {
            const today = new Date().toISOString().slice(0, 10).replace(/-/g, '');
            const randomCode = Math.random().toString(36).substring(2, 7).toUpperCase();

            let payloadObj = {
                virtual_account: "8800012345",
                amount: 350000,
                transaction_id: "TRX-" + today + "-" + randomCode,
                status: "PAID"
            };

            if (type === 'duplicate') {
                payloadObj.transaction_id = "TRX-DUPLICATE-SAMPLE-001";
            } else if (type === 'invalid_va') {
                payloadObj.virtual_account = "8800099999"; // NIS 99999 mismatch
            } else if (type === 'wrong_amount') {
                payloadObj.amount = 150000; // Wrong amount (not 350000)
            } else if (type === 'failed') {
                payloadObj.status = "FAILED";
            }

            this.webhookPayload = JSON.stringify(payloadObj, null, 2);
        },

        generateNewTrxId() {
            try {
                let obj = JSON.parse(this.webhookPayload);
                const today = new Date().toISOString().slice(0, 10).replace(/-/g, '');
                obj.transaction_id = "TRX-" + today + "-" + Math.random().toString(36).substring(2, 7).toUpperCase();
                this.webhookPayload = JSON.stringify(obj, null, 2);
            } catch (e) {
                alert('Format JSON tidak valid.');
            }
        },

        updateWebhookPayload(va, amount) {
            try {
                let obj = JSON.parse(this.webhookPayload || '{}');
                obj.virtual_account = va;
                obj.amount = amount;
                this.webhookPayload = JSON.stringify(obj, null, 2);
            } catch(e) {}
        },

        async sendWebhook() {
            let parsedBody;
            try {
                parsedBody = JSON.parse(this.webhookPayload);
            } catch (err) {
                alert('Format payload JSON tidak valid!');
                return;
            }

            this.loadingWebhook = true;
            this.webhookResponseBody = '// Menunggu respon dari server...';
            this.webhookResponseStatus = null;
            const startTime = performance.now();

            try {
                const res = await fetch('{{ route("payment.callback") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(parsedBody)
                });

                this.responseTime = Math.round(performance.now() - startTime);
                this.webhookResponseStatus = res.status;
                const data = await res.json();
                this.webhookResponseBody = JSON.stringify(data, null, 2);
                
                // Refresh log if successful
                this.refreshTransactions();
            } catch (err) {
                this.webhookResponseStatus = 500;
                this.webhookResponseBody = JSON.stringify({ error: 'Gagal menghubungi endpoint webhook.' }, null, 2);
            } finally {
                this.loadingWebhook = false;
            }
        },

        async refreshTransactions() {
            this.loadingLogs = true;
            try {
                const res = await fetch('{{ route("payment.transactions") }}');
                const data = await res.json();
                if (data.success) {
                    this.transactionsList = data.data;
                }
            } catch (e) {
                console.error('Failed to refresh transactions', e);
            } finally {
                this.loadingLogs = false;
            }
        },

        formatRupiah(val) {
            if (!val) return 'Rp 0';
            return 'Rp ' + Number(val).toLocaleString('id-ID');
        },

        formatDate(val) {
            if (!val) return '-';
            const d = new Date(val);
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }
    };
}
</script>
@endsection
