<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Peminjaman #<?= $peminjaman['id_peminjaman'] ?></title>
    <style>
        @page {
            size: 10cm 15cm; /* Ukuran struk sedang, bisa disesuaikan ke A4 jika perlu */
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace; /* Font gaya struk klasik */
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 20px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .header h2 { margin: 0; font-size: 18px; }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .info-table td { vertical-align: top; }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .detail-table th {
            border-bottom: 1px dashed #000;
            text-align: left;
            padding: 5px 0;
        }
        .detail-table td {
            padding: 5px 0;
            border-bottom: 0.5px solid #eee;
        }
        .footer {
            margin-top: 20px;
            border-top: 1px dashed #000;
            padding-top: 10px;
            font-size: 10px;
        }
        .status-badge {
            border: 1px solid #000;
            padding: 2px 5px;
            display: inline-block;
            text-transform: uppercase;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header text-center">
        <h2>PINBOOK LIBRARY</h2>
        <p>Sistem Informasi Perpustakaan Digital<br>Jl. Pendidikan No. 45, Kota Perpustakaan</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="35%">ID Transaksi</td>
            <td>: <strong>#<?= str_pad($peminjaman['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?></strong></td>
        </tr>
        <tr>
            <td>Peminjam</td>
            <td>: <?= esc($peminjaman['nama_anggota']) ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: <?= date('d/m/Y H:i') ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: <span class="status-badge"><?= esc($peminjaman['status']) ?></span></td>
        </tr>
    </table>

    <table class="detail-table">
        <thead>
            <tr>
                <th>Judul Koleksi</th>
                <th class="text-right">Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): ?>
            <tr>
                <td><?= esc($d['judul']) ?></td>
                <td class="text-right"><?= $d['jumlah'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer text-center">
        <p>Harap simpan nota ini sebagai bukti peminjaman.<br>Kembalikan buku tepat waktu untuk menghindari denda.</p>
        <p>*** Terima Kasih ***</p>
    </div>

    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Ulang</button>
        <a href="<?= base_url('peminjaman') ?>" style="margin-left: 10px;">Kembali</a>
    </div>

</body>
</html>