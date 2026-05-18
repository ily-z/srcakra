@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">Pengajuan</h1>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">Pendaftar</th>
                <th class="px-3 py-2">Jenis</th>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Tujuan</th>
                <th class="px-3 py-2">Pembayaran</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Aksi</th>
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
                        <span class="rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $item->status_pengajuan === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($item->status_pengajuan === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $item->status_pengajuan }}
                        </span>
                    </td>
                    <td class="px-3 py-2">
                        @if ($item->status_pengajuan === 'pending')
                            <form class="mb-2" method="POST" action="{{ route('admin.pengajuan.approve', $item->id_pendaftar) }}">
                                @csrf
                                <input type="text" name="catatan_admin" class="mb-1 w-full rounded border p-1 text-xs" placeholder="Catatan approve (opsional)" />
                                <button class="rounded bg-emerald-600 px-3 py-1 text-xs text-white">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.pengajuan.reject', $item->id_pendaftar) }}">
                                @csrf
                                <input type="text" name="catatan_admin" class="mb-1 w-full rounded border p-1 text-xs" placeholder="Alasan reject (wajib)" required />
                                <button class="rounded bg-rose-600 px-3 py-1 text-xs text-white">Reject</button>
                            </form>
                        @else
                            <span class="text-xs text-slate-500">{{ $item->catatan_admin ?: '-' }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pengajuan->links() }}</div>
@endsection
