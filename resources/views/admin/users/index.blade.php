@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="text-2xl font-bold">User Management</h1>
    <a href="{{ route('admin.users.create') }}" class="inline-block rounded bg-[#5C4033] px-4 py-2 text-sm text-white hover:bg-[#4a3328] text-center">+ Tambah User</a>
</div>

{{-- Desktop Table --}}
<div class="hidden overflow-x-auto rounded-lg bg-white shadow md:block">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-3 py-2">Nama</th>
                <th class="px-3 py-2">Email</th>
                <th class="px-3 py-2">Role</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t align-middle">
                    <td class="px-3 py-2 font-semibold">{{ $user->nama }}</td>
                    <td class="px-3 py-2">{{ $user->email }}</td>
                    <td class="px-3 py-2 capitalize">{{ $user->role }}</td>
                    <td class="px-3 py-2">
                        <span class="rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-3 py-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="mr-2 text-blue-600 hover:underline">Edit</a>
                        @if ($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 hover:underline">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mobile Cards --}}
<div class="space-y-4 md:hidden">
    @forelse($users as $user)
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="mb-3 flex items-start justify-between">
                <div>
                    <p class="font-semibold">{{ $user->nama }}</p>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                </div>
                <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-bold uppercase {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="mb-3 text-xs">
                <span class="text-slate-500">Role:</span>
                <span class="ml-1 capitalize">{{ $user->role }}</span>
            </div>
            <div class="flex gap-3 text-xs">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-rose-600 hover:underline">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow">Belum ada user.</div>
    @endforelse
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
