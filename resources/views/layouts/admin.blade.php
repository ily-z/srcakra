<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Museum Cakraningrat')</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('image/logo/logomuseum icon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        {{-- Overlay --}}
        <div x-show="sidebarOpen" @@click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-30 w-72 -translate-x-full transform bg-[#5C4033] p-6 text-white transition-transform duration-200 ease-in-out lg:static lg:translate-x-0"
               :class="{ 'translate-x-0': sidebarOpen }">
            <div class="mb-8 flex items-center justify-between">
                <img src="{{ asset('image/logo/logomuseum.png') }}" alt="Museum Cakraningrat" class="h-10 w-auto">
                <button @@click="sidebarOpen = false" class="text-white/60 hover:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="space-y-2 text-sm">
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.analytics') }}">Analitik</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.pengajuan') }}">Pengajuan</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.pengajuan.ditolak') }}">Pengajuan Ditolak</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.pembayaran') }}">Pembayaran</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.history') }}">History Kunjungan</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.scanner') }}">QR Scanner</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.users.index') }}">User Management</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.disable-days.index') }}">Tutup Museum</a>
                <hr class="my-3 border-white/20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-md px-3 py-2 text-left hover:bg-white/10">Logout</button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex flex-1 flex-col">
            {{-- Top Bar (mobile) --}}
            <div class="sticky top-0 z-10 flex items-center gap-3 border-b bg-white px-4 py-3 shadow-sm lg:hidden">
                <button @@click="sidebarOpen = true" class="text-slate-600 hover:text-slate-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img src="{{ asset('image/logo/logomuseum.png') }}" alt="Museum Cakraningrat" class="h-8 w-auto">
                <span class="text-sm font-semibold text-slate-600">Admin</span>
            </div>

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-5 rounded-md bg-emerald-100 p-3 text-emerald-800">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-5 rounded-md bg-rose-100 p-3 text-rose-800">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
