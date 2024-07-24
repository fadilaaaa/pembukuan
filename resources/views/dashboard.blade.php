@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="row flex-nowrap overflow-auto">
            <div class="col-xl-3  mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-1">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Balance (Juli 2024)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-nowrap">Rp. 40.000.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3  mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kas Masuk (Juli 2024)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-nowrap">Rp. 70.000.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3  mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-1">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Kas Keluar (Juli 2024)</div>
                                <div class="h5 mb-0 font-weight-bold text-danger text-nowrap">Rp. -30.000.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-11 col-md-12">
                <div class="card shadow mb-1">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Arus Kas</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="display: flex; justify-content: center">
                            <canvas id="chartKas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function formatRupiah(angka) {
            const numberString = angka.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            return 'Rp ' + numberString;
        }
        const ctx = document.getElementById('chartKas').getContext('2d');
        const labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        const dataKasMasuk = [100000, 150000, 200000, 250000, 300000, 350000, 400000];;
        const dataKasKeluar = [50000, 75000, 100000, 125000, 150000, 175000, 200000];;

        const myChart = new Chart(ctx, {
            type: 'line', // Ubah type menjadi 'line'
            data: {
                labels: labels,
                datasets: [{
                        label: 'Kas Masuk',
                        data: dataKasMasuk,
                        backgroundColor: 'green',
                        borderColor: 'green', // Tambahkan borderColor untuk garis
                    },
                    {
                        label: 'Kas Keluar',
                        data: dataKasKeluar,
                        backgroundColor: 'red',
                        borderColor: 'red', // Tambahkan borderColor untuk garis
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Kas Masuk dan Keluar (Minggu Ini)',
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value, index, values) {
                                return value == 0 ? 0 : formatRupiah(value);
                            },
                            beginAtZero: true,
                        },
                        suggestedMin: 50,
                    },
                },
            },
        });
    </script>
@endpush
@push('styles')
    <style>
        .chart-area {
            width: 100%;
            height: 300px;
        }
    </style>
@endpush
