<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Barang Pending</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .page {
            position: relative;
            top: 5;
        }

        table th,
        table td {
            text-align: left;
        }

        table.layout {
            width: 100%;
            border-collapse: collapse;
        }

        table.display {
            margin: 1em 0;
        }

        table.display th,
        table.display td {
            border: 1px solid #B3BFAA;
            padding: .5em 1em;
        }

        table.display th {
            background: #D5E0CC;
        }

        table.display td {
            background: #fff;
        }

        table.responsive-table {
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }

        .garis {
            margin-top: 20px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
        }
    </style>
</head>

<body>

    <body>
        @include('partials.report-header-pdf')
        <div style="text-align: center">
            <div style="text-align: center">
                <p style="font-size: 18px"><strong><u>Laporan Barang Pending</u></strong></p>
                @if(request()->from_date)
                <div style="font-size: 14px">Periode :
                    {{ \Carbon\Carbon::parse(request()->from_date)->format('d M Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse(request()->to_date)->format('d M Y') }}
                </div>
                @endif
                <div style="font-size: 14px">Total : {{ $barangPendings->count() }} transaksi</div>
            </div>
            <div class="page">

                <table class="layout display responsive-table" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center; white-space: nowrap;">Tgl Pending</th>
                            <th style="text-align: center; white-space: nowrap;">No. Transaksi</th>
                            <th style="text-align: center; white-space: nowrap;">Pelanggan</th>
                            <th style="text-align: center; white-space: nowrap;">Total Qty</th>
                            <th style="text-align: center; white-space: nowrap;">Total Harga</th>
                            <th style="text-align: center; white-space: nowrap;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangPendings as $row)
                        <tr>
                            <td style="text-align: center; vertical-align: top;">{{ $loop->iteration }}</td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ \Carbon\Carbon::parse($row->tgl_pending)->format('d M Y') }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->no_transaksi }}
                            </td>
                            <td style="text-align: left; vertical-align: top; white-space: nowrap;">
                                {{ optional($row->pelanggan)->nama_pelanggan ?? '-' }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->total_qty }}
                            </td>
                            <td style="text-align: right; vertical-align: top; white-space: nowrap;">
                                Rp. {{ number_format($row->total_harga) }}
                            </td>
                            <td style="text-align: left; vertical-align: top;">
                                {{ $row->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No Data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </body>

</html>