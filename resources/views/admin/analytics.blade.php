@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">Analitik</h1>

<div class="mb-6 grid gap-4 sm:grid-cols-2">
    <div class="rounded-lg bg-white p-4 shadow">
        <p class="text-sm text-slate-500">Kunjungan Selesai</p>
        <p class="text-2xl font-bold md:text-3xl">{{ $kunjunganSelesai }}</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <p class="text-sm text-slate-500">Kunjungan Diajukan</p>
        <p class="text-2xl font-bold md:text-3xl">{{ $kunjunganDiajukan }}</p>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Chart Kunjungan</h2>
        <div class="relative w-full">
            <canvas id="visitChart"></canvas>
        </div>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Total Pendapatan Perbulan</h2>
        <div class="relative w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isMobile = window.innerWidth < 768;
    const fontSize = isMobile ? 10 : 12;

    new Chart(document.getElementById('visitChart'), {
        type: 'line',
        data: {
            labels: @json($labelsVisit),
            datasets: [{ label: 'Kunjungan', data: @json($valuesVisit), borderColor: '#5C4033', fill: false }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { labels: { font: { size: fontSize } } } },
            scales: { x: { ticks: { font: { size: fontSize } } }, y: { ticks: { font: { size: fontSize } } } }
        }
    });

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsRevenue),
            datasets: [{ label: 'Pendapatan', data: @json($valuesRevenue), backgroundColor: '#1d4ed8' }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { labels: { font: { size: fontSize } } } },
            scales: { x: { ticks: { font: { size: fontSize } } }, y: { ticks: { font: { size: fontSize } } } }
        }
    });
</script>
@endsection
