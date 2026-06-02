@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Tutup Museum (Hari Libur)</h1>
    <a href="{{ route('admin.disable-days.create') }}" class="rounded bg-[#5C4033] px-4 py-2 text-sm text-white hover:bg-[#4a3328]">+ Tambah Tanggal</a>
</div>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Keterangan</th>
                <th class="px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disableDays as $disableDay)
                <tr class="border-t align-middle">
                    <td class="px-3 py-2 font-semibold">{{ \Carbon\Carbon::parse($disableDay->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                    <td class="px-3 py-2">{{ $disableDay->keterangan ?? '-' }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('admin.disable-days.edit', $disableDay->id_disday) }}" class="mr-2 text-blue-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.disable-days.destroy', $disableDay->id_disday) }}" class="inline" onsubmit="return confirm('Hapus tanggal libur ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-3 py-8 text-center text-slate-400">Belum ada hari libur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $disableDays->links() }}</div>
@endsection
