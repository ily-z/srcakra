<!DOCTYPE html>
<html>
<head>
    <title>Museum Cakraningrat</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5DC]">

    <nav class="bg-[#5C4033] text-white p-4">
        <div class="max-w-4xl mx-auto flex justify-between">
            <span class="font-bold">Museum</span>
            <a href="/" class="mr-4">Home</a>
            <a href="/booking">Booking</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6">
        @yield('content')
    </main>

</body>
</html>