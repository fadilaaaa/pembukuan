<!DOCTYPE html>
<html>

<head>
    <title>Laporan Arus Kas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ url('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header img {
            width: 100px;
        }

        .report-body {
            width: 100%;
            border-collapse: collapse;
        }

        .report-body th,
        .report-body td {
            border: 1px solid black;
            padding: 8px;
        }

        .report-footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="report-header">
        <img src="{{ url('img/logo.webp') }}" alt="Company Logo">
        <h1 class="mb-1">Laporan Arus Kas</h1>
        <h2 class="mb-1">KOPERASI JASA KELUARGA SEHAT SEJAHTERA</h2>
        <h2>{{ $start_date }} - {{ $end_date }}</h2>
    </div>

    <table class="report-body">
        <thead>
            <tr>
                <th>Nomor Kas</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th class="no-sort">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($kas as $item)
                <tr>
                    <td class="text-nowrap">{{ $item->no_kas }}</td>
                    <td class="text-nowrap">{{ $item->tanggal }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>
                        @if ($item->kategoris)
                            @foreach ($item->kategoris as $kategori)
                                <span class="badge {{ $kategori->class }}">{{ $kategori->nama }}
                                </span>
                            @endforeach
                        @endif
                    </td>
                    <td>Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    @php
                        $total += $item->jumlah;
                    @endphp
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td class="text-nowrap"><strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tr style="text-align: center">
            <td>
                <p class="mb-1">Mengetahui</p>
                <p class="mb-1">Ketua</p>
                <br>
                <br>
                <p>{{ $ketua }}</p>
            </td>
            <td>
                <p class="mb-1">Mengetahui</p>
                <p class="mb-1">Bendahara</p>
                <br>
                <br>
                <p>{{ $bendahara }}</p>
            </td>
        </tr>
    </table>
</body>

</html>
