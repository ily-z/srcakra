@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">Pengajuan Ditolak</h1>

{{-- Desktop Table --}}
<div class="hidden overflow-x-auto rounded-lg bg-white shadow md:block">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">Pendaftar</th>
                <th class="px-3 py-2">Jenis</th>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Tujuan</th>
                <th class="px-3 py-2">Pembayaran</th>
                <th class="px-3 py-2">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan as $item)
                <tr class="border-t align-top">
                    <td class="px-3 py-2">
                        <p class="font-semibold">{{ $item->nama ?: $item->nama_instansi }}</p>
                        <p class="text-slate-500">{{ $item->email }}</p>
                        @if($item->surat_pengajuan)
                            <a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$item->surat_pengajuan) }}">Lihat Dokumen</a>
                        @endif
                    </td>
                    <td class="px-3 py-2 capitalize">{{ $item->jenis_pendaftar }}</td>
                    <td class="px-3 py-2">{{ $item->tanggal_kunjungan }}</td>
                    <td class="px-3 py-2">{{ $item->tujuan_kunjungan }}</td>
                    <td class="px-3 py-2">
                        @php $pay = $item->payment @endphp
                        @if ($pay)
                            <span class="uppercase">{{ $pay->payment_method }}</span>
                            <span class="block text-xs {{ $pay->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                ({{ $pay->status }})
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">
                        <span class="text-xs text-slate-500">{{ $item->catatan_admin ?: '-' }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mobile Cards --}}
<div class="space-y-4 md:hidden">
    @forelse($pengajuan as $item)
        @php $pay = $item->payment @endphp
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="mb-3 flex items-start justify-between">
                <div>
                    <p class="font-semibold">{{ $item->nama ?: $item->nama_instansi }}</p>
                    <p class="text-xs text-slate-500">{{ $item->email }}</p>
                </div>
                <span class="shrink-0 rounded-full bg-rose-100 px-2 py-0.5 text-xs font-bold uppercase text-rose-800">
                    rejected
                </span>
            </div>
            <div class="mb-3 grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-slate-500">Jenis:</span>
                    <span class="ml-1 capitalize">{{ $item->jenis_pendaftar }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Tanggal:</span>
                    <span class="ml-1">{{ $item->tanggal_kunjungan }}</span>
                </div>
                <div class="col-span-2">
                    <span class="text-slate-500">Tujuan:</span>
                    <span class="ml-1">{{ $item->tujuan_kunjungan }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Pembayaran:</span>
                    @if ($pay)
                        <span class="ml-1 uppercase">{{ $pay->payment_method }}</span>
                        <span class="block text-xs {{ $pay->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">({{ $pay->status }})</span>
                    @else
                        <span class="ml-1 text-slate-400">-</span>
                    @endif
                </div>
            </div>
            @if($item->surat_pengajuan)
                <div class="mb-3">
                    <a class="text-xs text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$item->surat_pengajuan) }}">Lihat Dokumen</a>
                </div>
            @endif
            <p class="text-xs text-slate-500">Catatan: {{ $item->catatan_admin ?: '-' }}</p>
        </div>
    @empty
        <div class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow">Belum ada pengajuan ditolak.</div>
    @endforelse
</div>

<div class="mt-4">{{ $pengajuan->links() }}</div>
@endsection
