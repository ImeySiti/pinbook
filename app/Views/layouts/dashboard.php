<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
    .bg-green-dark { background-color: #004d40; color: white; }
    .card-stat { border: none; border-radius: 15px; background: #fff; transition: transform 0.2s; }
    .card-stat:hover { transform: translateY(-5px); }
    .card-main { border: none; border-radius: 20px; background: #fff; min-height: 400px; }
    .badge-trend { font-size: 0.75rem; border-radius: 20px; padding: 4px 8px; display: inline-flex; align-items: center; }
    .text-muted-small { font-size: 0.85rem; color: #6c757d; }
    .extra-small { font-size: 10px; }
    .w-fit { width: fit-content; }
</style>

<div class="bg-green-dark p-4 pb-5 mb-n5" style="border-radius: 0 0 30px 30px;">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">pinbook<span style="color: #4db6ac;">App</span></h4>
            <div class="d-flex align-items-center">
                <i class="bi bi-gear me-3 cursor-pointer"></i>
                <i class="bi bi-bell me-3 cursor-pointer"></i>
                
                <div class="d-flex align-items-center bg-white bg-opacity-10 p-1 pe-3 rounded-pill">
                    <img src="<?= base_url('uploads/users/' . (session()->get('foto') ?: 'default.png')) ?>" 
                         class="rounded-circle border border-2 border-light-subtle" 
                         width="35" height="35" style="object-fit: cover;">
                    <div class="ms-2 d-none d-sm-block">
                        <p class="mb-0 small fw-bold leading-tight"><?= session('nama') ?: 'User'; ?></p>
                        <p class="mb-0 extra-small opacity-75 text-uppercase"><?= session('role'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-end">
            <div>
                <p class="text-white-50 mb-1">Selamat Datang kembali,</p>
                <h2 class="fw-bold mb-0"><?= explode(' ', trim(session('nama')))[0]; ?>! 👋</h2>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-calendar3 me-2"></i><?= date('Y'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4 mt-4">
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-lg-2">
            <div class="card card-stat p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="p-2 bg-success-subtle rounded text-success"><i class="bi bi-book"></i></div>
                    <i class="bi bi-arrow-up-right text-muted small"></i>
                </div>
                <h3 class="fw-bold mt-2 mb-0">310</h3>
                <span class="badge-trend bg-success-subtle text-success w-fit mt-1">
                    <i class="bi bi-plus"></i>3.72%
                </span>
                <p class="text-muted-small mb-0 mt-1">Total Buku</p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="card card-stat p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="p-2 bg-info-subtle rounded text-info"><i class="bi bi-people"></i></div>
                    <i class="bi bi-arrow-up-right text-muted small"></i>
                </div>
                <h3 class="fw-bold mt-2 mb-0">1,244</h3>
                <span class="badge-trend bg-success-subtle text-success w-fit mt-1">
                    <i class="bi bi-plus"></i>5.02%
                </span>
                <p class="text-muted-small mb-0 mt-1">Total Anggota</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-main p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0">Peminjaman Aktif</h6>
                        <small class="text-muted">Status Buku Saat Ini</small>
                    </div>
                    <span class="h4 fw-bold text-success mb-0">24</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0 px-0 d-flex align-items-center">
                        <div class="p-2 bg-light rounded me-3"><i class="bi bi-bookmark-check text-primary"></i></div>
                        <div class="overflow-hidden">
                            <p class="mb-0 fw-bold small text-truncate">Laskar Pelangi</p>
                            <p class="extra-small text-muted mb-0">Andrea Hirata</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-main p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Jatuh Tempo <br><span class="h4">12</span> Buku</h6>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light rounded-circle me-1"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                
                <div class="d-flex align-items-center p-2 mb-2 bg-light rounded-3 border-start border-4 border-warning">
                    <div class="flex-grow-1 ms-2">
                        <p class="mb-0 fw-bold small">Ahmad Subarjo</p>
                        <p class="extra-small text-muted mb-0">Filosofi Teras</p>
                    </div>
                    <span class="badge bg-white text-dark border small fw-normal">Besok, 10:00 AM</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-main p-3 shadow-sm">
                <h6 class="fw-bold mb-3">Status Anggota</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Terdaftar</span>
                    <span class="fw-bold">10</span>
                </div>
                <div class="progress mb-4" style="height: 10px; border-radius: 10px;">
                    <div class="progress-bar bg-success" style="width: 70%"></div>
                    <div class="progress-bar bg-info" style="width: 20%"></div>
                    <div class="progress-bar bg-warning" style="width: 10%"></div>
                </div>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item border-0 px-0 d-flex justify-content-between">
                        <span><i class="bi bi-circle-fill text-success me-2 extra-small"></i> Aktif</span>
                        <span class="fw-bold">2,450</span>
                    </li>
                    <li class="list-group-item border-0 px-0 d-flex justify-content-between">
                        <span><i class="bi bi-circle-fill text-info me-2 extra-small"></i> Masa Tenggang</span>
                        <span class="fw-bold">500</span>
                    </li>
                    <li class="list-group-item border-0 px-0 d-flex justify-content-between">
                        <span><i class="bi bi-circle-fill text-warning me-2 extra-small"></i> Non-Aktif</span>
                        <span class="fw-bold">159</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>