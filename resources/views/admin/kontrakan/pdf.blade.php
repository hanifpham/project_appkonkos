<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Kontrakan</title>
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

        th,td 
        {
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
            <h2>Laporan Data Kontrakan</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kontrakan</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Harga/Tahun</th>
                    <th>Luas Kontrakan</th>
                    <th>Gambar Utama</th>
                    <th>Detail Gambar</th>
                    <th>Jumlah Kamar</th>
                    <th>fasilitas Kontrakan</th>
                    <th>Fasilitas Umum</th>
                    <th>Peraturan Kontrakan</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->nama_kontrakan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->kontak_kontrakan }}</td>
                        <td>Rp {{ number_format($item->harga_tahun, 0, ',', '.') }}</td>
                        <td>{{ $item->luas_kontrakan }}</td>

                        <td>
                            @if ($item->gambar_kontrakan)
                                <img src="{{ public_path('storage/' . $item->gambar_kontrakan) }}" width="80">
                            @endif
                        </td>

                        <td>
                            @php
                                $images = [];

                                if ($item->detail_kontrakan) {
                                    if (is_array(json_decode($item->detail_kontrakan, true))) {
                                        $images = json_decode($item->detail_kontrakan, true);
                                    } else {
                                        $images = explode('|', $item->detail_kontrakan);
                                    }
                                }
                            @endphp

                            @foreach ($images as $img)
                                <img src="{{ public_path('storage/' . $img) }}" width="60" style="margin:3px;">
                            @endforeach
                        </td>
                        <td>{{$item->jumlah_kamar}}</td>
                        <td>{{ $item->fasilitas_kontrakan }}</td>
                        <td>{{ $item->fasilitas_umum }}</td>
                        <td>{{ $item->peraturan_kontrakan }}</td>
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
