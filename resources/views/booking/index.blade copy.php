<!-- resources/views/booking/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6">Reservasi Kunjungan Museum</h1>

    <form method="POST" action="/reservations" enctype="multipart/form-data">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded">
        </div>

        <!-- Instansi -->
        <div class="mb-4">
            <label class="block font-medium">Nama Instansi</label>
            <input type="text" name="nama_instansi" class="w-full border p-2 rounded">
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
            <label class="block font-medium">Tanggal Kunjungan</label>
            <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
        </div>

        <!-- Slot -->
        <div class="mb-4">
            <label class="block font-medium">Pilih Slot</label>
            <select name="slot_id" class="w-full border p-2 rounded" required>
                @foreach($slots as $slot)
                    <option value="{{ $slot->id }}">
                        {{ $slot->start_time }} - {{ $slot->end_time }} (Sisa: {{ $slot->capacity }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jumlah -->
        <div class="mb-4">
            <label class="block font-medium">Jumlah Kunjungan</label>
            <input type="number" name="jumlah_kunjungan" class="w-full border p-2 rounded" min="1" required>
        </div>

        <!-- Tujuan -->
        <div class="mb-4">
            <label class="block font-medium">Tujuan</label>
            <textarea name="tujuan" class="w-full border p-2 rounded"></textarea>
        </div>

        <!-- Upload Surat -->
        <div class="mb-4">
            <label class="block font-medium">Surat Pengajuan</label>
            <input type="file" name="surat_pengajuan" class="w-full">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
            Booking Sekarang
        </button>
    </form>
</div>

</body>
</html>