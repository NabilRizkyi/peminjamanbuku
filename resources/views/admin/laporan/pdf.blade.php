<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
        }

        .summary h4 {
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        .summary p {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: bold;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
        }

        table.data td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        table.data tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h2>LAPORAN PEMINJAMAN BUKU</h2>
    <small>Sistem Perpustakaan</small>
</div>

<div class="periode">
    Periode: <b>{{ $periode }}</b>
</div>

<!-- SUMMARY -->
<table class="summary">
    <tr>
        <td>
            <h4>Total Peminjaman</h4>
            <p>{{ $totalPeminjaman }}</p>
        </td>
        <td>
            <h4>Total Denda</h4>
            <p>Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </td>
        <td>
            <h4>Total Buku</h4>
            <p>{{ $totalBuku }}</p>
        </td>
        <td>
            <h4>Total Anggota</h4>
            <p>{{ $totalAnggota }}</p>
        </td>
    </tr>
</table>

<!-- TABLE -->
<table class="data">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Buku</th>
            <th>Tanggal</th>
            <th>Durasi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->book->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>{{ $item->durasi }} hari</td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    <p>{{ now()->format('d-m-Y') }}</p>
    <br><br>
    <p><strong>Admin</strong></p>
</div>

</body>
</html>