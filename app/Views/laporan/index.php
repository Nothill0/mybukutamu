<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Laporan Tamu</h1>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Semua Tamu</h5>
        <button class="btn btn-warning text-dark btn-sm" onclick="window.print()"><i class="fas fa-print"></i> Cetak Laporan</button>
    </div>
    <div class="card-body">
        <!-- Form Pencarian untuk Laporan -->
        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="<?= base_url('laporan'); ?>" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari tamu..." name="keyword" value="<?= esc($keyword); ?>">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        <?php if ($keyword) : ?>
                            <a href="<?= base_url('laporan'); ?>" class="btn btn-outline-danger">Reset</a>
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
                        <th>Nama</th>
                        <th>Instansi / Alamat</th>
                        <th>Tujuan</th>
                        <th class="text-center">Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tamu)) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data tamu yang ditemukan.</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $currentPage = $pager->getCurrentPage('laporan');
                        $perPage = $pager->getPerPage('laporan');
                        $no = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($tamu as $tamu_item) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= esc($tamu_item['nama']); ?></td>
                                <td><?= esc($tamu_item['instansi'] ?: $tamu_item['alamat']); ?></td>
                                <td><?= esc($tamu_item['tujuan_kunjungan']); ?></td>
                                <td class="text-center">
                                    <?php
                                    $status_class = '';
                                    switch ($tamu_item['status']) {
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
                                    <span class="<?= $status_class; ?>"><?= ucfirst($tamu_item['status']); ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($tamu_item['dibuat_pada'])); ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('tamu/detail/' . $tamu_item['id']); ?>" class="btn btn-sm btn-info text-white" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="<?= base_url('tamu/edit/' . $tamu_item['id']); ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            <?= $pager->links('laporan', 'bootstrap_full'); ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- Font Awesome untuk ikon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>