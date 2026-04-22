<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h3>Lengkapi Data Diri</h3>

<form method="post" action="<?= base_url('anggota/simpanData') ?>">

    <table cellpadding="8">

        <tr>
            <td><label>NIS</label></td>
            <td>
                <input type="text" name="nis" required style="width:250px;">
            </td>
        </tr>

        <tr>
            <td><label>Alamat</label></td>
            <td>
                <textarea name="alamat" required style="width:250px; height:80px;"></textarea>
            </td>
        </tr>

        <tr>
            <td><label>No HP</label></td>
            <td>
                <input type="text" name="no_hp" required style="width:250px;">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit">Simpan</button>
            </td>
        </tr>

    </table>

</form>
<?= $this->endSection() ?>