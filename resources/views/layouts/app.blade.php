<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Cakraningrat</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#F5F5DC] text-slate-800">

    <header class="border-b border-[#5C4033]/20 bg-[#5C4033] text-white shadow">
        <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-3 px-4 py-4">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight">Museum Cakraningrat</a>
            <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
                <a href="{{ route('home') }}" class="rounded-md px-2 py-1 hover:bg-white/10">Beranda</a>
                <a href="{{ route('booking.index') }}" class="rounded-md bg-white/15 px-3 py-1.5 text-white hover:bg-white/25">Ajukan kunjungan</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-[#5C4033]/30 bg-[#5C4033] px-4 py-6 text-white">
        <div class="mx-auto flex max-w-5xl flex-col gap-2 text-sm md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} Museum Cakraningrat</p>
            <p class="text-white/80">
                Staf?
                <a href="{{ route('admin.analytics') }}" class="font-medium text-white underline decoration-white/50 underline-offset-2 hover:decoration-white">Masuk admin</a>
            </p>
        </div>
    </footer>
</body>
</html>
