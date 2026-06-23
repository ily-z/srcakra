@extends('layouts.app')

@section('title', 'Pendaftaran Kunjungan - Museum Cakraningrat')
@section('metaDescription', 'Daftar kunjungan ke Museum Cakraningrat Bangkalan. Isi data diri, pilih tanggal, dan ajukan kunjungan personal atau instansi.')
@section('ogTitle', 'Pendaftaran Kunjungan - Museum Cakraningrat')
@section('ogDescription', 'Daftar kunjungan ke Museum Cakraningrat Bangkalan. Isi data diri, pilih tanggal, dan ajukan kunjungan personal atau instansi.')
@section('canonical', route('booking.index'))

@push('background')
    @include('partials.bubble-background')
@endpush

@section('content')
<div class="mb-6 sm:mb-8 text-center sm:text-left">
    <h1 class="text-2xl sm:text-3xl font-bold text-[#5C4033]">Pendaftaran kunjungan</h1>
    <p class="mt-2 text-sm sm:text-base text-slate-600">Pilih jenis kunjungan, cek kalender sebulan, lalu lengkapi data dan klik <span class="font-semibold">Mengajukan</span>.</p>
</div>

<div class="mb-8 grid gap-6 lg:gap-8 lg:grid-cols-2 lg:items-start">
    <div>
        <button id="toggleCalendarBtn" type="button" class="mb-3 flex w-full items-center justify-between rounded-xl border border-[#5C4033]/20 bg-white px-4 py-3 text-sm font-medium text-[#5C4033] shadow-sm lg:hidden">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Lihat kalender kunjungan
            </span>
            <svg id="toggleCalendarIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div id="calendarWrapper" class="hidden lg:block">
            @include('partials.visitor_calendar', ['calendarInteractive' => true])
        </div>
    </div>

    <div class="rounded-xl bg-white p-4 sm:p-6 shadow-lg ring-1 ring-slate-100">
        @if ($errors->any())
            <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 p-3 text-rose-900">
                <p class="mb-1 text-xs sm:text-sm font-semibold">Periksa kembali:</p>
                <ul class="list-disc space-y-0.5 pl-5 text-xs sm:text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4 sm:mb-6 rounded-lg border border-slate-200 bg-slate-50/80 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
            <p class="font-semibold text-[#5C4033]">Setelah mengajukan</p>
            <ul class="mt-2 list-disc space-y-1 pl-4 sm:pl-5">
                <li>Admin dapat <span class="font-medium">menyetujui atau menolak</span> pengajuan (khususnya instansi / rombongan).</li>
                <li>Jika disetujui, Anda akan diminta melunasi sesuai metode; setelah terverifikasi, <span class="font-medium">kwitansi & QR</span> tersedia untuk dikirim ke email atau WA.</li>
            </ul>
        </div>

        <form id="bookingForm" method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <span class="mb-2 block text-xs sm:text-sm font-medium text-slate-800">Jenis kunjungan</span>
                <div class="relative inline-flex w-full rounded-xl bg-slate-100 p-1 ring-1 ring-slate-200/80" role="group">
                    <div id="toggleSlider" class="absolute inset-y-1 left-1 w-[calc(50%-6px)] rounded-lg bg-[#5C4033] shadow-sm transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]"></div>
                    <button type="button" id="tabPersonal" class="relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10 text-white">
                        Personal
                    </button>
                    <button type="button" id="tabInstansi" class="relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10 text-slate-600">
                        Instansi
                    </button>
                </div>
                <input type="hidden" name="jenis_pendaftar" id="jenis_pendaftar" value="{{ old('jenis_pendaftar', 'personal') }}" />
            </div>

            <div>
                <label for="tanggal_kunjungan" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Tanggal kunjungan</label>
                <input
                    id="tanggal_kunjungan"
                    type="date"
                    name="tanggal_kunjungan"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('tanggal_kunjungan') }}"
                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}"
                    required
                />
                <p class="mt-1 text-xs text-slate-500">Gunakan kalender untuk memilih tanggal, atau isi manual.</p>
            </div>

            <div id="personalFields" class="space-y-1">
                <label for="nama" class="block text-xs sm:text-sm font-medium text-slate-800">Nama lengkap</label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('nama') }}"
                    placeholder="Diisi untuk personal"
                    autocomplete="name"
                />
                <p class="text-xs text-slate-500">Tidak perlu diisi jika instansi.</p>
            </div>

            <div id="instansiFields" class="hidden space-y-4">
                <div>
                    <label for="nama_instansi" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Nama instansi</label>
                    <input
                        type="text"
                        name="nama_instansi"
                        id="nama_instansi"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                        value="{{ old('nama_instansi') }}"
                    />
                </div>
                <div>
                    <label for="jumlah_pengunjung" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Jumlah pengunjung</label>
                    <input
                        type="number"
                        name="jumlah_pengunjung"
                        id="jumlah_pengunjung"
                        min="1"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                        value="{{ old('jumlah_pengunjung', 1) }}"
                    />
                    <p class="mt-1 text-xs text-slate-500">Personal dihitung 1 orang.</p>
                </div>
                <div>
                    <label for="surat_pengajuan" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Surat pengajuan (PDF)</label>
                    <input
                        type="file"
                        name="surat_pengajuan"
                        id="surat_pengajuan"
                        accept="application/pdf"
                        class="w-full rounded-lg border border-dashed border-slate-300 p-2 text-xs sm:text-sm file:mr-2 sm:file:mr-3 file:rounded-md file:border-0 file:bg-[#5C4033] file:px-2 sm:file:px-3 file:py-1.5 file:text-xs sm:file:text-sm file:text-white"
                    />
                    <p class="mt-1 text-xs text-slate-500">Wajib untuk instansi; tidak diperlukan untuk personal.</p>
                </div>
            </div>

            <div>
                <label for="alamat" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Alamat</label>
                <textarea
                    name="alamat"
                    id="alamat"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    required
                >{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label for="email" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                />
            </div>

            <div>
                <label for="no_wa" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">No. WhatsApp</label>
                <input
                    type="tel"
                    name="no_wa"
                    id="no_wa"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('no_wa') }}"
                    placeholder="08xxxxxxxxxx"
                    autocomplete="tel"
                />
                <p class="mt-1 text-xs text-slate-500">Digunakan untuk menerima notifikasi via WhatsApp.</p>
            </div>

            <div>
                <label for="tujuan_kunjungan" class="mb-1 block text-xs sm:text-sm font-medium text-slate-800">Tujuan kunjungan</label>
                <textarea
                    name="tujuan_kunjungan"
                    id="tujuan_kunjungan"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 p-2.5 text-[16px] sm:text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    required
                >{{ old('tujuan_kunjungan') }}</textarea>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/90 p-3 sm:p-4">
                <span class="mb-2 sm:mb-3 block text-xs sm:text-sm font-medium text-slate-800">Metode pembayaran</span>
                <p class="mb-3 text-xs text-slate-600">Pilih <span class="font-medium">Cash</span> (bayar di tempat) atau <span class="font-medium">QRIS</span> (scan & bayar).</p>

                <div class="relative mb-3 grid grid-cols-2 rounded-xl bg-white p-1 ring-1 ring-slate-200" role="group">
                    <div id="paySlider" class="absolute inset-y-1 left-1 w-[calc(50%-6px)] rounded-lg bg-[#5C4033] shadow-sm transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]"></div>
                    <button type="button" id="payCashBtn" class="relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10 text-white">
                        Cash
                    </button>
                    <button type="button" id="payQrisBtn" class="relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10 text-slate-700">
                        QRIS
                    </button>
                </div>

                <div id="qrisDesc" class="hidden rounded-lg bg-sky-50 p-3 text-[10px] sm:text-xs text-sky-950">
                    Pembayaran via QRIS: Scan QRIS menggunakan aplikasi e-wallet (DANA, OVO, GoPay, ShopeePay, LinkAja) atau mobile banking.
                </div>

                <input type="hidden" name="payment_method" id="payment_method" value="{{ old('payment_method', 'cash') }}" />
            </div>

            <button
                type="submit"
                class="group w-full rounded-xl bg-[#5C4033] py-3.5 text-center text-sm sm:text-base font-bold text-white shadow-md transition-all duration-300 hover:bg-[#4a342a] hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] btn-submit"
            >
                <span class="inline-flex items-center justify-center gap-2">
                    Mengajukan
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </span>
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes btn-glow {
        0%, 100% { box-shadow: 0 4px 14px rgba(92, 64, 51, 0.3); }
        50% { box-shadow: 0 4px 24px rgba(92, 64, 51, 0.5); }
    }
    .btn-submit {
        animation: btn-glow 2.5s ease-in-out infinite;
    }
    .btn-submit:hover {
        animation: none;
    }
</style>

<script>
    (function() {
        var btn = document.getElementById('toggleCalendarBtn');
        var wrap = document.getElementById('calendarWrapper');
        var icon = document.getElementById('toggleCalendarIcon');
        if (btn && wrap) {
            btn.addEventListener('click', function() {
                var isHidden = wrap.classList.contains('hidden') || wrap.style.display === 'none';
                if (isHidden) {
                    wrap.style.display = 'block';
                    wrap.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                    btn.querySelector('span').textContent = 'Sembunyikan kalender';
                } else {
                    wrap.style.display = 'none';
                    icon.style.transform = 'rotate(0deg)';
                    btn.querySelector('span').textContent = 'Lihat kalender kunjungan';
                }
            });
            if (window.innerWidth < 1024) {
                wrap.style.display = 'none';
            }
        }
    })();

    const disabledDates = @json($disabledDates);
    const jenisHidden = document.getElementById('jenis_pendaftar');
    const tabPersonal = document.getElementById('tabPersonal');
    const tabInstansi = document.getElementById('tabInstansi');
    const personalFields = document.getElementById('personalFields');
    const instansiFields = document.getElementById('instansiFields');
    const tanggalInput = document.getElementById('tanggal_kunjungan');
    const payCashBtn = document.getElementById('payCashBtn');
    const payQrisBtn = document.getElementById('payQrisBtn');
    const qrisDesc = document.getElementById('qrisDesc');
    const paymentMethodInput = document.getElementById('payment_method');

    const baseTabClass = 'relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10';
    const toggleSlider = document.getElementById('toggleSlider');

    function setJenisUI(isInstansi) {
        jenisHidden.value = isInstansi ? 'instansi' : 'personal';
        personalFields.classList.toggle('hidden', isInstansi);
        instansiFields.classList.toggle('hidden', !isInstansi);

        if (isInstansi) {
            toggleSlider.style.left = 'calc(50% + 2px)';
            tabPersonal.className = baseTabClass + ' text-slate-600';
            tabInstansi.className = baseTabClass + ' text-white';
        } else {
            toggleSlider.style.left = '4px';
            tabPersonal.className = baseTabClass + ' text-white';
            tabInstansi.className = baseTabClass + ' text-slate-600';
        }
    }

    tabPersonal.addEventListener('click', () => setJenisUI(false));
    tabInstansi.addEventListener('click', () => setJenisUI(true));
    setJenisUI(jenisHidden.value === 'instansi');

    const basePayClass = 'relative flex-1 rounded-lg px-3 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold transition z-10';
    const paySlider = document.getElementById('paySlider');

    function setPaymentUI(mode) {
        qrisDesc.classList.add('hidden');

        if (mode === 'cash') {
            paySlider.style.left = '4px';
            payCashBtn.className = basePayClass + ' text-white';
            payQrisBtn.className = basePayClass + ' text-slate-700';
            paymentMethodInput.value = 'cash';
        } else {
            paySlider.style.left = 'calc(50% + 2px)';
            payCashBtn.className = basePayClass + ' text-slate-700';
            payQrisBtn.className = basePayClass + ' text-white';
            qrisDesc.classList.remove('hidden');
            paymentMethodInput.value = 'qris';
        }
    }

    payCashBtn.addEventListener('click', () => setPaymentUI('cash'));
    payQrisBtn.addEventListener('click', () => setPaymentUI('qris'));

    const oldPm = @json(old('payment_method', 'cash'));
    setPaymentUI(oldPm === 'qris' ? 'qris' : 'cash');

    tanggalInput.addEventListener('change', function () {
        if (disabledDates.includes(this.value)) {
            alert('Tanggal ini dinonaktifkan (museum tutup). Silakan pilih tanggal lain.');
            this.value = '';
        }
    });

    // Calendar date click no longer fills the form field
</script>
@endsection
