<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
body {
    background: #f4f7fb;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #0f766e;
}

.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

.search-box {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.search-box input,
.search-box select {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    outline: none;
}

.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

.book-card {
    background: #fff;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: 0.2s;
    border: 1px solid #eee;
}

.book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.book-card img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.book-title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}

.btn-primary {
    background: #0f766e;
    color: white;
    padding: 12px 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    margin-top: 15px;
    width: 100%;
}

.btn-primary:hover {
    background: #115e59;
}

.stock-habis {
    color: red;
    font-size: 12px;
    font-weight: 600;
}
</style>

<div class="card-box">

    <div class="page-title">📚 Pinjam Buku</div>

    <!-- SEARCH -->
    <form method="get" action="<?= base_url('peminjaman/create') ?>" class="search-box">

        <input type="text" name="q" placeholder="Cari buku..."
               value="<?= $_GET['q'] ?? '' ?>">

        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori_list as $k): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= esc($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-primary" style="width:auto;padding:10px 15px;">
            Cari
        </button>

    </form>

    <!-- FORM PINJAM -->
    <form method="post" action="<?= base_url('peminjaman/pinjamMulti') ?>" onsubmit="return validasi()">
        <?= csrf_field() ?>

        <div class="book-grid">

            <?php foreach (($hasil_cari ?? []) as $b): ?>

                <div class="book-card">

                    <?php if (!empty($b['cover'])): ?>
                        <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>">
                    <?php endif; ?>

                    <div class="book-title">
                        <?= esc($b['judul']) ?>
                    </div>

                    <?php if ($b['tersedia'] > 0): ?>
                        <label class="checkbox">
                            <input type="checkbox" name="buku[]" value="<?= $b['id_buku'] ?>">
                            Pilih Buku
                        </label>
                    <?php else: ?>
                        <div class="stock-habis">Stok Habis</div>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

        <button type="submit" class="btn-primary">
            📖 Pinjam Buku Sekarang
        </button>

    </form>

</div>

<script>
function validasi() {
    let cek = document.querySelectorAll('input[name="buku[]"]:checked').length;
    if (cek === 0) {
        alert('Pilih minimal 1 buku');
        return false;
    }
    return true;
}
</script>

<?= $this->endSection() ?>