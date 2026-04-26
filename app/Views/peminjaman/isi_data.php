<a href="<?= base_url('anggota/isi_data') ?>">
    
<form method="post" action="<?= base_url('anggota/simpan_data') ?>">

    <label>NIS</label>
    <input type="text" name="nis" required>

    <label>Alamat</label>
    <textarea name="alamat" required></textarea>

    <label>No HP</label>
    <input type="text" name="no_hp" required>

    <button type="submit">Simpan</button>

</form>