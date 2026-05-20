@extends('layouts.app')

@section('content')
<div class="mb-8 text-center md:text-left">
    <h1 class="text-3xl font-bold text-[#5C4033]">Pendaftaran kunjungan</h1>
    <p class="mt-2 text-slate-600">Pilih jenis kunjungan, cek kalender sebulan, lalu lengkapi data dan klik <span class="font-semibold">Mengajukan</span>.</p>
</div>

<div class="mb-8 grid gap-8 lg:grid-cols-2 lg:items-start">
    <div>
        @include('partials.visitor_calendar', ['calendarInteractive' => true])
    </div>

    <div class="rounded-xl bg-white p-6 shadow-lg ring-1 ring-slate-100">
        @if ($errors->any())
            <div class="mb-5 rounded-md border border-rose-200 bg-rose-50 p-3 text-rose-900">
                <p class="mb-1 text-sm font-semibold">Periksa kembali:</p>
                <ul class="list-disc space-y-0.5 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6 rounded-lg border border-slate-200 bg-slate-50/80 p-4 text-sm text-slate-700">
            <p class="font-semibold text-[#5C4033]">Setelah mengajukan</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                <li>Admin dapat <span class="font-medium">menyetujui atau menolak</span> pengajuan (khususnya instansi / rombongan).</li>
                <li>Jika disetujui, Anda akan diminta melunasi sesuai metode; setelah terverifikasi, <span class="font-medium">kwitansi & QR</span> tersedia untuk dikirim ke email atau WA.</li>
            </ul>
        </div>

        <form id="bookingForm" method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <span class="mb-2 block text-sm font-medium text-slate-800">Jenis kunjungan</span>
                <div class="inline-flex w-full rounded-xl bg-slate-100 p-1 ring-1 ring-slate-200/80" role="group">
                    <button type="button" id="tabPersonal" class="flex-1 rounded-lg px-3 py-2 text-sm font-semibold transition">
                        Personal
                    </button>
                    <button type="button" id="tabInstansi" class="flex-1 rounded-lg px-3 py-2 text-sm font-semibold transition">
                        Instansi
                    </button>
                </div>
                <input type="hidden" name="jenis_pendaftar" id="jenis_pendaftar" value="{{ old('jenis_pendaftar', 'personal') }}" />
            </div>

            <div>
                <label for="tanggal_kunjungan" class="mb-1 block text-sm font-medium text-slate-800">Tanggal kunjungan</label>
                <input
                    id="tanggal_kunjungan"
                    type="date"
                    name="tanggal_kunjungan"
                    class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('tanggal_kunjungan') }}"
                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}"
                    required
                />
                <p class="mt-1 text-xs text-slate-500">Gunakan kalender di kiri untuk memilih tanggal (jika layar lebar), atau pilih manual di sini.</p>
            </div>

            <div id="personalFields" class="space-y-1">
                <label for="nama" class="block text-sm font-medium text-slate-800">Nama lengkap</label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('nama') }}"
                    placeholder="Diisi untuk personal"
                    autocomplete="name"
                />
                <p class="text-xs text-slate-500">Tidak perlu diisi jika instansi.</p>
            </div>

            <div id="instansiFields" class="hidden space-y-4">
                <div>
                    <label for="nama_instansi" class="mb-1 block text-sm font-medium text-slate-800">Nama instansi</label>
                    <input
                        type="text"
                        name="nama_instansi"
                        id="nama_instansi"
                        class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                        value="{{ old('nama_instansi') }}"
                    />
                </div>
                <div>
                    <label for="jumlah_pengunjung" class="mb-1 block text-sm font-medium text-slate-800">Jumlah pengunjung</label>
                    <input
                        type="number"
                        name="jumlah_pengunjung"
                        id="jumlah_pengunjung"
                        min="1"
                        class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                        value="{{ old('jumlah_pengunjung', 1) }}"
                    />
                    <p class="mt-1 text-xs text-slate-500">Personal dihitung 1 orang.</p>
                </div>
                <div>
                    <label for="surat_pengajuan" class="mb-1 block text-sm font-medium text-slate-800">Surat pengajuan (PDF)</label>
                    <input
                        type="file"
                        name="surat_pengajuan"
                        id="surat_pengajuan"
                        accept="application/pdf"
                        class="w-full rounded-lg border border-dashed border-slate-300 p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#5C4033] file:px-3 file:py-1.5 file:text-white"
                    />
                    <p class="mt-1 text-xs text-slate-500">Wajib untuk instansi; tidak diperlukan untuk personal.</p>
                </div>
            </div>

            <div>
                <label for="alamat" class="mb-1 block text-sm font-medium text-slate-800">Alamat</label>
                <textarea
                    name="alamat"
                    id="alamat"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    required
                >{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-800">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                />
            </div>

            <div>
                <label for="tujuan_kunjungan" class="mb-1 block text-sm font-medium text-slate-800">Tujuan kunjungan</label>
                <textarea
                    name="tujuan_kunjungan"
                    id="tujuan_kunjungan"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 p-2.5 focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    required
                >{{ old('tujuan_kunjungan') }}</textarea>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/90 p-4">
                <span class="mb-3 block text-sm font-medium text-slate-800">Metode pembayaran</span>
                <p class="mb-3 text-xs text-slate-600">Pilih <span class="font-medium">Cash</span> (di tempat) atau <span class="font-medium">Online</span> (DANA, GoPay, ShopeePay via Midtrans).</p>

                <div class="mb-3 grid grid-cols-2 gap-2 rounded-xl bg-white p-1 ring-1 ring-slate-200" role="group">
                    <button type="button" id="payCashBtn" class="rounded-lg px-3 py-2 text-sm font-semibold transition">
                        Cash
                    </button>
                    <button type="button" id="payOnlineBtn" class="rounded-lg px-3 py-2 text-sm font-semibold transition">
                        Online
                    </button>
                </div>

                <div id="ewalletField" class="hidden">
                    <label for="ewalletSelect" class="mb-1 block text-xs font-medium text-slate-700">Channel pembayaran online</label>
                    <select
                        id="ewalletSelect"
                        class="w-full rounded-lg border border-slate-300 bg-white p-2.5 text-sm focus:border-[#5C4033] focus:outline-none focus:ring-2 focus:ring-[#5C4033]/20"
                    >
                        <option value="dana">DANA</option>
                        <option value="gopay">GoPay</option>
                        <option value="shopeepay">ShopeePay</option>
                    </select>
                </div>

                <input type="hidden" name="payment_method" id="payment_method" value="{{ old('payment_method', 'cash') }}" />
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-[#5C4033] py-3.5 text-center text-base font-bold text-white shadow-md transition hover:bg-[#4a342a]"
            >
                Mengajukan
            </button>
        </form>
    </div>
</div>

<script>
    const disabledDates = @json($disabledDates);
    const jenisHidden = document.getElementById('jenis_pendaftar');
    const tabPersonal = document.getElementById('tabPersonal');
    const tabInstansi = document.getElementById('tabInstansi');
    const personalFields = document.getElementById('personalFields');
    const instansiFields = document.getElementById('instansiFields');
    const tanggalInput = document.getElementById('tanggal_kunjungan');
    const payCashBtn = document.getElementById('payCashBtn');
    const payOnlineBtn = document.getElementById('payOnlineBtn');
    const ewalletField = document.getElementById('ewalletField');
    const ewalletSelect = document.getElementById('ewalletSelect');
    const paymentMethodInput = document.getElementById('payment_method');

    const activeTabClass = 'bg-[#5C4033] text-white shadow-sm';
    const inactiveTabClass = 'text-slate-600 hover:bg-white/80';

    function setJenisUI(isInstansi) {
        jenisHidden.value = isInstansi ? 'instansi' : 'personal';
        personalFields.classList.toggle('hidden', isInstansi);
        instansiFields.classList.toggle('hidden', !isInstansi);
        tabPersonal.className = 'flex-1 rounded-lg px-3 py-2 text-sm font-semibold transition ' + (isInstansi ? inactiveTabClass : activeTabClass);
        tabInstansi.className = 'flex-1 rounded-lg px-3 py-2 text-sm font-semibold transition ' + (isInstansi ? activeTabClass : inactiveTabClass);
    }

    tabPersonal.addEventListener('click', () => setJenisUI(false));
    tabInstansi.addEventListener('click', () => setJenisUI(true));
    setJenisUI(jenisHidden.value === 'instansi');

    const payActive = 'bg-[#5C4033] text-white shadow-sm';
    const payIdle = 'text-slate-700 hover:bg-slate-100';
    let paymentMode = 'cash';

    function setPaymentUI(mode) {
        paymentMode = mode;
        const isOnline = mode === 'online';
        payCashBtn.className = 'rounded-lg px-3 py-2 text-sm font-semibold transition ' + (isOnline ? payIdle : payActive);
        payOnlineBtn.className = 'rounded-lg px-3 py-2 text-sm font-semibold transition ' + (isOnline ? payActive : payIdle);
        ewalletField.classList.toggle('hidden', !isOnline);
        if (isOnline) {
            paymentMethodInput.value = ewalletSelect.value;
        } else {
            paymentMethodInput.value = 'cash';
        }
    }

    payCashBtn.addEventListener('click', () => setPaymentUI('cash'));
    payOnlineBtn.addEventListener('click', () => setPaymentUI('online'));
    ewalletSelect.addEventListener('change', () => {
        if (paymentMode === 'online') {
            paymentMethodInput.value = ewalletSelect.value;
        }
    });

    const oldPm = @json(old('payment_method', 'cash'));
    if (oldPm === 'cash') {
        setPaymentUI('cash');
    } else {
        setPaymentUI('online');
        if (['dana', 'gopay', 'shopeepay'].includes(oldPm)) {
            ewalletSelect.value = oldPm;
            paymentMethodInput.value = oldPm;
        }
    }

    tanggalInput.addEventListener('change', function () {
        if (disabledDates.includes(this.value)) {
            alert('Tanggal ini dinonaktifkan (museum tutup). Silakan pilih tanggal lain.');
            this.value = '';
        }
    });

    // Calendar date click no longer fills the form field
</script>
@endsection
