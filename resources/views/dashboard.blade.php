@extends('layouts.app')

@section('title', 'Dashboard Statistik SAMSAT')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Surat Masuk</h6>
                        <h3 class="fw-bold mb-0">{{ $count['masuk'] }}</h3>
                    </div>
                    <i class="fas fa-inbox fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Surat Keluar</h6>
                        <h3 class="fw-bold mb-0">{{ $count['keluar'] }}</h3>
                    </div>
                    <i class="fas fa-paper-plane fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Staff</h6>
                        <h3 class="fw-bold mb-0">{{ $count['staff'] }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Users</h6>
                        <h3 class="fw-bold mb-0">{{ $count['user'] }}</h3>
                    </div>
                    <i class="fas fa-user-shield fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-chart-line text-primary me-2"></i>Tren Surat 6 Bulan Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="mailChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Komposisi Arsip</h6>
            </div>
            <div class="card-body">
                <canvas id="pieChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('mailChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: {!! json_encode($masukData) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Surat Keluar',
                    data: {!! json_encode($keluarData) !!},
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Masuk', 'Keluar'],
            datasets: [{
                data: [{{ $count['masuk'] }}, {{ $count['keluar'] }}],
                backgroundColor: ['#0d6efd', '#198754'],
                hoverOffset: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
