<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root{
    --primary:#0f766e;
    --primary-soft:#14b8a6;
    --bg:#f4f7fb;
}

body{
    background:var(--bg);
}

/* CARD */
.table-card{
    border:0;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
}

/* BUTTON */
.btn-action{
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;
    margin-left:4px;
}

/* HEADER TABLE */
thead{
    background: var(--primary);
    color:#fff;
}

/* TITLE */
h4.fw-bold{
    color: var(--primary);
}

/* BADGE */
.badge{
    padding:6px 10px;
    border-radius:8px;
    font-size:11px;
    font-weight:600;
}

/* STATUS COLOR */
.bg-warning { background:#fbbf24 !important; color:#111 !important; }
.bg-primary { background:var(--primary-soft) !important; }
.bg-success { background:#10b981 !important; }
.bg-danger { background:#ef4444 !important; }
.bg-info { background:#38bdf8 !important; }
.bg-secondary { background:#6b7280 !important; }

/* hover */
table tbody tr:hover{
    background:#ecfdf5;
}

/* PRIMARY BUTTON */
.btn-primary{
    background: var(--primary) !important;
    border: none !important;
}

.btn-primary:hover{
    background: var(--primary-soft) !important;
}
</style>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0">Data Peminjaman</h4>
            <small class="text-muted">Daftar transaksi peminjaman buku</small>
        </div>

        <?php if(session()->get('role')=='anggota'): ?>
            <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary btn-action">
                + Pinjam
            </a>
        <?php endif; ?>
    </div>

    <?php
    $statusMap = [
        'menunggu'  => ['text'=>'Menunggu','class'=>'bg-warning'],
        'dipinjam'  => ['text'=>'Dipinjam','class'=>'bg-primary'],
        'kembali'   => ['text'=>'Selesai','class'=>'bg-success'],
        'terlambat' => ['text'=>'Terlambat','class'=>'bg-danger']
    ];
    ?>

    <div class="card table-card">
        <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Layanan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php if(!empty($peminjaman)): ?>
            <?php $no=1; foreach($peminjaman as $p): ?>

                <?php
                $status = strtolower($p['status'] ?? 'menunggu');
                $st = $statusMap[$status] ?? $statusMap['menunggu'];

                $metode = $p['metode_pengambilan'] ?? '';
                $status_pengiriman = $p['status_pengiriman'] ?? 'ambil';
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <!-- PEMINJAM -->
                    <td>
                        <div class="fw-semibold">
                            <?= esc($p['nama_anggota'] ?? '-') ?>
                        </div>
                        <small class="text-muted">#<?= $p['id_peminjaman'] ?></small>
                    </td>

                    <!-- TANGGAL -->
                    <td>
                        <small>Pinjam: <?= $p['tanggal_pinjam'] ?? '-' ?></small><br>
                        <small class="text-danger">Kembali: <?= $p['tanggal_kembali'] ?? '-' ?></small>
                    </td>

                    <!-- STATUS -->
                    <td>
                        <span class="badge <?= $st['class'] ?>">
                            <?= $st['text'] ?>
                        </span>
                    </td>

                    <!-- LAYANAN -->
                    <td>
                        <?php if(strtolower($metode) == 'antar'): ?>

                            <?php if($status_pengiriman == 'menunggu_konfirmasi'): ?>
                                <span class="badge bg-warning">Menunggu Konfirmasi</span>

                            <?php elseif($status_pengiriman == 'siap_diantar'): ?>
                                <span class="badge bg-info">Siap Diantar</span>

                            <?php elseif($status_pengiriman == 'selesai'): ?>
                                <span class="badge bg-success">Selesai</span>

                            <?php else: ?>
                                <span class="badge bg-secondary">Pengantaran</span>
                            <?php endif; ?>

                        <?php else: ?>
                            <span class="badge bg-secondary">Ambil di Tempat</span>
                        <?php endif; ?>
                    </td>

                    <!-- AKSI -->
                    <td class="text-end">

                        <a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>"
                           class="btn btn-light border btn-action">
                            Detail
                        </a>

                        <?php if(session()->get('role')=='petugas' && $status=='menunggu'): ?>
                            <a href="<?= base_url('peminjaman/konfirmasi/'.$p['id_peminjaman']) ?>"
                               class="btn btn-primary btn-action">
                                Konfirmasi
                            </a>
                        <?php endif; ?>

                        <?php if(in_array(session()->get('role'), ['petugas','admin'])
                            && in_array($status, ['dipinjam','terlambat'])): ?>

                            <a href="<?= base_url('peminjaman/kembalikan/'.$p['id_peminjaman']) ?>"
                               class="btn btn-success btn-action"
                               onclick="return confirm('Kembalikan buku ini?')">
                                Kembalikan
                            </a>

                        <?php endif; ?>

                        <?php if(session()->get('role')=='admin'): ?>
                            <a href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>"
                               class="btn btn-danger btn-action"
                               onclick="return confirm('Yakin hapus data ini?')">
                                Hapus
                            </a>
                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>
            <?php else: ?>

                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        Tidak ada data peminjaman
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>