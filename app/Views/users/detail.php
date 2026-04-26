<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">🪪 Profil Pengguna</h4>
                <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="bg-primary" style="height: 100px; background: linear-gradient(45deg, #0d6efd, #0dcaf0);"></div>
                
                <div class="card-body pt-0 px-4 pb-4">
                    <div class="text-center" style="margin-top: -50px;">
                        <?php if ($user['foto']): ?>
                            <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                 class="rounded-circle border border-4 border-white shadow-sm" 
                                 style="width: 110px; height: 110px; object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle border border-4 border-white shadow-sm bg-light d-inline-flex align-items-center justify-content-center" 
                                 style="width: 110px; height: 110px;">
                                <i class="bi bi-person-fill text-secondary fs-1"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h4 class="fw-bold mt-3 mb-0"><?= esc($user['nama']) ?></h4>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mt-2">
                            <i class="bi bi-shield-check me-1"></i> <?= ucfirst($user['role']) ?>
                        </span>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="row g-3">
                        <div class="col-12 d-flex align-items-center">
                            <div class="bg-light p-2 rounded-3 me-3">
                                <i class="bi bi-envelope text-muted"></i>
                            </div>
                            <div>
                                <label class="extra-small text-muted d-block fw-bold text-uppercase">Alamat Email</label>
                                <span class="text-dark"><?= esc($user['email']) ?></span>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center">
                            <div class="bg-light p-2 rounded-3 me-3">
                                <i class="bi bi-person-badge text-muted"></i>
                            </div>
                            <div>
                                <label class="extra-small text-muted d-block fw-bold text-uppercase">Username Sistem</label>
                                <span class="text-dark">@<?= esc($user['username']) ?></span>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center">
                            <div class="bg-light p-2 rounded-3 me-3">
                                <i class="bi bi-key text-muted"></i>
                            </div>
                            <div>
                                <label class="extra-small text-muted d-block fw-bold text-uppercase">Kata Sandi</label>
                                <span class="text-muted">•••••••• (Tersandi)</span>
                            </div>
                        </div>
                    </div>

                    <?php if (session()->get('role') == 'admin') : ?>
                        <div class="d-grid mt-4">
                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning text-white fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i> Edit Informasi Profil
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="extra-small text-muted">
                    <i class="bi bi-lock-fill"></i> Data ini bersifat rahasia dan hanya dapat diakses oleh administrator.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .extra-small { font-size: 10px; letter-spacing: 0.5px; }
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-5px); }
</style>

<?= $this->endSection() ?>