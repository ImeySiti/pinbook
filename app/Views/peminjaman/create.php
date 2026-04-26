<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
            <i class="bi bi-book-half text-success fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bold mb-0">Pinjam Buku</h3>
            <p class="text-muted small mb-0">Pilih koleksi favoritmu (Maksimal 2 buku)</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <form method="get" action="<?= base_url('peminjaman/create') ?>" class="row g-2">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="q" class="form-control border-start-0 bg-light shadow-none" placeholder="Cari judul buku..." value="<?= esc($_GET['q'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-select bg-light border-0 shadow-none">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($kategori_list as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>" <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100 rounded-3">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $isSearching = !empty($_GET['q']) || !empty($_GET['kategori']);
            $dataTampil = $isSearching ? ($hasil_cari ?? []) : $rekomendasi;
            ?>

            <h5 class="fw-bold mb-3 text-dark"><?= $isSearching ? '🔍 Hasil Pencarian' : '🌟 Rekomendasi Untukmu' ?></h5>

            <div class="row row-cols-2 row-cols-md-3 g-3">
                <?php foreach ($dataTampil as $b): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden book-card">
                        <div class="position-relative">
                            <?php if (!empty($b['cover'])): ?>
                                <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="position-absolute top-0 end-0 p-2">
                                <?php if ($b['tersedia'] > 0): ?>
                                    <input type="checkbox" class="form-check-input bukuCheck shadow-none" 
                                           name="buku[]" value="<?= $b['id_buku'] ?>" 
                                           data-judul="<?= esc($b['judul']) ?>" onchange="updateKeranjang()">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body p-3 text-center">
                            <h6 class="fw-bold small mb-2 text-truncate-2" title="<?= esc($b['judul']) ?>"><?= esc($b['judul']) ?></h6>
                            <?php if ($b['tersedia'] > 0): ?>
                                <span class="badge bg-success-subtle text-success extra-small rounded-pill px-3">Tersedia: <?= $b['tersedia'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger extra-small rounded-pill px-3">Stok Habis</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow rounded-4 sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="bi bi-cart3 text-success me-2"></i>Konfirmasi Pinjaman</h5>
                    
                    <form method="post" action="<?= base_url('peminjaman/pinjamMulti') ?>" onsubmit="return validasiForm()">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Buku Terpilih (<span id="jumlah">0</span>/2)</label>
                            <div id="keranjangEmpty" class="text-center py-4 border rounded-4 border-dashed">
                                <i class="bi bi-book text-muted d-block fs-3 mb-2"></i>
                                <span class="text-muted small">Belum ada buku dipilih</span>
                            </div>
                            <ul id="keranjang" class="list-group list-group-flush small fw-medium"></ul>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Metode Pengambilan</label>
                            <select name="metode_pengambilan" id="metode" class="form-select bg-light border-0 shadow-none py-2" onchange="toggleAlamat()" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="ambil">Ambil di Perpustakaan</option>
                                <option value="antar">Antar ke Rumah</option>
                            </select>
                        </div>

                        <div id="alamatBox" class="mb-4" style="display:none;">
                            <label class="form-label small fw-bold text-muted text-uppercase">Alamat Pengantaran</label>
                            <textarea name="alamat" class="form-control bg-light border-0 shadow-none small" rows="3" placeholder="Masukkan alamat lengkap..."><?= esc($anggota['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnSubmit" class="btn btn-success py-3 rounded-pill fw-bold shadow-sm" disabled>
                                Lanjutkan Pinjaman <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-danger-subtle { background-color: #ffebee !important; }
    .extra-small { font-size: 10px; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 32px; }
    .border-dashed { border-style: dashed !important; }
    .book-card { transition: transform 0.2s; cursor: pointer; }
    .book-card:hover { transform: translateY(-5px); }
    .bukuCheck { width: 22px; height: 22px; border: 2px solid #198754; cursor: pointer; }
    .bukuCheck:checked { background-color: #198754; }
</style>

<script>
function updateKeranjang() {
    let checked = document.querySelectorAll('.bukuCheck:checked');
    let emptyState = document.getElementById('keranjangEmpty');
    let btnSubmit = document.getElementById('btnSubmit');

    if (checked.length > 2) {
        alert('Maksimal peminjaman adalah 2 buku!');
        event.target.checked = false;
        return;
    }

    document.getElementById('jumlah').innerText = checked.length;
    let keranjang = document.getElementById('keranjang');
    keranjang.innerHTML = '';

    if (checked.length > 0) {
        emptyState.classList.add('d-none');
        btnSubmit.disabled = false;
        checked.forEach(el => {
            let judul = el.getAttribute('data-judul');
            let li = document.createElement('li');
            li.className = "list-group-item d-flex align-items-center px-0 bg-transparent";
            li.innerHTML = `<i class="bi bi-check-circle-fill text-success me-2"></i> ${judul}`;
            keranjang.appendChild(li);
        });
    } else {
        emptyState.classList.remove('d-none');
        btnSubmit.disabled = true;
    }
}

function toggleAlamat() {
    let metode = document.getElementById('metode').value;
    let box = document.getElementById('alamatBox');
    box.style.display = (metode === 'antar') ? 'block' : 'none';
}

function validasiForm() {
    let buku = document.querySelectorAll('.bukuCheck:checked').length;
    let metode = document.getElementById('metode').value;

    if (buku === 0) {
        alert('Pilih minimal 1 buku');
        return false;
    }
    if (!metode) {
        alert('Pilih metode pengambilan');
        return false;
    }
    return true;
}

// Inisialisasi awal
toggleAlamat();
</script>

<?= $this->endSection() ?>