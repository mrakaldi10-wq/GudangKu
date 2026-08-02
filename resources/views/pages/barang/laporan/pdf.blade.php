<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Stok Barang</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .page {
            /* max-width: 80em; */
            /* margin: 0 auto;' */
            /* position: absolute; */
            /* top: 170px; */
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
                <p style="font-size: 18px"><strong><u>Laporan Stok Barang</u></strong></p>

            </div>
            <div class="page">

                <table class="layout display responsive-table" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center; white-space: nowrap;">Barang</th>
                            <th style="text-align: center; white-space: nowrap;">Stok</th>
                            <th style="text-align: center; white-space: nowrap;">Masuk</th>
                            <th style="text-align: center; white-space: nowrap;">Keluar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $row)
                        <tr>
                            <td style="text-align: center; vertical-align: top;">{{ $loop->iteration }}</td>
                            <td style="text-align: left; vertical-align: top; white-space: nowrap;">
                                {{ $row->nama_barang }}
                                <br>
                                <span style="font-size: 10px">
                                    {{ $row->kode }}
                                </span>
                            </td>

                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->stok }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->totalBarangMasuk }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->totalBarangKeluar }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </body>

</html>