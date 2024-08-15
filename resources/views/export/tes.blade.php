<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #logo {
            position: fixed;
            top: 1rem;
            left: 1rem;
        }
    </style>
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
            width: 50%;
            border-collapse: collapse;
            margin: auto;
            margin-top: 25px;
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
    </style>
</head>

<body>
    <img id="logo" src="{{ url('img/logoPrint.webp') }}" alt="Company Logo" width="150" height="150">
    <table align="center" style="margin-bottom: 1rem;height:150px;rem:2.5rem">
        <tr>
            <td>
                <center style="margin-top: 50px">
                    <font size="6"><b>BUKTI PENGELUARAN</b></font><BR>
                    {{-- <font size="3"></font> --}}
                </center>
            </td>
        </tr>
    </table>
    <table class="report-body">
        <thead>
            <tr>
                <th>Nomor Kas</th>
                <th>Tanggal</th>
                <th class="no-sort">Keterangan</th>
                <th>Jumlah Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp

            @foreach ($kas as $item)
                <tr>
                    @php
                        $total += $item->jumlah;
                    @endphp
                    <td class="text-nowrap">{{ $item->no_kas }}</td>
                    <td class="text-nowrap">{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-nowrap">Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" class="text-right">Total</td>
                <td class="text-nowrap"><strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong></td>
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
