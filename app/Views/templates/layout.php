<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Buku Tamu'; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

    <style>
        /* CSS untuk memastikan footer selalu di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
        }
    </style>
</head>

<body style="background: url('<?= base_url('assets/img/KBB2.png') ?>') no-repeat center center; background-size: cover; padding-top: 70px;">

    <?php
    // Sisipkan bagian header (misalnya navbar, dll.)
    echo $this->include('templates/header');
    ?>

    <!-- Wrapper untuk konten utama yang akan mengisi ruang kosong -->
    <main class="container mt-4">
        <?= $this->renderSection('content'); ?>
    </main>

    <?php
    // Sisipkan bagian footer (misalnya script JS, penutup body)
    echo $this->include('templates/footer');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

    <?= $this->section('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <?= $this->endSection(); ?>

    <?= $this->renderSection('scripts'); ?>

</body>

</html>