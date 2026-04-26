<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">📝 Edit Transaksi Peminjaman</h3>
            <p class="text-muted small">ID Peminjaman: <span class="fw-bold text-primary">#<?= $peminjaman['id_peminjaman'] ?></span></p>
        </div>
        <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="post" action="<?= base_url('peminjaman/update/'.$peminjaman['id_peminjaman']) ?>">
        <?= csrf_field() ?>
        
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-uppercase mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">Informasi Peminjam</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Anggota</label>
                            <select name="id_anggota" class="form-select bg-light border-0">
                                <?php if (!empty($anggota)): ?>
                                    <?php foreach ($anggota as $a): ?>
                                        <option value="<?= $a['id_anggota'] ?>"
                                            <?= (isset($peminjaman['id_anggota']) && $peminjaman['id_anggota'] == $a['id_anggota']) ? 'selected' : '' ?>>
                                            <?= $a['nama_anggota'] ?> (<?= $a['nis'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Petugas Bertanggung Jawab</label>
                            <select name="id_petugas" class="form-select bg-light border-0">
                                <?php if (!empty($petugas)): ?>
                                    <?php foreach ($petugas as $pt): ?>
                                        <option value="<?= $pt['id_petugas'] ?>"
                                            <?= (isset($peminjaman['id_petugas']) && $peminjaman['id_petugas'] == $pt['id_petugas']) ? 'selected' : '' ?>>
                                            <?= $pt['jabatan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Kembali (Jatuh Tempo)</label>
                                <input type="date" name="tanggal_kembali" class="form-control bg-light border-0"
                                       value="<?= $peminjaman['tanggal_kembali'] ?? '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Status Peminjaman</label>
                                <select name="status" class="form-select bg-light border-0 fw-bold <?= $peminjaman['status'] == 'kembali' ? 'text-success' : 'text-primary' ?>">
                                    <option value="pinjam" <?= ($peminjaman['status']=='pinjam') ? 'selected' : '' ?>>🟠 Sedang Dipinjam</option>
                                    <option value="kembali" <?= ($peminjaman['status']=='kembali') ? 'selected' : '' ?>>🟢 Sudah Kembali</option>
                                    <option value="perpanjang" <?= ($peminjaman['status']=='perpanjang') ? 'selected' : '' ?>>🔵 Diperpanjang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px;">Edit Buku Pinjaman</h6>
                        
                        <div class="flex-grow-1 p-3 bg-light rounded-4 overflow-auto" style="max-height: 300px;">
                            <?php if (!empty($buku)): ?>
                                <?php foreach ($buku as $b): ?>
                                    <div class="form-check border-bottom py-2">
                                        <input class="form-check-input" type="checkbox" name="id_buku[]" 
                                               value="<?= $b['id_buku'] ?>" id="book_<?= $b['id_buku'] ?>"
                                               <?= in_array($b['id_buku'], $buku_terpilih ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label small ms-2" for="book_<?= $b['id_buku'] ?>">
                                            <span class="fw-bold d-block text-dark"><?= $b['judul'] ?></span>
                                            <span class="text-muted" style="font-size: 11px;">Stok: <?= $b['tersedia'] ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
                                <i class="bi bi-save me-2"></i> Update Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Custom scrollbar untuk box buku */
    .overflow-auto::-webkit-scrollbar {
        width: 6px;
    }
    .overflow-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .overflow-auto::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

<?= $this->endSection() ?>