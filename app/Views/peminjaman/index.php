<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota'): ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Pinjam Buku</a>
<?php endif; ?>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Buku Dipinjam</th>
        <th>Tanggal Pinjam</th>
        <th>Jatuh Tempo</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($peminjaman)): ?>
        <?php $no = 1; foreach ($peminjaman as $p): ?>

        <?php
            $today = date('Y-m-d');
            $tgl_kembali = $p['tanggal_kembali'] ?? null;
            $status = $p['status'] ?? 'dipinjam';

            // auto status terlambat
            if ($status != 'kembali' && $tgl_kembali && $tgl_kembali < $today) {
                $status = 'terlambat';
            }
        ?>

        <tr>
            <td><?= $no++ ?></td>

            <!-- SEMUA DARI USERS (TIDAK PAKAI SESSION LAGI) -->
            <td><?= $p['nama_anggota'] ?? '-' ?></td>

            <!-- LIST BUKU -->
            <td>
                <?= !empty($p['daftar_buku']) ? $p['daftar_buku'] : '<i>Tidak ada buku</i>' ?>
            </td>

            <td><?= $p['tanggal_pinjam'] ?? '-' ?></td>
            <td><?= $p['tanggal_kembali'] ?? '-' ?></td>

            <!-- STATUS -->
            <td>
                <?php if ($status == 'kembali'): ?>
                    <span style="color: green;">Dikembalikan</span>

                <?php elseif ($status == 'diperpanjang'): ?>
                    <span style="color: blue;">Diperpanjang</span>

                <?php elseif ($status == 'terlambat'): ?>
                    <span style="color: red;">Terlambat</span>

                <?php else: ?>
                    <span style="color: orange;">Dipinjam</span>
                <?php endif; ?>
            </td>

            <!-- AKSI -->
            <td>
                <a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">
                    Detail
                </a> |

                <?php if (session()->get('role') != 'admin'): ?>

                    <a href="<?= base_url('peminjaman/perpanjang/'.$p['id_peminjaman']) ?>"
                       onclick="return confirm('Perpanjang 3 hari?')">
                        Perpanjang
                    </a> |

                    <?php if ($status != 'kembali'): ?>
                        <a href="<?= base_url('peminjaman/kembali/'.$p['id_peminjaman']) ?>">
                            Kembalikan
                        </a> |
                    <?php endif; ?>

                <?php endif; ?>

                <!-- 🔥 HANYA ADMIN -->
                <?php if (session()->get('role') == 'admin'): ?>
                    <a href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>" 
                       onclick="return confirm('Yakin mau hapus data ini?')">
                        Hapus
                    </a>
                <?php endif; ?>
            </td>

        </tr>

        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" align="center">Belum ada data</td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>