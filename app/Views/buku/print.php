<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku - Pinbook</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
        }

        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>Laporan Data Koleksi Buku</h2>
        <p>Pinbook Digital Library System | Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th width="8%">Tahun</th>
                <th width="8%">Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buku)): ?>
                <?php $no = 1; foreach ($buku as $b): ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><strong><?= $b['judul'] ?></strong></td>
                        <td><?= $b['nama_kategori'] ?></td>
                        <td><?= $b['nama_penulis'] ?></td>
                        <td><?= $b['nama_penerbit'] ?></td>
                        <td align="center"><?= $b['tahun_terbit'] ?></td>
                        <td align="center"><?= $b['jumlah'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" align="center">Tidak ada data buku ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak secara otomatis oleh sistem PinbookApp.</p>
    </div>

</body>

</html>