<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Data Barang</title>
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
                <p style="font-size: 18px"><strong><u>Laporan Data Barang</u></strong></p>

            </div>
            <div class="page">

                <table class="layout display responsive-table" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center; white-space: nowrap;">Gambar</th>
                            <th style="text-align: center; white-space: nowrap;">Kode</th>
                            <th style="text-align: center; white-space: nowrap;">Nama Barang</th>
                            <th style="text-align: center; white-space: nowrap;">Satuan</th>
                            <th style="text-align: center; white-space: nowrap;">Kategori</th>
                            <th style="text-align: center">Stok</th>
                            <th style="text-align: center">Stok Min</th>
                            <th style="text-align: center">Harga</th>
                            <th style="text-align: center">Keterangan</th>



                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $row)
                        <tr>
                            <td style="text-align: center; vertical-align: top;">{{ $loop->iteration }}</td>
                            <td style="text-align: center; vertical-align: top;">
                                <img width="32px" height="32px" src="data:image/png;base64,{{ $row->image_base_64 }}"
                                    alt="">
                            </td>
                            <td style="text-align: left; vertical-align: top;">
                                {{ $row->kode }}
                            </td>
                            <td style="text-align: left; vertical-align: top; white-space: nowrap;">
                                {{ $row->nama_barang }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->satuan->nama_satuan }}
                            </td>
                            <td style="text-align: center; vertical-align: top;">
                                @foreach ($row->kategoris as $item)
                                {{ $item->nama_kategori }},
                                @endforeach
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->stok }}
                            </td>
                            <td style="text-align: center; vertical-align: top; white-space: nowrap;">
                                {{ $row->min_stok }}
                            </td>
                            <td style="text-align: right; vertical-align: top; white-space: nowrap;">Rp.
                                {{ number_format($row->harga) }}
                            </td>
                            <td style="text-align: left; vertical-align: top;">{{ $row->keterangan }}</td>
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