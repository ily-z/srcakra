<!-- resources/views/admin/dashboard.blade.php -->

<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Daftar Reservasi</h1>

    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reservations as $r)
            <tr class="border-t">
                <td>{{ $r->nama }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>{{ $r->jumlah_kunjungan }}</td>
                <td>{{ $r->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>