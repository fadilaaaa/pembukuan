<!DOCTYPE html>
<html>

<head>
    <title>Laporan Arus Kas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .report-header {
            display: flex;
            width: 100vw;
            text-align: center;
        }

        .report-header .logo {
            /* width: 100px; */
            display: flex;
        }

        .report-header img {
            width: 200px;
            margin: auto;
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

        .text-nowrap {
            white-space: nowrap !important;
        }

        td {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        thead {
            background-color: #f2f2f2;
        }

        .saldo-awal {
            background-color: #c9ecd9;
        }
    </style>
</head>

<body>
    <table align="center" style="margin-bottom: 1rem">
        <tr>
            <td>
                <img src="{{ public_path('img/logoPrint.webp') }}" alt="Company Logo" width="150" height="150">
            </td>
            <td>
                <center>
                    <font size="6"><b>BUKU KAS</b></font><BR>
                    <font size="3">{{ $start_date }} - {{ $end_date }}</font>
                </center>
            </td>
        </tr>
    </table>
    <table class="report-body">
        <thead>
            <tr>
                <th>Nomor Kas</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>debet</th>
                <th>kredit</th>
                <th>saldo</th>
                <th class="no-sort">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $debet = 0;
                $kredit = 0;
                $saldo = $saldoAwal;
            @endphp
            @foreach ($kas as $item)
                @if ($loop->first)
                    <tr class="saldo-awal">
                        <td colspan="6" style="text-align: center">Saldo Awal</td>
                        <td><strong>Rp. {{ number_format($saldo, 0, ',', '.') }}</strong></td>
                        <td>Saldo Awal</td>
                    </tr>
                @endif
                <tr>
                    <td class="text-nowrap">{{ $item->no_kas }}</td>
                    <td class="text-nowrap">{{ $item->tanggal }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>
                        @if ($item->kategoris)
                            @foreach ($item->kategoris as $kategori)
                                {{ $kategori->nama }}
                            @endforeach
                        @endif

                    </td>
                    <td class="text-nowrap"><strong>
                            @if ($item->jenis == 'masuk')
                                Rp. {{ number_format($item->jumlah, 0, ',', '.') }}
                                @php
                                    $debet += $item->jumlah;
                                    $saldo += $item->jumlah;
                                @endphp
                            @else
                                -
                            @endif
                        </strong>
                    </td>
                    <td class="text-nowrap"><strong>
                            @if ($item->jenis == 'keluar')
                                Rp. {{ number_format($item->jumlah, 0, ',', '.') }}
                                @php
                                    $kredit += $item->jumlah;
                                    $saldo -= $item->jumlah;
                                @endphp
                            @else
                                -
                            @endif
                        </strong>
                    </td>
                    <td class="text-nowrap"><strong>Rp. {{ number_format($saldo, 0, ',', '.') }}</strong></td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td class="text-nowrap"><strong>Rp. {{ number_format($debet, 0, ',', '.') }}</strong></td>
                <td class="text-nowrap"><strong>Rp. {{ number_format($kredit, 0, ',', '.') }}</strong></td>
                <td class="text-nowrap"><strong>Rp. {{ number_format($saldo, 0, ',', '.') }}</strong></td>
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
                <p class="mb-1"></p>
                <p class="mb-1">Bendahara</p>
                <br>
                <br>
                <p>{{ $bendahara }}</p>
            </td>
        </tr>
    </table>
</body>

</html>
