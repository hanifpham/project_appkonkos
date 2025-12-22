<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Kosan</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: popins, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .border-bottom {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
            text-align: center;
        }

        th {
            font-weight: bold;
            background: #0d6efd !important;
        }

        .logo {
            width: 80px;
            margin-bottom: 5px;
        }

        .status {
            padding: 4px 6px;
            color: #fff;
            border-radius: 4px;
            font-weight: bold;
        }

        .tersedia {
            background: green;
        }

        .tidak {
            background: gray;
        }

        .penuh {
            background: red;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="text-center border-bottom">
            <img src="{{ public_path('image/icon_apkonkos.png') }}" class="logo">
            <h2>Laporan Data Kosan</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kosan</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Harga/Bulan</th>
                    <th>Gambar Utama</th>
                    <th>Detail Gambar</th>
                    <th>Fasilitas Kosan</th>
                    <th>Fasilitas Umum</th>
                    <th>Peraturan Kosan</th>
                    <th>Kamar Tersedia</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->nama_kosan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->kontak_kosan }}</td>
                        <td>Rp {{ number_format($item->harga_bulan, 0, ',', '.') }}</td>

                        <td>
                            @php
                                $gambarUtama = $item->gambar_kosan ? storage_path('app/public/' . ltrim($item->gambar_kosan, '/')) : null;
                            @endphp

                            @if ($gambarUtama && file_exists($gambarUtama))
                                <img src="{{ $gambarUtama }}" width="80">
                            @endif
                        </td>

                        <td>
                            @php
                                $images = [];

                                if ($item->detail_kosan) {
                                    if (is_array(json_decode($item->detail_kosan, true))) {
                                        $images = json_decode($item->detail_kosan, true);
                                    } else {
                                        $images = explode('|', $item->detail_kosan);
                                    }
                                }
                            @endphp

                            @foreach ($images as $img)
                                @php
                                    $detailPath = $img ? storage_path('app/public/' . ltrim($img, '/')) : null;
                                @endphp

                                @if ($detailPath && file_exists($detailPath))
                                    <img src="{{ $detailPath }}" width="60" style="margin:3px;">
                                @endif
                            @endforeach
                        </td>


                        <td>{{ $item->fasilitas_kosan }}</td>
                        <td>{{ $item->fasilitas_umum }}</td>
                        <td>{{ $item->peraturan_kosan }}</td>
                        <td>{{ $item->kamar_yang_tersedia }}</td>

                        <td>
                            <span
                                class="status 
                                            {{ $item->status == 'tersedia' ? 'tersedia' : ($item->status == 'tidak tersedia' ? 'tidak' : 'penuh') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
