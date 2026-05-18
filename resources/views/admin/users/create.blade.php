@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Tambah User Admin</h1>
</div>

<div class="rounded-lg bg-white p-6 shadow">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded border px-3 py-2 text-sm @error('nama') border-red-500 @enderror" required>
            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border px-3 py-2 text-sm @error('email') border-red-500 @enderror" required>
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full rounded border px-3 py-2 text-sm @error('password') border-red-500 @enderror" required>
            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full rounded border px-3 py-2 text-sm" required>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded bg-[#5C4033] px-6 py-2 text-sm text-white hover:bg-[#4a3328]">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="rounded bg-slate-200 px-6 py-2 text-sm text-slate-700 hover:bg-slate-300">Batal</a>
        </div>
    </form>
</div>
@endsection
