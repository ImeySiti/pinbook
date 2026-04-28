<style>
    .sidebar-brand {
        padding: 1.5rem 1rem;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--ts-dark-green);
    }

    .user-profile-sidebar {
        padding: 0.5rem 1.2rem 1.5rem 1.2rem;
        border-bottom: 1px solid #eee;
        margin-bottom: 1rem;
        background: #fff;
    }

    .nav-menu {
        padding: 0 0.8rem;
    }

    .nav-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #999;
        margin: 1.5rem 0 0.5rem 0.5rem;
        font-weight: 700;
    }

    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 0.8rem 1rem;
        color: #555;
        text-decoration: none;
        border-radius: 12px;
        margin-bottom: 4px;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .nav-link-custom i {
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .nav-link-custom:hover {
        background-color: #f0f7f5;
        color: var(--ts-dark-green);
    }

    .nav-link-custom.active {
        background-color: var(--ts-dark-green);
        color: white;
    }
</style>
<?php $uri = uri_string(); ?>
<?php $session = session(); ?>
<?php $role = $session->get('role'); ?>

<!-- BRAND -->
<a href="<?= base_url('dashboard') ?>" class="sidebar-brand">
    <div class="bg-green-ts text-white p-2 rounded-3 me-2 d-inline-block">
        <i class="bi bi-book-half"></i>
    </div>
    <span class="fw-bold fs-5">pinbook<span class="text-green-ts">App</span></span>
</a>

<!-- PROFILE -->
<div class="user-profile-sidebar">
    <div class="d-flex align-items-center">

        <img src="<?= base_url('uploads/users/' . ($session->get('foto') ?: 'default.png')) ?>"
             class="rounded-circle border me-2"
             width="40"
             height="40"
             style="object-fit: cover;">

        <div class="overflow-hidden">
            <p class="mb-0 fw-bold small text-truncate">
                <?= $session->get('nama'); ?>
            </p>
            <p class="mb-0 text-muted" style="font-size: 10px; text-transform: uppercase;">
                <?= $role ?: 'guest'; ?>
                <?= $session->get('id_anggota') ? ' - ' . $session->get('id_anggota') : '' ?>
            </p>
        </div>

    </div>
</div>

<div class="nav-menu">

    <!-- DASHBOARD -->
    <a href="<?= base_url('dashboard') ?>"
       class="nav-link-custom <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>

    <!-- ADMIN -->
    <?php if ($role == 'admin'): ?>
        <div class="nav-label">Master Data</div>

        <a href="<?= base_url('buku') ?>" class="nav-link-custom">
            <i class="bi bi-journal-bookmark"></i> Buku
        </a>

        <a href="<?= base_url('kategori') ?>" class="nav-link-custom">
            <i class="bi bi-tags"></i> Kategori
        </a>

        <a href="<?= base_url('penulis') ?>" class="nav-link-custom">
            <i class="bi bi-person-badge"></i> Penulis
        </a>

        <a href="<?= base_url('penerbit') ?>" class="nav-link-custom">
            <i class="bi bi-building"></i> Penerbit
        </a>

        <a href="<?= base_url('rak') ?>" class="nav-link-custom">
            <i class="bi bi-layers"></i> Lokasi Rak
        </a>
    <?php endif; ?>

    <!-- TRANSAKSI -->
    <?php if (in_array($role, ['admin', 'petugas', 'anggota'])): ?>
        <div class="nav-label">Transaksi</div>

        <a href="<?= base_url('peminjaman') ?>" class="nav-link-custom">
            <i class="bi bi-arrow-right-circle"></i> Peminjaman
        </a>

        <a href="<?= base_url('pengembalian') ?>" class="nav-link-custom">
            <i class="bi bi-arrow-left-circle"></i> Pengembalian
        </a>
    <?php endif; ?>

    <!-- ANGGOTA -->
    <?php if ($role == 'anggota'): ?>
        <div class="nav-label">Personal</div>

        <a href="<?= base_url('buku') ?>" class="nav-link-custom">
            <i class="bi bi-search"></i> Cari Buku
        </a>

        <a href="<?= base_url('anggota/profil') ?>" class="nav-link-custom">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
    <?php endif; ?>

    <!-- USER MANAGEMENT -->
    <?php if (in_array($role, ['admin', 'petugas'])): ?>
        <div class="nav-label">Sistem</div>

        <a href="<?= base_url('users') ?>" class="nav-link-custom">
            <i class="bi bi-people"></i> Manage Users
        </a>
    <?php endif; ?>

    <!-- BACKUP -->
    <?php if ($role == 'admin'): ?>
        <a href="<?= base_url('backup') ?>" class="nav-link-custom">
            <i class="bi bi-database-down"></i> Backup Database
        </a>
    <?php endif; ?>

    <!-- SETTINGS -->
    <a href="<?= base_url('profile') ?>" class="nav-link-custom mt-2">
        <i class="bi bi-gear"></i> Settings
    </a>

    <!-- LOGOUT -->
    <a href="<?= base_url('logout') ?>" class="nav-link-custom text-danger">
        <i class="bi bi-box-arrow-right"></i> Log Out
    </a>

</div>