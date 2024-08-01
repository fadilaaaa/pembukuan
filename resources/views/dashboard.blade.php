@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="row flex-nowrap overflow-auto">
            {{-- <div class="col-xl-3  mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-1">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Balance Hari Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-nowrap">Rp. 40.000.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-3  mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kas Masuk Hari Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-nowrap">Rp.
                                    {{ number_format($kasMasukHariIni, 0, ',', '.') }}</div>
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
                                    Kas Keluar Hari Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-danger text-nowrap">Rp.
                                    -{{ number_format($kasKeluarHariIni, 0, ',', '.') }}</div>
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
        const dataKasMasuk = @json($grafikKasMasuk);
        console.log(dataKasMasuk);

        const dataKasKeluar = @json($grafikKasKeluar);

        const myChart = new Chart(ctx, {
            type: 'line', // Ubah type menjadi 'line'
            data: {
                labels: labels,
                datasets: [{
                        label: 'Kas Masuk',
                        data: Object.keys(dataKasMasuk).map((key) => {
                            return {
                                x: key,
                                y: dataKasMasuk[key]
                            }
                        }),
                        backgroundColor: 'green',
                        borderColor: 'green', // Tambahkan borderColor untuk garis
                    },
                    {
                        label: 'Kas Keluar',
                        data: Object.keys(dataKasKeluar).map((key) => {
                            return {
                                x: key,
                                y: dataKasKeluar[key]
                            }
                        }),
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
