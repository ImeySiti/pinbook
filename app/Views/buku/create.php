<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<div class="container py-4">

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-0 fw-bold">📚 Tambah Buku</h3>
            <p class="text-muted small">Tambahkan koleksi buku baru ke dalam sistem Pinbook</p>
        </div>
        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Informasi Utama</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Judul Buku</label>
                            <input type="text" name="judul" class="form-control form-control-lg bg-light border-0" placeholder="Masukkan judul lengkap" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">ISBN</label>
                            <input type="text" name="isbn" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: 978-602-...">
                        </div>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Klasifikasi & Penulis</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="id_kategori" class="form-select bg-light border-0 mb-2">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="kategori_baru" class="form-control form-control-sm border-dashed" placeholder="+ Tambah kategori baru jika tidak ada">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Penulis</label>
                            <select name="id_penulis" class="form-select bg-light border-0 mb-2">
                                <option value="">Pilih Penulis</option>
                                <?php foreach ($penulis as $p): ?>
                                    <option value="<?= $p['id_penulis'] ?>"><?= $p['nama_penulis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="penulis_baru" class="form-control form-control-sm border-dashed" placeholder="+ Tambah penulis baru jika tidak ada">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Penerbit</label>
                            <select name="id_penerbit" class="form-select bg-light border-0 mb-2">
                                <option value="">Pilih Penerbit</option>
                                <?php foreach ($penerbit as $p): ?>
                                    <option value="<?= $p['id_penerbit'] ?>"><?= $p['nama_penerbit'] ?> (<?= $p['alamat'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="penerbit_baru" class="form-control form-control-sm border-dashed" placeholder="Nama penerbit baru">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="alamat_penerbit_baru" class="form-control form-control-sm border-dashed" placeholder="Alamat penerbit baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Detail Fisik & Inventaris</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Lokasi Rak</label>
                            <select name="id_rak" class="form-select bg-light border-0">
                                <option value="">Pilih Rak</option>
                                <?php foreach ($rak as $r): ?>
                                    <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?> (<?= $r['lokasi'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control bg-light border-0" placeholder="YYYY">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Total Stok</label>
                            <input type="number" name="jumlah" class="form-control bg-light border-0" placeholder="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Tersedia</label>
                            <input type="number" name="tersedia" class="form-control bg-light border-0" placeholder="0">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" class="form-control bg-light border-0" placeholder="Sinopsis atau catatan buku..."></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Cover Buku</label>
                            <div class="p-3 border-dashed rounded-3 text-center bg-light">
                                <input type="file" name="cover" class="form-control border-0 bg-transparent">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Koleksi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    /* Tambahan sedikit CSS untuk mempercantik */
    .border-dashed {
        border: 1px dashed #dee2e6 !important;
    }
    .form-label {
        color: #555;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    hr {
        border-top: 2px solid #eee;
    }
</style>

<?= $this->endSection() ?>