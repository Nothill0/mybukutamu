<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<style>
    /* Gunakan CSS ini untuk styling halaman beranda */
    .hero-section {
        background: rgba(128, 128, 128, 0.7);
        /* Latar belakang abu-abu semi-transparan */
        color: #fff;
        padding: 6rem 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        min-height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-section h1,
    .hero-section .lead {
        color: #fff !important;
    }

    .hero-section a.btn {
        background-color: #f8f9fa;
        /* Warna tombol terang */
        color: #0d6efd;
        /* Warna teks tombol */
        border: none;
        transition: all 0.3s ease;
    }

    .hero-section a.btn:hover {
        background-color: #e2e6ea;
        transform: translateY(-2px);
    }
</style>

<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Selamat Datang di Sistem Buku Tamu</h1>
        <p class="lead mx-auto mb-4" style="max-width: 600px;">
            Sistem ini memudahkan pencatatan dan pengelolaan data tamu yang berkunjung ke instansi kami. Dengan sistem ini, proses registrasi tamu menjadi lebih cepat, efisien, dan terorganisir.
        </p>
        <a href="<?= base_url('tamu/tambah'); ?>" class="btn btn-primary btn-lg rounded-pill shadow-sm">
            Tambah Tamu Baru
        </a>
    </div>
</section>

<?= $this->endSection() ?>