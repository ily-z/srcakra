@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">History Kunjungan</h1>

{{-- Desktop Table --}}
<div class="hidden overflow-x-auto rounded-lg bg-white shadow md:block">
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

{{-- Mobile Cards --}}
<div class="space-y-4 md:hidden">
    @forelse($kunjungan as $item)
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="mb-3 flex items-start justify-between">
                <p class="font-semibold">{{ $item->nama ?: $item->nama_instansi }}</p>
                <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $item->status_kunjungan === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ strtoupper($item->status_kunjungan) }}
                </span>
            </div>
            <div class="mb-3 grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-slate-500">Tanggal:</span>
                    <span class="ml-1">{{ $item->tanggal_kunjungan }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Jumlah:</span>
                    <span class="ml-1">{{ $item->jumlah_pengunjung }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Email:</span>
                    <span class="ml-1">{{ $item->email }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Tujuan:</span>
                    <span class="ml-1">{{ $item->tujuan_kunjungan }}</span>
                </div>
            </div>
            <a href="{{ route('admin.history.detail', $item->id_pengunjung) }}" class="text-xs text-blue-600 underline">Lihat Detail</a>
        </div>
    @empty
        <div class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow">Belum ada kunjungan selesai.</div>
    @endforelse
</div>

<div class="mt-4">{{ $kunjungan->links() }}</div>
@endsection
