<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ public_path('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Invoice Transaksi {{ $data->code }}</title>
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
    <table class="mb-4" width="100%" cellspacing="0" style="border: 0">
        <tr class="m-0">
            <td width="50%" style="border: 0">
                <p class="fw-bold" style="font-size: 36px">INVOICE</p>
            </td>
            <td width="50%" style="border: 0" class="text-end">
                <img class="w-50" src="{{ public_path('img/logo.png') }}">
            </td>
        </tr>
    </table>
    <table class="mb-4" width="100%" cellspacing="0" style="border: 0">
        <tr class="m-0">
            <td width="33%" style="border: 0;font-size: 16px" class="fw-bold">
                Bill To :
            </td>
            <td width="33%" style="border: 0">

            </td>
            <td width="33%" class="text-end fw-bold" style="border: 0">

            </td>
        </tr>
        <tr class="m-0">
            <td width="33%" class="" style="border: 0">
                {{ $data->user->name }}
            </td>
            <td width="33%" style="border: 0">

            </td>
            <td width="33%" class="text-end fw-bold" style="border: 0">
                #{{ $data->code }}
            </td>
        </tr>
        <tr class="m-0">
            <td width="33%" class="" style="border: 0">
                {{ $data->user->email }}
            </td>
            <td width="33%" style="border: 0">

            </td>
            <td width="33%" class="text-end" style="border: 0">
                {{ $data->format_date }}
            </td>
        </tr>
        <tr class="m-0">
            <td width="33%" class="" style="border: 0">
                {{ $data->user->phone }}
            </td>
            <td width="33%" style="border: 0">

            </td>
            <td width="33%" class="text-end" style="border: 0">
                {{ $data->payment_method }}
            </td>
        </tr>
        <tr class="m-0">
            <td width="33%" class="" style="border: 0">
                {{ $data->user->address }}
            </td>
            <td width="33%" style="border: 0">

            </td>
            <td width="33%" class="text-end fw-bold"
                style="color:{{ $data->status == 'ready' ? 'rgba(255, 0, 0)' : 'rgb(0, 162, 0)' }};border: 0">
                {{ $data->status == 'ready' ? 'Belum Dibayar' : 'Lunas' }}
            </td>

        </tr>
    </table>
    <p class=" mb-2 fw-bold ">Detail Transaksi: </p>
    <table width="100%" cellspacing="0">
        <thead style="background-color: #ebb5b5">
            <tr class="text-center">
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->order as $item)
                <tr>
                    <td class="text-center" style="width:5%">
                        {{ $loop->iteration }}</td>
                    <td>
                        {{ $item->product_name }}
                    </td>
                    <td class="text-center">
                        {{ $item->qty }}
                    </td>
                    <td>
                        Rp {{ $item->format_price }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-center fw-bold">Total Harga</td>
                <td class="fw-bold">Rp {{ $data->format_total_price }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
