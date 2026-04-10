<!DOCTYPE html>
<html>
<head>
    <title>Museum Cakraningrat</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5DC]">

    <x-navbar />

    <main class="max-w-4xl mx-auto p-6">
        @yield('content')
    </main>

</body>
</html>