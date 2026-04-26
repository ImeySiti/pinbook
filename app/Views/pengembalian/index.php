<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Pengembalian</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Nama</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pengembalian)): ?>
            <?php $no = 1; foreach ($pengembalian as $p): ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                
                <td><?= esc($p['nama_anggota'] ?? '-') ?></td>

                <td align="center"><?= esc($p['tanggal_pinjam'] ?? '-') ?></td>

                <td align="center"><?= esc($p['jatuh_tempo'] ?? '-') ?></td>

                <td align="center">
                    <?= ($p['tanggal_dikembalikan'] != '-') ? date('Y-m-d', strtotime($p['tanggal_dikembalikan'])) : '-' ?>
                </td>

                <td>
                    Rp <?= number_format($p['denda'] ?? 0, 0, ',', '.') ?>
                </td>

                <td align="center">
                    <?php if (($p['status_bayar'] ?? 'belum') == 'lunas'): ?>
                        <span style="color:green; font-weight:bold;">Lunas</span>
                    <?php else: ?>
                        <span style="color:red; font-weight:bold;">Belum</span>
                    <?php endif; ?>
                </td>

                <td align="center">
                    <?php if (($p['status_bayar'] ?? 'belum') != 'lunas'): ?>
                        <a href="<?= base_url('pengembalian/bayar/'.$p['id_pengembalian']) ?>" class="btn-bayar">
                            Bayar
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" align="center">Tidak ada data pengembalian yang valid.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>