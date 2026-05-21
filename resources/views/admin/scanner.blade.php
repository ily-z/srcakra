@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">QR Scanner</h1>
    <span id="scanStatus" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">Menunggu scan...</span>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Scanner Panel --}}
    <div class="rounded-lg bg-white p-5 shadow">
        <h2 class="mb-3 text-sm font-semibold text-slate-700">Scan QR Code</h2>
        <p class="mb-4 text-xs text-slate-500">Arahkan kamera ke QR code kunjungan untuk memulai scan.</p>
        <div id="reader" class="mx-auto max-w-sm"></div>
        <div id="scannerFallback" class="hidden text-center text-sm text-slate-500 py-8">
            Kamera tidak tersedia. Silakan masukkan token secara manual.
        </div>

        <div class="mt-6 border-t pt-4">
            <label for="manualToken" class="mb-1 block text-xs font-medium text-slate-600">Atau masukkan token manual</label>
            <div class="flex gap-2">
                <input type="text" id="manualToken" placeholder="Masukkan token QR"
                    class="flex-1 rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-[#5C4033] focus:outline-none focus:ring-1 focus:ring-[#5C4033]">
                <button onclick="lookupManual()"
                    class="rounded-md bg-[#5C4033] px-4 py-2 text-sm font-medium text-white hover:bg-[#4a3328] transition-colors">
                    Cari
                </button>
            </div>
        </div>
    </div>

    {{-- Result Panel --}}
    <div class="rounded-lg bg-white p-5 shadow">
        <h2 class="mb-3 text-sm font-semibold text-slate-700">Hasil Scan</h2>
        <div id="scanResult">
            <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                <svg class="mb-3 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <p class="text-sm">Scan QR code untuk melihat detail kunjungan.</p>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div id="toastContainer" class="fixed right-4 top-4 z-50 flex flex-col gap-2"></div>

{{-- Confirmation Modal --}}
<div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Konfirmasi Kunjungan</h3>
            <button onclick="cancelScan()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="visitorInfo" class="mb-6 space-y-2 text-sm"></div>
        <div class="flex justify-end gap-3">
            <button onclick="cancelScan()"
                class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </button>
            <button onclick="confirmScan()" id="confirmBtn"
                class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 transition-colors">
                Konfirmasi Selesai
            </button>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let scanner = null;
    let currentToken = null;
    const CHECK_URL = '{{ url('/admin/scan/check') }}';
    const SCAN_URL = '{{ url('/admin/scan') }}';

    function startScanner() {
        const readerEl = document.getElementById('reader');
        readerEl.innerHTML = '';

        scanner = new Html5QrcodeScanner('reader', { fps: 10, qrbox: 250 }, false);

        scanner.render(
            (decodedText) => {
                setStatus('scanning', 'Memproses...');
                if (scanner) scanner.clear();
                lookupToken(decodedText);
            },
            (error) => {
                console.warn('Scan error:', error);
            }
        );
    }

    function lookupToken(token) {
        currentToken = token;
        setStatus('loading', 'Mencari data...');

        fetch(`${CHECK_URL}/${encodeURIComponent(token)}`)
            .then(res => res.json())
            .then(data => {
                if (data.found) {
                    showConfirmModal(data.data);
                } else {
                    showToast('error', data.message || 'Token tidak ditemukan.');
                    setStatus('idle', 'Token tidak ditemukan');
                    restartScanner();
                }
            })
            .catch(() => {
                showToast('error', 'Gagal menghubungi server.');
                setStatus('idle', 'Gagal terhubung');
                restartScanner();
            });
    }

    function lookupManual() {
        const input = document.getElementById('manualToken');
        const token = input.value.trim();
        if (!token) {
            showToast('error', 'Masukkan token terlebih dahulu.');
            return;
        }
        lookupToken(token);
    }

    function showConfirmModal(data) {
        const info = document.getElementById('visitorInfo');
        const nama = data.nama || data.nama_instansi || '-';
        const statusBadge = data.status_kunjungan === 'completed'
            ? '<span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold uppercase text-emerald-800">Selesai</span>'
            : '<span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold uppercase text-amber-800">Menunggu</span>';

        info.innerHTML = `
            <div class="rounded-lg border p-4 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-slate-800">${nama}</span>
                    ${statusBadge}
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                    <div><span class="font-medium">Email:</span> ${data.email || '-'}</div>
                    <div><span class="font-medium">Tanggal Kunjungan:</span> ${data.tanggal_kunjungan || '-'}</div>
                    <div><span class="font-medium">Tujuan:</span> ${data.tujuan_kunjungan || '-'}</div>
                    <div><span class="font-medium">Jumlah:</span> ${data.jumlah_pengunjung || '-'} orang</div>
                    <div><span class="font-medium">Pembayaran:</span> ${(data.payment_method || '-').toUpperCase()}</div>
                </div>
            </div>
        `;

        const btn = document.getElementById('confirmBtn');
        if (data.status_kunjungan === 'completed') {
            btn.disabled = true;
            btn.className = 'rounded-md bg-slate-300 px-4 py-2 text-sm font-medium text-slate-500 cursor-not-allowed';
            btn.textContent = 'Sudah Selesai';
        } else {
            btn.disabled = false;
            btn.className = 'rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 transition-colors';
            btn.textContent = 'Konfirmasi Selesai';
        }

        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function confirmScan() {
        const btn = document.getElementById('confirmBtn');
        if (btn.disabled) return;

        btn.disabled = true;
        btn.textContent = 'Memproses...';
        setStatus('loading', 'Memproses...');

        fetch(`${SCAN_URL}/${encodeURIComponent(currentToken)}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(res => res.json())
        .then(data => {
            hideConfirmModal();
            if (data.success) {
                showToast('success', `Kunjungan ${data.data.nama} telah selesai!`);
                setStatus('success', 'Scan berhasil');
                const result = document.getElementById('scanResult');
                result.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-8 text-emerald-600">
                        <svg class="mb-3 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-semibold">${data.data.nama}</p>
                        <p class="text-sm text-slate-500">Kunjungan telah selesai</p>
                    </div>
                `;
            } else {
                showToast('error', data.message || 'Gagal memproses scan.');
                setStatus('idle', 'Gagal');
            }
            setTimeout(restartScanner, 2000);
        })
        .catch(() => {
            hideConfirmModal();
            showToast('error', 'Terjadi kesalahan server.');
            setStatus('idle', 'Error');
            restartScanner();
        });
    }

    function cancelScan() {
        hideConfirmModal();
        restartScanner();
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    function restartScanner() {
        setStatus('idle', 'Menunggu scan...');
        currentToken = null;
        const result = document.getElementById('scanResult');
        result.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                <svg class="mb-3 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <p class="text-sm">Scan QR code untuk melihat detail kunjungan.</p>
            </div>
        `;
        startScanner();
    }

    function setStatus(type, text) {
        const el = document.getElementById('scanStatus');
        const colors = {
            idle: 'bg-slate-100 text-slate-600',
            scanning: 'bg-blue-100 text-blue-700',
            loading: 'bg-amber-100 text-amber-700',
            success: 'bg-emerald-100 text-emerald-700',
            error: 'bg-rose-100 text-rose-700',
        };
        el.className = `rounded-full px-3 py-1 text-xs font-medium ${colors[type] || colors.idle}`;
        el.textContent = text;
    }

    function showToast(type, message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        const colors = {
            success: 'bg-emerald-600 text-white',
            error: 'bg-rose-600 text-white',
        };
        toast.className = `flex items-center gap-2 rounded-lg px-4 py-3 text-sm font-medium shadow-lg ${colors[type] || colors.success} animate-slide-in`;
        toast.innerHTML = `
            ${type === 'success'
                ? '<svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                : '<svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
            }
            <span>${message}</span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.transition = 'opacity 0.3s';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        startScanner();
    });

    document.getElementById('manualToken').addEventListener('keydown', (e) => {
        if (e.key === 'Enter') lookupManual();
    });
</script>

<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out; }
    #reader video { border-radius: 0.5rem; }
    #reader .html5-qrcode-element { font-size: 0.8rem; }
</style>
@endsection