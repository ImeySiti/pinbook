<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">📑 Transaksi Peminjaman</h3>
            <p class="text-muted small mb-0">Kelola sirkulasi buku, pengantaran, dan pengajuan anggota</p>
        </div>

        <?php if (session()->get('role') == 'anggota'): ?>
            <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Pinjam Buku
            </a>
        <?php endif; ?>
    </div>

    <?php
    $statusMap = [
        'menunggu'     => ['text' => 'Diproses', 'class' => 'bg-warning text-dark'],
        'dipinjam'     => ['text' => 'Dipinjam', 'class' => 'bg-primary'],
        'diperpanjang' => ['text' => 'Diperpanjang', 'class' => 'bg-info'],
        'kembali'      => ['text' => 'Selesai', 'class' => 'bg-success'],
        'dikembalikan' => ['text' => 'Selesai', 'class' => 'bg-success'],
        'terlambat'    => ['text' => 'Terlambat', 'class' => 'bg-danger']
    ];

    $pengantaranMap = [
        'menunggu_pembayaran' => ['text' => 'Menunggu Bayar', 'class' => 'bg-warning text-dark'],
        'menunggu_konfirmasi' => ['text' => 'Konfirmasi', 'class' => 'bg-secondary'],
        'siap_diantar'        => ['text' => 'Siap Diantar', 'class' => 'bg-info'],
        'dalam_pengantaran'   => ['text' => 'Diantar', 'class' => 'bg-success'],
        'sudah_bayar'         => ['text' => 'Sudah Bayar', 'class' => 'bg-primary'],
        'selesai'             => ['text' => 'Selesai', 'class' => 'bg-dark']
    ];
    ?>

    <!-- TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                <tr class="text-uppercase small">
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Layanan</th>
                    <th class="text-end">Aksi</th>
                </tr>
                </thead>

                <tbody>

                <?php if (!empty($peminjaman)): ?>
                    <?php $no = 1; foreach ($peminjaman as $p): ?>

                        <?php
                        $status = $p['status'] ?? 'dipinjam';
                        $st = $statusMap[$status] ?? $statusMap['menunggu'];
                        $sp = $p['status_pengantaran'] ?? '';
                        $metode = $p['metode_pengambilan'] ?? '';
                        ?>

                        <tr>

                            <td><?= $no++ ?></td>

                            <td>
                                <div class="fw-semibold"><?= esc($p['nama_anggota']) ?></div>
                                <div class="text-muted small">ID #<?= $p['id_peminjaman'] ?></div>
                            </td>


                            <td>
                                <div class="small">Pinjam: <?= $p['tanggal_pinjam'] ?></div>
                                <div class="small text-danger">Kembali: <?= $p['tanggal_kembali'] ?></div>
                            </td>

                            <td>
                                <span class="badge <?= $st['class'] ?>">
                                    <?= $st['text'] ?>
                                </span>
                            </td>

                            <td>
                                <?php if ($metode == 'antar'): ?>
                                    <span class="badge <?= $pengantaranMap[$sp]['class'] ?? 'bg-secondary' ?>">
                                        <?= $pengantaranMap[$sp]['text'] ?? 'Proses' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark border">Mandiri</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-end">

                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                     
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">
                                                Detail
                                            </a>
                                        </li>

                                        <?php if (session()->get('role') == 'admin'): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger"
                                                   onclick="return confirm('Hapus data?')"
                                                   href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>">
                                                    Hapus
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data peminjaman
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>