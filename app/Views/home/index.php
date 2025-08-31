<?= $this->extend('templates/layout'); ?>

<?= $this->section('content'); ?>

<h1 class="mb-4">Beranda</h1>

<div class="row">
    <!-- Chart Statistik Harian, Bulanan, Tahunan -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Jumlah Tamu </h5>
                <div class="form-group mb-0">
                    <select class="form-select form-select-sm" id="periodFilter">
                        <option value="harian" selected>Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                        <option value="tahunan">Tahunan</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="mainChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Top 3 Maksud Bertemu -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Paling Sering ditemui</h5>
            </div>
            <div class="card-body">
                <canvas id="maksudBertemuChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Daftar Tamu Disetujui</h5>
    </div>
    <div class="card-body">
        <!-- Form Pencarian -->
        <div class="row mb-3">
            <div class="col-md-6 offset-md-6">
                <form action="<?= base_url('home'); ?>" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari tamu disetujui..." name="keyword" value="<?= esc($keyword); ?>">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        <?php if ($keyword) : ?>
                            <a href="<?= base_url('home'); ?>" class="btn btn-outline-danger">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Instansi / Alamat</th>
                        <th>Bertemu</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tamu_disetujui)) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada tamu yang disetujui.</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $currentPage = $pager_disetujui->getCurrentPage('disetujui');
                        $perPage = $pager_disetujui->getPerPage('disetujui');
                        $no = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($tamu_disetujui as $tamu) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($tamu['nama']); ?></td>
                                <td><?= esc($tamu['instansi'] ?: $tamu['alamat']); ?></td>
                                <td><?= esc($tamu['maksud_bertemu']); ?></td>
                                <td><?= date('d M Y', strtotime($tamu['dibuat_pada'])); ?></td>
                                <td>
                                    <a href="<?= base_url('tamu/detail/' . $tamu['id']); ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <?= $pager_disetujui->links('disetujui', 'bootstrap_full'); ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- Sertakan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let mainChart;
        let maksudBertemuChart;
        let chartData = {};

        const mainChartCtx = document.getElementById('mainChart').getContext('2d');
        const maksudBertemuChartCtx = document.getElementById('maksudBertemuChart').getContext('2d');

        // Fungsi untuk mengambil data dan merender chart
        function fetchChartData() {
            fetch('<?= base_url('home/getChartData'); ?>')
                .then(response => response.json())
                .then(data => {
                    chartData = data;
                    renderMaksudBertemuChart(chartData.maksudBertemu);
                    updateMainChart('harian'); // Tampilkan chart harian secara default
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        // Fungsi untuk merender chart utama (Harian, Bulanan, Tahunan)
        function updateMainChart(period) {
            if (mainChart) {
                mainChart.destroy();
            }

            let labels = [];
            let data = [];
            let label = '';
            let type = 'bar'; // Default type
            let backgroundColor = 'rgba(75, 192, 192, 0.6)';
            let borderColor = 'rgba(75, 192, 192, 1)';
            let tension = 0;

            switch (period) {
                case 'harian':
                    labels = chartData.harian.map(item => item.tanggal);
                    data = chartData.harian.map(item => item.jumlah);
                    label = 'Jumlah Tamu Harian';
                    type = 'bar';
                    break;
                case 'mingguan':
                    labels = chartData.mingguan.map(item => 'Minggu ' + item.minggu.slice(-2));
                    data = chartData.mingguan.map(item => item.jumlah);
                    label = 'Jumlah Tamu Mingguan';
                    type = 'bar';
                    backgroundColor = 'rgba(255, 99, 132, 0.6)';
                    borderColor = 'rgba(255, 99, 132, 1)';
                    break;
                case 'bulanan':
                    labels = chartData.bulanan.map(item => item.bulan + '-' + item.tahun);
                    data = chartData.bulanan.map(item => item.jumlah);
                    label = 'Jumlah Tamu Bulanan';
                    type = 'line';
                    backgroundColor = 'rgba(54, 162, 235, 0.2)';
                    borderColor = 'rgba(54, 162, 235, 1)';
                    tension = 0.4;
                    break;
                case 'tahunan':
                    labels = chartData.tahunan.map(item => item.tahun);
                    data = chartData.tahunan.map(item => item.jumlah);
                    label = 'Jumlah Tamu Tahunan';
                    type = 'bar';
                    backgroundColor = 'rgba(255, 205, 86, 0.6)';
                    borderColor = 'rgba(255, 205, 86, 1)';
                    break;
            }

            mainChart = new Chart(mainChartCtx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        tension: tension
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Fungsi untuk merender chart Maksud Bertemu
        function renderMaksudBertemuChart(data) {
            const labels = data.map(item => item.maksud_bertemu);
            const values = data.map(item => item.jumlah);
            maksudBertemuChart = new Chart(maksudBertemuChartCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Maksud Bertemu',
                        data: values,
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                    }]
                }
            });
        }

        // Event listener untuk filter dropdown
        const periodFilter = document.getElementById('periodFilter');
        if (periodFilter) {
            periodFilter.addEventListener('change', function(event) {
                updateMainChart(event.target.value);
            });
        }

        // Panggil fungsi saat halaman dimuat
        fetchChartData();
    });
</script>
<?= $this->endSection(); ?>