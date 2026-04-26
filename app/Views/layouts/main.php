<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pinbookApp | Dashboard</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ts-dark-green: #0b4d3e; /* Warna hijau gelap khas TalentaSync */
            --ts-bg-light: #f4f7f4;    /* Warna background krem/abu sangat muda */
            --ts-card-radius: 20px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--ts-bg-light);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 240px; /* Diperlebar agar lebih proporsional */
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            transition: all 0.3s;
            z-index: 1000;
        }

        /* Konten Utama */
        .content {
            flex-grow: 1;
            overflow-y: auto;
            position: relative;
        }

        /* Bagian Atas Hijau (Hero Header) */
        .hero-header {
            background-color: var(--ts-dark-green);
            color: white;
            padding: 40px 30px 80px 30px; /* Padding bawah lebih besar untuk efek overlap */
            border-radius: 0 0 40px 40px;
        }

        /* Card Custom agar mirip gambar */
        .card-custom {
            border: none;
            border-radius: var(--ts-card-radius);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-top: -50px; /* Menarik konten ke atas agar overlap dengan hijau */
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
            background: #fff;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Utility tambahan */
        .text-green-ts { color: var(--ts-dark-green); }
        .bg-green-ts { background-color: var(--ts-dark-green); }
    </style>
</head>

<body>
    <aside id="sidebar" class="sidebar">
        <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
    </aside>

   
        <div class="container-fluid px-4">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>