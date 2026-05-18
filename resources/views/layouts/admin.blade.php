<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Museum</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-[#5C4033] text-white p-6">
            <div class="mb-8">
                <p class="text-xs uppercase tracking-wide text-white/70">Logo</p>
                <h1 class="text-2xl font-bold">Museum Cakraningrat</h1>
            </div>
            <nav class="space-y-2 text-sm">
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.analytics') }}">Analitik</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.pengajuan') }}">Pengajuan</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.pembayaran') }}">Pembayaran</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.history') }}">History Kunjungan</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.scanner') }}">QR Scanner</a>
                <a class="block rounded-md px-3 py-2 hover:bg-white/10" href="{{ route('admin.users.index') }}">User Management</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            @if (session('success'))
                <div class="mb-5 rounded-md bg-emerald-100 p-3 text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-5 rounded-md bg-rose-100 p-3 text-rose-800">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
