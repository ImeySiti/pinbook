<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-0 fw-bold">📝 Edit Data Buku</h3>
            <p class="text-muted small">Perbarui informasi koleksi buku: <span class="text-primary fw-bold"><?= $buku['judul'] ?></span></p>
        </div>
        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Informasi Utama</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Judul Buku</label>
                            <input type="text" name="judul" class="form-control bg-light border-0" value="<?= $buku['judul'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">ISBN</label>
                            <input type="text" name="isbn" class="form-control bg-light border-0" value="<?= $buku['isbn'] ?>">
                        </div>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Klasifikasi & Penulis</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="id_kategori" class="form-select bg-light border-0 mb-2" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>" <?= ($buku['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>>
                                        <?= $k['nama_kategori'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="kategori_baru" class="form-control form-control-sm border-dashed" placeholder="+ Ganti ke kategori baru">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Penulis</label>
                            <select name="id_penulis" class="form-select bg-light border-0 mb-2">
                                <option value="">Pilih Penulis</option>
                                <?php foreach ($penulis as $p): ?>
                                    <option value="<?= $p['id_penulis'] ?>" <?= ($buku['id_penulis'] == $p['id_penulis']) ? 'selected' : '' ?>>
                                        <?= $p['nama_penulis'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="penulis_baru" class="form-control form-control-sm border-dashed" placeholder="+ Ganti ke penulis baru">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Penerbit</label>
                            <select name="id_penerbit" class="form-select bg-light border-0 mb-2">
                                <option value="">Pilih Penerbit</option>
                                <?php foreach ($penerbit as $p): ?>
                                    <option value="<?= $p['id_penerbit'] ?>" <?= ($buku['id_penerbit'] == $p['id_penerbit']) ? 'selected' : '' ?>>
                                        <?= $p['nama_penerbit'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="penerbit_baru" class="form-control form-control-sm border-dashed" placeholder="+ Ganti ke penerbit baru">
                        </div>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Detail Fisik & Stok</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Rak Penyimpanan</label>
                            <select name="id_rak" class="form-select bg-light border-0">
                                <option value="">-- Pilih Rak --</option>
                                <?php foreach ($rak as $r): ?>
                                    <option value="<?= $r['id_rak'] ?>" <?= ($buku['id_rak'] == $r['id_rak']) ? 'selected' : '' ?>>
                                        <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold small">Tahun</label>
                            <input type="number" name="tahun_terbit" class="form-control bg-light border-0" value="<?= $buku['tahun_terbit'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Total Stok</label>
                            <input type="number" name="jumlah" class="form-control bg-light border-0" value="<?= $buku['jumlah'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Tersedia</label>
                            <input type="number" name="tersedia" class="form-control bg-light border-0" value="<?= $buku['tersedia'] ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control bg-light border-0"><?= $buku['deskripsi'] ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Cover Buku</h6>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <?php if ($buku['cover']): ?>
                                <div class="position-relative">
                                    <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" class="rounded-3 shadow-sm border" width="100" height="130" style="object-fit: cover;">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">Lama</span>
                                </div>
                            <?php else: ?>
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" width="100" height="130">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <input type="hidden" name="old_cover" value="<?= $buku['cover'] ?>">
                            <input type="file" name="cover" class="form-control border-dashed">
                            <small class="text-muted mt-1 d-block italic">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('buku') ?>" class="btn btn-light btn-lg rounded-pill px-4">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .border-dashed { border: 1px dashed #dee2e6 !important; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
</style>

<?= $this->endSection() ?>