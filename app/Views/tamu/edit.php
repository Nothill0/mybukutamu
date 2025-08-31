<?php // app/Views/tamu/edit.php 
?>

<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Edit Data Tamu</h1>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Form Edit Data Tamu</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('tamu/update/' . $tamu['id']); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Tamu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $tamu['nama']); ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('nama')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('nama'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= (session('validation') && session('validation')->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon', $tamu['nomor_telepon']); ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('nomor_telepon')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('nomor_telepon'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?= (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email', $tamu['email']); ?>">
                <?php if (session('validation') && session('validation')->hasError('email')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('email'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (session('validation') && session('validation')->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="3" required><?= old('alamat', $tamu['alamat']); ?></textarea>
                <?php if (session('validation') && session('validation')->hasError('alamat')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('alamat'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi (Opsional)</label>
                <input type="text" class="form-control" id="instansi" name="instansi" value="<?= old('instansi', $tamu['instansi']); ?>">
            </div>

            <div class="mb-3">
                <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (session('validation') && session('validation')->hasError('tujuan_kunjungan')) ? 'is-invalid' : ''; ?>" id="tujuan_kunjungan" name="tujuan_kunjungan" rows="3" required><?= old('tujuan_kunjungan', $tamu['tujuan_kunjungan']); ?></textarea>
                <?php if (session('validation') && session('validation')->hasError('tujuan_kunjungan')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('tujuan_kunjungan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="maksud_bertemu" class="form-label">Maksud Bertemu / Bertemu Dengan <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (session('validation') && session('validation')->hasError('maksud_bertemu')) ? 'is-invalid' : ''; ?>" id="maksud_bertemu" name="maksud_bertemu" value="<?= old('maksud_bertemu', $tamu['maksud_bertemu']); ?>" required>
                <?php if (session('validation') && session('validation')->hasError('maksud_bertemu')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('maksud_bertemu'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Tamu (via Webcam)</label>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6>Foto Saat Ini:</h6>
                        <?php if ($tamu['jalur_foto']) : ?>
                            <img src="<?= base_url($tamu['jalur_foto']); ?>" alt="Foto Tamu" class="img-thumbnail mb-2" width="240">
                        <?php else : ?>
                            <img src="<?= base_url('assets/img/default_avatar.png'); ?>" alt="Default Avatar" class="img-thumbnail mb-2" width="240">
                        <?php endif; ?>
                        <div id="my_camera" class="border border-secondary rounded overflow-hidden" style="width:320px; height:240px;"></div>
                        <button type="button" class="btn btn-sm btn-info text-white mt-2" onClick="take_snapshot()">Ambil Foto Baru</button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Hasil Foto Baru:</h6>
                        <div id="results" class="border border-secondary rounded overflow-hidden" style="width:320px; height:240px;"></div>
                        <input type="hidden" name="foto_data" id="foto_data">
                        <?php if (session('validation') && session('validation')->hasError('foto_data')) : ?>
                            <div class="text-danger mt-2">
                                <?= session('validation')->getError('foto_data'); ?>
                            </div>
                        <?php endif; ?>
                        <small class="form-text text-muted mt-2">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Update Data Tamu</button>
                <a href="<?= base_url('tamu/persetujuan/'); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'png',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            document.getElementById('foto_data').value = data_uri;
        });
    }
</script>
<?= $this->endSection(); ?>