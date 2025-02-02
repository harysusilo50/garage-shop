<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ public_path('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Laporan Keuangan</title>
    <style>
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            border-collapse: collapse;
        }

        @font-face {
            font-family: "source_sans_proregular";
            src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;

        }

        * {
            font-family: "source_sans_proregular", Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
        }
    </style>

</head>

<body>
    <p class="text-center mb-4 fw-bold ">Laporan Keuangan</p>

    <table class="mb-4" width="100%" cellspacing="0"style="border: 0">
        <tr>
            <td width="15%" style="border: 0">
                <p class="fw-bold m-0">Tanggal</p>
            </td>
            <td style="border: 0">
                @if (!empty($date_start) && !empty($date_end))
                    <p class="m-0">: {{ Carbon\Carbon::parse($date_start)->format('d M Y') }} -
                        {{ Carbon\Carbon::parse($date_end)->format('d M Y') }}</p>
                @else
                    <p class="m-0">: Keseluruhan</p>
                @endif
            </td>
        </tr>
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Pemasukan</p>
            </td>
            <td style="border: 0">
                <p class="m-0">: Rp{{ number_format($pemasukan, 0, ',', '.') }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Pengeluaran</p>
            </td>
            <td style="border: 0">
                <p class="m-0 ">: Rp{{ number_format($pengeluaran, 0, ',', '.') }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Profit</p>
            </td>
            <td style="border: 0">
                <p class="m-0 ">: Rp{{ number_format($keuntungan, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>
    <p class=" mb-2 fw-bold ">Detail Transaksi: </p>
    <table width="100%" cellspacing="0">
        <thead style="background-color: #ebb5b5">
            <tr class="text-center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr style="  {{ $item->type != 'in' ? '' : 'background-color:#dc35468f;' }}">
                    <td class="text-center" style="width:5%">
                        {{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $item->format_date }}
                    </td>
                    <td class="text-center">
                        @if ($item->type != 'in')
                            IN
                        @else
                            OUT
                        @endif
                    </td>
                    <td class="{{ $item->type != 'in' ? 'text-start' : 'text-end' }} px-1">
                        Rp {{ $item->format_amount }}
                    </td>
                    <td class="px-1" style="width:45%">
                        {{ $item->description }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
