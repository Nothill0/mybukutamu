<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="fw-light my-2">Buku Tamu</h3>
                <h5 class="fw-light my-2">Admin</h5>
            </div>
            <div class="card-body">
                <?php
                // Menampilkan pesan error (flashdata) jika ada
                if (session()->getFlashdata('pesan')) :
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>