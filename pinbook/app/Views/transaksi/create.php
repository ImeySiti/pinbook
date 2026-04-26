<h2>Tambah Transaksi</h2>

<form method="post" action="<?= base_url('transaksi/store') ?>">

    ID Peminjaman <br>
    <input type="text" name="id_peminjaman"><br><br>

    Jenis <br>
    <select name="jenis">
        <option value="ongkir">Ongkir</option>
        <option value="denda">Denda</option>
    </select><br><br>

    Metode <br>
    <select name="metode">
        <option value="cash">Cash</option>
        <option value="qris">QRIS</option>
    </select><br><br>

    Jumlah <br>
    <input type="number" name="jumlah"><br><br>

    <button type="submit">Simpan</button>
</form>