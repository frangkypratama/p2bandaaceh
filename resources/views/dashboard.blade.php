@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card { border-radius: 0.75rem; border: none; color: white; transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; margin-bottom: 1.5rem; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2); }
    .stat-card .card-body { position: relative; z-index: 2; padding: 1.5rem; }
    .stat-card .stat-number { font-size: 2.2rem; font-weight: 700; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); }
    .stat-card .stat-title { font-size: 0.8rem; text-transform: uppercase; font-weight: 600; }
    
    .stat-card .icon {
        font-size: 3.5rem;
        opacity: 0.2;
        position: absolute;
        right: 15px;
        bottom: 5px;
        transition: transform 0.4s ease-out;
    }
    .stat-card:hover .icon {
        transform: scale(1.1) rotate(-5deg);
    }
    
    /* Card Colors */
    .stat-card-sbp { background: linear-gradient(45deg, #007bff, #1e90ff); }
    .stat-card-petugas { background: linear-gradient(45deg, #28a745, #20c997); }
    .stat-card-kepabeanan { background: linear-gradient(45deg, #6f42c1, #8a5cf5); }
    .stat-card-cukai { background: linear-gradient(45deg, #4c589e, #6673d3); }

    .chart-card { border-radius: 0.75rem; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-bottom: 1.5rem; height: calc(100% - 1.5rem); }
    .fade-in { padding-top: 1.5rem; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="fade-in">

        <!-- Widget Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4"><a href="{{ route('sbp.index') }}" class="text-decoration-none"><div class="card stat-card stat-card-sbp h-100"><div class="card-body"><div class="stat-number">{{ $sbpCount }}</div><div class="stat-title">Total SBP</div><i class="c-icon icon cil-description"></i></div></div></a></div>
            <div class="col-lg-3 col-md-6 mb-4"><a href="{{ route('petugas.index') }}" class="text-decoration-none"><div class="card stat-card stat-card-petugas h-100"><div class="card-body"><div class="stat-number">{{ $petugasCount }}</div><div class="stat-title">Total Petugas</div><i class="c-icon icon cil-shield-alt"></i></div></div></a></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="card stat-card stat-card-kepabeanan h-100"><div class="card-body"><div class="stat-number">{{ $kepabeananCount }}</div><div class="stat-title">Kepabeanan</div><i class="c-icon icon cil-building"></i></div></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="card stat-card stat-card-cukai h-100"><div class="card-body"><div class="stat-number">{{ $cukaiCount }}</div><div class="stat-title">Cukai</div><i class="c-icon icon cil-wallet"></i></div></div></div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card chart-card">
                    <div class="card-header"><h5>Jumlah Penindakan Per Bulan </h5></div>
                    <div class="card-body"><canvas id="main-chart" height="350"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card chart-card">
                    <div class="card-header"><h5>Jenis Barang Hasil Penindakan</h5></div>
                    <div class="card-body"><canvas id="jenisBarangChart" height="350"></canvas></div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row">
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-header"><h5>Jumlah Penindakan Berdasarkan Kota</h5></div>
                    <div class="card-body"><canvas id="kotaChart" height="300"></canvas></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-header"><h5>Top 5 Kecamatan Penindakan</h5></div>
                    <div class="card-body"><canvas id="kecamatanChart" height="300"></canvas></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Helper function for random colors
        const dynamicColors = (count) => {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const h = (i * (360 / count)) % 360;
                colors.push(`hsla(${h}, 70%, 60%, 0.8)`);
            }
            return colors;
        };

        // Data from Controller
        const jenisBarangLabels = @json($jenisBarangLabels);
        const jenisBarangCounts = @json($jenisBarangCounts);
        const kotaLabels = @json($kotaLabels);
        const kotaCounts = @json($kotaCounts);
        const kecamatanLabels = @json($kecamatanLabels);
        const kecamatanCounts = @json($kecamatanCounts);

        // Main Bar Chart
        new Chart(document.getElementById('main-chart').getContext('2d'), {
            type: 'bar', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'], datasets: [{ label: 'Jumlah Dokumen', backgroundColor: 'rgba(52, 152, 219, 0.7)', borderColor: 'rgba(52, 152, 219, 1)', borderRadius: 4, data: [12, 19, 3, 5, 2, 3, 9] }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false } }, y: { beginAtZero: true } } }
        });

        // Jenis Barang Pie Chart
        if (jenisBarangLabels.length > 0) {
            new Chart(document.getElementById('jenisBarangChart').getContext('2d'), {
                type: 'pie',
                data: { labels: jenisBarangLabels, datasets: [{ data: jenisBarangCounts, backgroundColor: dynamicColors(jenisBarangLabels.length), borderColor: '#fff', borderWidth: 2 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        }

        // Kota Horizontal Bar Chart
        if (kotaLabels.length > 0) {
            new Chart(document.getElementById('kotaChart').getContext('2d'), {
                type: 'bar',
                data: { labels: kotaLabels, datasets: [{ label: 'Jumlah Penindakan', data: kotaCounts, backgroundColor: 'rgba(40, 167, 69, 0.7)' }] },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
            });
        }

        // Kecamatan Horizontal Bar Chart
        if (kecamatanLabels.length > 0) {
            new Chart(document.getElementById('kecamatanChart').getContext('2d'), {
                type: 'bar',
                data: { labels: kecamatanLabels, datasets: [{ label: 'Jumlah Penindakan', data: kecamatanCounts, backgroundColor: 'rgba(253, 126, 20, 0.7)' }] },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
            });
        }
    });
</script>
@endpush
