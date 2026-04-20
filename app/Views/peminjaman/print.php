<h2>Nota Peminjaman</h2>

<p>ID: <?= $peminjaman['id_peminjaman'] ?></p>
<p>Anggota: <?= $peminjaman['nama_anggota'] ?></p>
<p>Status: <?= $peminjaman['status'] ?></p>

<hr>

<table border="1" cellpadding="5">
    <tr>
        <th>Buku</th>
        <th>Jumlah</th>
    </tr>

    <?php foreach ($detail as $d): ?>
    <tr>
        <td><?= $d['judul'] ?></td>
        <td><?= $d['jumlah'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
window.print();
</script>