@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-[#5C4033]">
    Booking Kunjungan
</h1>

<div class="bg-white p-6 rounded-xl shadow-md">

    <form method="POST">
        @csrf

        <h2 class="text-xl font-semibold mb-4">Data Pengunjung</h2>

        <input class="w-full mb-3 p-3 border rounded" placeholder="Nama">
        <input class="w-full mb-3 p-3 border rounded" placeholder="Email">

        <h2 class="text-xl font-semibold mt-6 mb-4">Detail Kunjungan</h2>

        <input type="date" class="w-full mb-3 p-3 border rounded">
        <input type="number" class="w-full mb-3 p-3 border rounded" placeholder="Jumlah Orang">

        <button class="bg-[#5C4033] text-white px-6 py-3 rounded mt-4">
            <div class="item-center">
                <p class="text-center">
                    Booking Sekarang
                </p>
            </div>
        </button>
    </form>
</div>
@endsection