    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center">
                <img src="<?= base_url('assets/img/kbb.png') ?>" alt="Logo Kesbangpol" class="me-2" style="height: 30px;">
                BUKU TAMU
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('logged_in')) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home'); ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('tamu/persetujuan'); ?>">Persetujuan Tamu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('laporan'); ?>">Laporan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-danger text-white ms-2" href="<?= base_url('logout'); ?>">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/'); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('tamu/tambah'); ?>">Daftar Tamu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login'); ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>