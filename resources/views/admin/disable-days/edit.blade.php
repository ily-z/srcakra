@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Edit Tanggal Tutup Museum</h1>
</div>

<div class="rounded-lg bg-white p-4 shadow md:p-6">
    <form method="POST" action="{{ route('admin.disable-days.update', $disableDay->id_disday) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', $disableDay->tanggal) }}" class="w-full rounded border px-3 py-2 text-sm @error('tanggal') border-red-500 @enderror" required>
            @error('tanggal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Keterangan <span class="text-xs text-slate-400">(opsional)</span></label>
            <input type="text" name="keterangan" value="{{ old('keterangan', $disableDay->keterangan) }}" class="w-full rounded border px-3 py-2 text-sm @error('keterangan') border-red-500 @enderror">
            @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:gap-3">
            <button type="submit" class="rounded bg-[#5C4033] px-6 py-2 text-sm text-white hover:bg-[#4a3328]">Simpan</button>
            <a href="{{ route('admin.disable-days.index') }}" class="rounded bg-slate-200 px-6 py-2 text-sm text-slate-700 hover:bg-slate-300 text-center">Batal</a>
        </div>
    </form>
</div>
@endsection
