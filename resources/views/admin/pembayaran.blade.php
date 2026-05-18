@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">Pembayaran</h1>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Nama/Instansi</th>
                <th class="px-3 py-2">Method</th>
                <th class="px-3 py-2">Status Payment</th>
                <th class="px-3 py-2">Status Pengajuan</th>
                <th class="px-3 py-2">Total</th>
                <th class="px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $pay)
                @php $p = $pay->pendaftar @endphp
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $pay->id_payment }}</td>
                    <td class="px-3 py-2">
                        {{ $p?->nama ?: $p?->nama_instansi ?: '-' }}
                        <span class="block text-xs text-slate-500 capitalize">{{ $p?->jenis_pendaftar ?? '-' }}</span>
                    </td>
                    <td class="px-3 py-2 uppercase">{{ $pay->payment_method }}</td>
                    <td class="px-3 py-2">
                        <span class="rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $pay->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $pay->status }}
                        </span>
                    </td>
                    <td class="px-3 py-2">
                        @if ($p)
                            <span class="rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $p->status_pengajuan === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($p->status_pengajuan === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $p->status_pengajuan }}
                            </span>
                        @else
                            <span class="text-xs text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">Rp {{ number_format($pay->total, 0, ',', '.') }}</td>
                    <td class="px-3 py-2">
                        @if ($pay->status === 'paid')
                            <span class="text-emerald-700 text-xs font-semibold">Lunas</span>
                        @else
                            <div class="flex flex-col gap-1">
                                @if ($p && $p->status_pengajuan === 'approved')
                                    <form method="POST" action="{{ route('admin.pembayaran.request', $pay->id_payment) }}">
                                        @csrf
                                        <button class="rounded bg-sky-600 px-3 py-1 text-xs text-white">Request Payment</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.pembayaran.paid', $pay->id_payment) }}">
                                    @csrf
                                    <button class="rounded bg-blue-600 px-3 py-1 text-xs text-white">Set Paid</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $payments->links() }}</div>
@endsection
