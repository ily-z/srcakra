@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="text-2xl font-bold">Tutup Museum (Hari Libur)</h1>
    <a href="{{ route('admin.disable-days.create') }}" class="inline-block rounded bg-[#5C4033] px-4 py-2 text-sm text-white hover:bg-[#4a3328] text-center">+ Tambah Tanggal</a>
</div>

{{-- Desktop Table --}}
<div class="hidden overflow-x-auto rounded-lg bg-white shadow md:block">
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

{{-- Mobile Cards --}}
<div class="space-y-4 md:hidden">
    @forelse($disableDays as $disableDay)
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="mb-1 font-semibold">{{ \Carbon\Carbon::parse($disableDay->tanggal)->isoFormat('D MMMM YYYY') }}</p>
            <p class="mb-3 text-xs text-slate-500">{{ $disableDay->keterangan ?? 'Tanpa keterangan' }}</p>
            <div class="flex gap-3 text-xs">
                <a href="{{ route('admin.disable-days.edit', $disableDay->id_disday) }}" class="text-blue-600 hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.disable-days.destroy', $disableDay->id_disday) }}" class="inline" onsubmit="return confirm('Hapus tanggal libur ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-rose-600 hover:underline">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow">Belum ada hari libur.</div>
    @endforelse
</div>

<div class="mt-4">{{ $disableDays->links() }}</div>
@endsection
