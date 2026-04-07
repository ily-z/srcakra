<!-- resources/views/ticket/show.blade.php -->

<div class="max-w-xl mx-auto mt-10 text-center">
    <h1 class="text-2xl font-bold">Tiket Anda</h1>

    <div class="mt-6 p-4 border rounded">
        <p>Kode Tiket:</p>
        <h2 class="text-xl font-bold">{{ $ticket->qr_code }}</h2>

        <!-- QR nanti di sini -->
    </div>
</div>