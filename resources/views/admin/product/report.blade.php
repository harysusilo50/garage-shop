<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ public_path('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Laporan Stok Produk</title>
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
    <p class="text-center mb-4 fw-bold ">Laporan Stok Produk</p>

    <table class="mb-4" width="100%" cellspacing="0"style="border: 0">
        <tr>
            <td width="18%" style="border: 0">
                <p class="fw-bold m-0">Tanggal</p>
            </td>
            <td style="border: 0">
                <p class="m-0">: {{ Carbon\Carbon::now()->format('d M Y') }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="18%" style="border: 0">
                <p class="m-0 fw-bold">Jumlah Produk</p>
            </td>
            <td style="border: 0">
                <p class="m-0">: {{ $jumlah_produk }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="18%" style="border: 0">
                <p class="m-0 fw-bold">Produk Habis</p>
            </td>
            <td style="border: 0">
                <p class="m-0 ">: {{ $produk_habis }}</p>
            </td>
        </tr>
    </table>

    <p class=" mb-2 fw-bold ">Detail Produk : </p>
    <table width="100%" cellspacing="0">
        <thead style="background-color: #ebb5b5">
            <tr class="text-center align-middle">
                <th rowspan="2">No</th>
                <th rowspan="2">Gambar</th>
                <th rowspan="2">Nama Produk</th>
                <th colspan="3">Stok</th>
            </tr>
            <tr class="text-center align-middle">
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Sisa</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center" style="width:5%">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center" style="width: 20%">
                        <img class="w-75" src="{{ public_path('/storage/product_thumbnail/' . $item->thumbnail) }}">
                    </td>
                    <td class="px-2">
                        {{ $item->name }}
                    </td>
                    <td class="text-center">
                        {{ $item->stock_in }}
                    </td>
                    <td class="text-center">
                        {{ $item->stock_out }}
                    </td>
                    <td class="text-center"
                        style="background-color: {{ $item->stock == 0 ? 'rgb(253, 100, 100)' : '' }}">
                        {{ $item->stock }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
