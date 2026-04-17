<h2>Edit Peminjaman</h2>

<form action="/peminjaman/update/<?= $peminjaman['id_peminjaman'] ?>" method="post">

    <label>Anggota</label>
    <select name="id_anggota">
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id_anggota'] ?>"
                <?= $a['id_anggota'] == $peminjaman['id_anggota'] ? 'selected' : '' ?>>
                <?= $a['nis'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Petugas</label>
    <select name="id_petugas">
        <?php foreach ($petugas as $p): ?>
            <option value="<?= $p['id_petugas'] ?>"
                <?= $p['id_petugas'] == $peminjaman['id_petugas'] ? 'selected' : '' ?>>
                <?= $p['jabatan'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" value="<?= $peminjaman['tanggal_pinjam'] ?>"><br>

    <label>Tanggal Kembali</label>
    <input type="date" name="tanggal_kembali" value="<?= $peminjaman['tanggal_kembali'] ?>"><br>

    <label>Status</label>
    <select name="status">
        <option value="dipinjam" <?= $peminjaman['status']=='dipinjam'?'selected':'' ?>>Dipinjam</option>
        <option value="dikembalikan" <?= $peminjaman['status']=='dikembalikan'?'selected':'' ?>>Dikembalikan</option>
        <option value="telat" <?= $peminjaman['status']=='telat'?'selected':'' ?>>Telat</option>
    </select>

    <br>
    <button type="submit">Update</button>
</form>