@extends('layouts.app')

@section('content')

<!-- HERO -->
<div class="text-center py-12">
    <h1 class="text-4xl font-bold text-[#5C4033] mb-4">
        Museum Cakraningrat
    </h1>
    <p class="text-lg text-gray-700 mb-6">
        Jelajahi sejarah dan budaya Bangkalan
    </p>

    <a href="/booking" class="bg-[#5C4033] text-white px-6 py-3 rounded-lg">
        Booking Sekarang
    </a>
</div>

<!-- ABOUT -->
<div class="bg-white p-6 rounded-xl shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-3 text-[#5C4033]">
        Tentang Museum
    </h2>
    <p class="text-gray-700">
        Museum Cakraningrat menyimpan berbagai koleksi bersejarah 
        yang menggambarkan perjalanan budaya dan sejarah Bangkalan.
    </p>
</div>

<!-- INFO -->
<div class="grid md:grid-cols-2 gap-6">

    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-semibold mb-2">Jam Operasional</h3>
        <p>Senin - Jumat: 08:00 - 16:00</p>
        <p>Sabtu - Minggu: 09:00 - 17:00</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-semibold mb-2">Harga Tiket</h3>
        <p>Dewasa: Rp10.000</p>
        <p>Anak-anak: Rp5.000</p>
    </div>

</div>

@endsection