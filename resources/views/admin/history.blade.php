@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">History Kunjungan</h1>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">Nama/Instansi</th>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Email</th>
                <th class="px-3 py-2">Tujuan</th>
                <th class="px-3 py-2">Jumlah</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungan as $item)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $item->nama ?: $item->nama_instansi }}</td>
                    <td class="px-3 py-2">{{ $item->tanggal_kunjungan }}</td>
                    <td class="px-3 py-2">{{ $item->email }}</td>
                    <td class="px-3 py-2">{{ $item->tujuan_kunjungan }}</td>
                    <td class="px-3 py-2">{{ $item->jumlah_pengunjung }}</td>
                    <td class="px-3 py-2">{{ strtoupper($item->status_kunjungan) }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('admin.history.detail', $item->id_pengunjung) }}" class="text-blue-600 underline text-xs">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-3 py-4 text-center text-slate-500">Belum ada kunjungan selesai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $kunjungan->links() }}</div>
@endsection
