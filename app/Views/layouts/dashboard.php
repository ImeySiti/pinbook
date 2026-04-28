<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root{
    --primary:#0f766e;
    --primary-soft:#115e59;
}

body{
    font-family:'Segoe UI', sans-serif;
    background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600')
    center/cover no-repeat fixed;
}

body::before{
    content:"";
    position:fixed;
    inset:0;
    background:rgba(245,247,250,0.92);
    z-index:-1;
}

.bg-header{
    background: linear-gradient(135deg, var(--primary), var(--primary-soft));
    color:white;
    border-radius: 0 0 30px 30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

.card-stat{
    border:0;
    border-radius:16px;
    background:rgba(255,255,255,0.97);
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.2s;
}

.card-stat:hover{
    transform: translateY(-5px);
}

.card-stat h4{
    color: var(--primary);
    font-weight:700;
}
</style>

<?php $role = session()->get('role'); ?>

<!-- HEADER -->
<div class="bg-header p-4 pb-5 mb-n5">
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">📚 Pinbook Library</h4>

            <div class="d-flex align-items-center bg-white bg-opacity-25 p-2 rounded-pill">
                <img src="<?= base_url('uploads/users/' . (session()->get('foto') ?: 'default.png')) ?>"
                     width="35" height="35" class="rounded-circle me-2">

                <div>
                    <div class="small fw-bold"><?= session('nama') ?></div>
                    <div class="small text-uppercase"><?= $role ?></div>
                </div>
            </div>
        </div>

        <h2 class="fw-bold">Halo, <?= explode(' ', session('nama'))[0] ?> 👋</h2>
        <small class="text-white-50">Dashboard Real-Time Perpustakaan</small>

    </div>
</div>

<!-- CONTENT -->
<div class="container-fluid px-4 mt-4">

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card-stat p-3">
                📚 <h4 id="total_buku">0</h4>
                <small>Total Buku</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat p-3">
                👤 <h4 id="total_anggota">0</h4>
                <small>Total Anggota</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat p-3">
                📖 <h4 id="peminjaman">0</h4>
                <small>Peminjaman Aktif</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat p-3">
                ⏰ <h4 id="terlambat">0</h4>
                <small>Buku Terlambat</small>
            </div>
        </div>

    </div>

</div>

<!-- REALTIME JS -->
<script>
function loadDashboard(){

    fetch("<?= base_url('dashboard/stats') ?>")
    .then(res => res.json())
    .then(data => {

        document.getElementById('total_buku').innerText = data.buku;
        document.getElementById('total_anggota').innerText = data.anggota;
        document.getElementById('peminjaman').innerText = data.peminjaman;
        document.getElementById('terlambat').innerText = data.terlambat;

    })
    .catch(err => console.log(err));
}

// first load
loadDashboard();

// realtime update
setInterval(loadDashboard, 3000);
</script>

<?= $this->endSection() ?>