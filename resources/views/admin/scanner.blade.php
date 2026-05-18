@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">QR Scanner</h1>

<div class="rounded-lg bg-white p-5 shadow">
    <p class="mb-4 text-sm text-slate-600">Gunakan kamera untuk scan QR token kunjungan. Setelah scan, status kunjungan akan menjadi selesai.</p>
    <div id="reader" class="max-w-md"></div>
    <form id="scanForm" method="POST" class="mt-4 hidden">
        @csrf
    </form>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText) {
        const form = document.getElementById('scanForm');
        form.action = `{{ route('admin.scan', '') }}/${encodeURIComponent(decodedText)}`;
        form.submit();
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        'reader',
        { fps: 10, qrbox: 250 },
        false
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection
