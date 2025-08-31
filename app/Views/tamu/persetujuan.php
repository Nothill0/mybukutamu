<?php // app/Views/tamu/persetujuan.php 
?>

<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Persetujuan Tamu</h1>

<?php if (session()->getFlashdata('pesan_sukses')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('pesan_sukses') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- <div class="d-flex justify-content-end mb-3">
    <a href="<?= base_url('tamu/tambah'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Tamu Baru</a>
</div> -->

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Daftar Tamu Menunggu Persetujuan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari tamu..." name="keyword" value="<?= esc($keyword); ?>">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        <?php if ($keyword) : ?>
                            <a href="<?= base_url('tamu/persetujuan'); ?>" class="btn btn-outline-danger">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Foto</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Instansi</th>
                        <th>Bertemu</th>
                        <th>Tujuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tamu_menunggu)) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada tamu yang menunggu persetujuan.</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $currentPage = $pager->getCurrentPage('menunggu');
                        $perPage = $pager->getPerPage('menunggu');
                        $no = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($tamu_menunggu as $tamu) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-center">
                                    <?php if ($tamu['jalur_foto']) : ?>
                                        <img src="<?= base_url($tamu['jalur_foto']); ?>" alt="Foto Tamu" class="img-thumbnail" width="80">
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/img/default_avatar.png'); ?>" alt="Default Avatar" class="img-thumbnail" width="80">
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($tamu['nama']); ?></td>
                                <td><?= esc($tamu['nomor_telepon']); ?></td>
                                <td><?= esc($tamu['instansi'] ?: $tamu['alamat']); ?></td>
                                <td><?= esc($tamu['maksud_bertemu']); ?></td>
                                <td><?= esc($tamu['tujuan_kunjungan']); ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('tamu/detail/' . $tamu['id']); ?>" class="btn btn-sm btn-info text-white mb-1" title="Detail"><i class="fas fa-eye"></i></a>
                                    <!-- <a href="<?= base_url('tamu/edit/' . $tamu['id']); ?>" class="btn btn-sm btn-warning text-white mb-1" title="Edit"><i class="fas fa-edit"></i> Edit</a> -->
                                    <form action="<?= base_url('tamu/setujui/' . $tamu['id']); ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success mb-1" onclick="return confirm('Setujui tamu ini?')" title="Setujui"><i class="fas fa-check"></i></button>
                                    </form>
                                    <form action="<?= base_url('tamu/tolak/' . $tamu['id']); ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Tolak tamu ini?')" title="Tolak"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <?= $pager->links('menunggu', 'bootstrap_full'); ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>