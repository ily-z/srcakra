<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Cakraningrat</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo/logomuseum icon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#F5F5DC] text-slate-800">
    @stack('background')

    <header class="no-print border-b border-[#5C4033]/20 bg-[#5C4033] text-white shadow">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('image/logo/logomuseum.png') }}" alt="Museum Cakraningrat" class="h-8 w-auto">
            </a>
            <button id="menuToggle" type="button" class="inline-flex items-center justify-center rounded-md p-2 text-white/90 lg:hidden">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <nav id="navMenu" class="hidden w-full flex-col gap-1 pt-4 text-sm font-medium lg:flex lg:w-auto lg:flex-row lg:items-center lg:gap-4 lg:pt-0">
                <a href="{{ route('home') }}" class="block rounded-md px-3 py-2.5 text-white/90 lg:px-2 lg:py-1">Beranda</a>
                <a href="{{ route('booking.index') }}" class="block rounded-md bg-white/15 px-3 py-2.5 text-white lg:px-3 lg:py-1.5">Ajukan kunjungan</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="no-print mt-auto border-t border-[#5C4033]/30 bg-[#5C4033] px-4 py-6 text-white">
        <div class="mx-auto flex max-w-5xl flex-col gap-2 text-sm md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} Museum Cakraningrat</p>
            <p class="text-white/80">
                Staf?
                <a href="{{ route('admin.analytics') }}" class="font-medium text-white underline decoration-white/50 underline-offset-2 hover:decoration-white">Masuk admin</a>
            </p>
        </div>
    </footer>
<script>
(function() {
    var toggle = document.getElementById('menuToggle');
    var menu = document.getElementById('navMenu');
    var menuIcon = document.getElementById('menuIcon');
    var closeIcon = document.getElementById('closeIcon');
    if (toggle && menu) {
        toggle.addEventListener('click', function() {
            var open = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !open);
            menuIcon.classList.toggle('hidden', !open);
            closeIcon.classList.toggle('hidden', open);
        });
    }
})();
</script>
</body>
</html>
