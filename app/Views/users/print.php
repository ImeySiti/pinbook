<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data User - Pinbook Library</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        /* Header Laporan */
        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #666;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            text-transform: uppercase;
            font-size: 11px;
            padding: 10px 5px;
        }

        td {
            padding: 8px 5px;
            border: 1px solid #ccc;
        }

        .text-center { text-align: center; }

        /* Tanda Tangan / Footer Laporan */
        .footer-report {
            margin-top: 30px;
            float: right;
            width: 200px;
            text-align: center;
        }

        .space-sign { height: 70px; }

        /* Pengaturan Cetak */
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>Laporan Daftar Pengguna</h2>
        <p>Sistem Informasi Perpustakaan Pinbook App</p>
        <p style="font-style: italic;">Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Lengkap</th>
                <th width="30%">Email</th>
                <th width="20%">Username</th>
                <th width="15%">Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php $no = 1; foreach ($users as $u): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($u['nama']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td class="text-center"><strong><?= ucfirst($u['role']) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengguna ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer-report">
        <p>Dicetak oleh,</p>
        <div class="space-sign"></div>
        <p><strong>( ________________ )</strong></p>
        <p>Petugas Perpustakaan</p>
    </div>

    <div class="no-print" style="margin-top: 50px; text-align: center;">
        <hr>
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Ulang</button>
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">Kembali</button>
    </div>

</body>
</html>