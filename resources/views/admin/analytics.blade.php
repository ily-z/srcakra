@extends('layouts.admin')

@section('content')
<h1 class="mb-6 text-2xl font-bold">Analitik</h1>

<div class="mb-6 grid gap-4 md:grid-cols-2">
    <div class="rounded-lg bg-white p-4 shadow">
        <p class="text-sm text-slate-500">Kunjungan Selesai</p>
        <p class="text-3xl font-bold">{{ $kunjunganSelesai }}</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <p class="text-sm text-slate-500">Kunjungan Diajukan</p>
        <p class="text-3xl font-bold">{{ $kunjunganDiajukan }}</p>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Chart Kunjungan</h2>
        <canvas id="visitChart" height="120"></canvas>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Total Pendapatan Perbulan</h2>
        <canvas id="revenueChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const visitCtx = document.getElementById('visitChart');
    const revenueCtx = document.getElementById('revenueChart');

    new Chart(visitCtx, {
        type: 'line',
        data: {
            labels: @json($labelsVisit),
            datasets: [{ label: 'Kunjungan', data: @json($valuesVisit), borderColor: '#5C4033', fill: false }]
        }
    });

    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: @json($labelsRevenue),
            datasets: [{ label: 'Pendapatan', data: @json($valuesRevenue), backgroundColor: '#1d4ed8' }]
        }
    });
</script>
@endsection
