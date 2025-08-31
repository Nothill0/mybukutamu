<?php // app/Views/tamu/detail.php 
?>

<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Detail Tamu</h1>

<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Informasi Lengkap Tamu</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <?php if ($tamu['jalur_foto']) : ?>
                    <img src="<?= base_url($tamu['jalur_foto']); ?>" alt="Foto Tamu" class="img-fluid rounded shadow-sm mb-3">
                <?php else : ?>
                    <img src="<?= base_url('assets/img/default_avatar.png'); ?>" alt="Default Avatar" class="img-fluid rounded shadow-sm mb-3">
                <?php endif; ?>
                <h4 class="mt-2"><?= esc($tamu['nama']); ?></h4>
                <p class="text-muted"><?= esc($tamu['instansi'] ?: $tamu['alamat']); ?></p>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th width="150px">Nomor Telepon</th>
                        <td>: <?= esc($tamu['nomor_telepon']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: <?= esc($tamu['email'] ?: '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: <?= esc($tamu['alamat']); ?></td>
                    </tr>
                    <tr>
                        <th>Instansi</th>
                        <td>: <?= esc($tamu['instansi'] ?: '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Tujuan Kunjungan</th>
                        <td>: <?= esc($tamu['tujuan_kunjungan']); ?></td>
                    </tr>
                    <tr>
                        <th>Maksud Bertemu</th>
                        <td>: <?= esc($tamu['maksud_bertemu']); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:
                            <?php
                            $status_class = '';
                            switch ($tamu['status']) {
                                case 'menunggu':
                                    $status_class = 'badge bg-warning text-dark';
                                    break;
                                case 'disetujui':
                                    $status_class = 'badge bg-success';
                                    break;
                                case 'ditolak':
                                    $status_class = 'badge bg-danger';
                                    break;
                            }
                            ?>
                            <span class="<?= $status_class; ?>"><?= ucfirst($tamu['status']); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>: <?= date('d F Y H:i', strtotime($tamu['dibuat_pada'])); ?></td>
                    </tr>
                    <?php if ($tamu['status'] != 'menunggu') : ?>
                        <tr>
                            <th>Diperbarui Pada</th>
                            <td>: <?= date('d F Y H:i', strtotime($tamu['diperbarui_pada'])); ?></td>
                        </tr>
                        <?php if (isset($admin_setuju_nama) && $tamu['disetujui_oleh']) : ?>
                            <tr>
                                <th>Disetujui Oleh</th>
                                <td>: <?= esc($admin_setuju_nama); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (isset($admin_tolak_nama) && $tamu['ditolak_oleh']) : ?>
                            <tr>
                                <th>Ditolak Oleh</th>
                                <td>: <?= esc($admin_tolak_nama); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </table>

                <div class="mt-4">
                    <a href="<?= base_url('tamu/delete/' . $tamu['id']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus"><i class="fas fa-trash-alt"></i> Hapus</a>
                    <!-- <?php if ($tamu['status'] == 'menunggu') : ?>
                        <form action="<?= base_url('tamu/setujui/' . $tamu['id']); ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui tamu ini?')"><i class="fas fa-check"></i> Setujui</button>
                        </form>
                        <form action="<?= base_url('tamu/tolak/' . $tamu['id']); ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Tolak tamu ini?')"><i class="fas fa-times"></i> Tolak</button>
                        </form>
                    <?php endif; ?> -->
                    <?php
                    // Logika untuk tombol kembali yang dinamis
                    $referer = service('request')->getServer('HTTP_REFERER');
                    $backUrl = base_url('tamu/persetujuan'); // Default
                    if ($referer && (strpos($referer, 'home') !== false || strpos($referer, 'persetujuan') !== false || strpos($referer, 'laporan') !== false || strpos($referer, 'tamu/edit') !== false)) { // Tambahkan tamu/edit
                        $backUrl = $referer;
                    }
                    ?>
                    <a href="<?= $backUrl; ?>" class="btn btn-info text-white float-end">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>