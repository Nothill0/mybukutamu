<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Form Tambah Tamu</h1>

<!-- Modal Sukses (Ditempatkan di sini) -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-success"><i class="bi bi-check-circle-fill"></i> Berhasil!</h4>
                <p>Data tamu berhasil ditambahkan dan menunggu persetujuan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="okButton">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Data Kunjungan Tamu</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('tamu/simpan'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Tamu <span class="text-danger">*</span></label>
                    <input type="text" placeholder="Nama Lengkap ..." class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('nama')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('nama'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="text" placeholder=" 089xxxxxxx" class="form-control <?= (session('validation') && session('validation')->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon'); ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('nomor_telepon')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('nomor_telepon'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" placeholder="nama@gmail.com" class=" form-control <?= (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email'); ?>">
                <?php if (session('validation') && session('validation')->hasError('email')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('email'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea placeholder="alamat lengkap ..." class="form-control <?= (session('validation') && session('validation')->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="3" required><?= old('alamat'); ?></textarea>
                <?php if (session('validation') && session('validation')->hasError('alamat')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('alamat'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi</label>
                <input type="text" placeholder="Nama Instansi , kantor , sekolah  ..." class="form-control" id="instansi" name="instansi" value="<?= old('instansi'); ?>">
            </div>

            <div class="mb-3">
                <label for="maksud_bertemu" class="form-label">Bertemu Dengan <span class="text-danger">*</span></label>
                <input type="text" placeholder="ibu/bapak ..." class=" form-control <?= (session('validation') && session('validation')->hasError('maksud_bertemu')) ? 'is-invalid' : ''; ?>" id="maksud_bertemu" name="maksud_bertemu" value="<?= old('maksud_bertemu'); ?>" required>
                <?php if (session('validation') && session('validation')->hasError('maksud_bertemu')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('maksud_bertemu'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                <textarea placeholder="Maksud & Tujuan berkunjung ..." class="form-control <?= (session('validation') && session('validation')->hasError('tujuan_kunjungan')) ? 'is-invalid' : ''; ?>" id="tujuan_kunjungan" name="tujuan_kunjungan" rows="3" required><?= old('tujuan_kunjungan'); ?></textarea>
                <?php if (session('validation') && session('validation')->hasError('tujuan_kunjungan')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('tujuan_kunjacan'); ?>
                    </div>
                <?php endif; ?>
            </div>



            <div class="mb-3">
                <label class="form-label">Foto Tamu (via Webcam) <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div id="my_camera" class="border border-secondary rounded overflow-hidden" style="width:320px; height:240px;"></div>
                        <button type="button" class="btn btn-sm btn-info text-white mt-2" onClick="take_snapshot()">Ambil Foto</button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Hasil Foto:</h6>
                        <div id="results" class="border border-secondary rounded overflow-hidden" style="width:320px; height:240px;"></div>
                        <input type="hidden" name="foto_data" id="foto_data">
                        <?php if (session('validation') && session('validation')->hasError('foto_data')) : ?>
                            <div class="text-danger mt-2">
                                <?= session('validation')->getError('foto_data'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Simpan Tamu</button>
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

    // Cek jika ada pesan sukses, maka tampilkan modal
    <?php if (session()->getFlashdata('pesan_sukses')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: false
            });
            successModal.show();
        });
    <?php endif; ?>

    // Logika pengalihan ke halaman home saat tombol OK diklik
    document.getElementById('okButton').addEventListener('click', function() {
        window.location.href = '<?= base_url('/'); ?>';
    });
</script>
<?= $this->endSection(); ?>