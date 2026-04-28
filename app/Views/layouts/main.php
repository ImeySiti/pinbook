<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>pinbookApp | Dashboard</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ts-dark-green: #0b4d3e;
            --ts-bg-light: #f4f7f4;
            --ts-card-radius: 20px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--ts-bg-light);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #fff;
            border-right: 1px solid #e0e0e0;
        }

        /* Content */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .hero-header {
            background: var(--ts-dark-green);
            color: #fff;
            padding: 40px 30px 80px;
            border-radius: 0 0 40px 40px;
        }

        .card-custom {
            border: none;
            border-radius: var(--ts-card-radius);
            margin-top: -50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
            background: #fff;
            transition: .2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <?= $this->include('layouts/menu') ?>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">

        <div class="container-fluid px-4">

            <?= $this->renderSection('content') ?>

        </div>

    </main>

    <!-- JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>