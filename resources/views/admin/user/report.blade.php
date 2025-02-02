<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ public_path('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Laporan Daftar Pengguna</title>
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
    <p class="text-center mb-4 fw-bold ">Laporan Daftar Pengguna</p>

    <table width="100%" cellspacing="0">
        <thead>
            <tr class="text-center" style="background-color: #ebb5b5">
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>No Telp</th>
                <th>Role</th>
                <th>Tanggal Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr style="font-size: 12px">
                    <td class="text-center" style="width:5%">
                        {{ $loop->iteration }}</td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->email }}
                    </td>
                    <td>
                        {{ $item->address }}
                    </td>
                    <td>
                        +62{{ $item->phone }}
                    </td>
                    <td>
                        @switch($item->role)
                            @case('superadmin')
                                <span class="">Superadmin</span>
                            @break

                            @case('bendahara')
                                <span class="">Bendahara</span>
                            @break

                            @case('warehouse')
                                <span class="">Warehouse</span>
                            @break

                            @case('admin_toko')
                                <span class="">Admin Toko</span>
                            @break

                            @case('admin_kepala')
                                <span class="">Admin Toko</span>
                            @break

                            @default
                                <span class="">User</span>
                            @break
                        @endswitch
                    </td>
                    <td>
                        {{ $item->format_email_verified_at ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
