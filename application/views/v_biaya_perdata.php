<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"><i class="fas fa-money-bill-wave mr-2"></i> Analisis Biaya Perkara Perdata</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
                                <li class="breadcrumb-item">Perkara</li>
                                <li class="breadcrumb-item active">Analisis Biaya</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <!-- Filter Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Data</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url() ?>index.php/Biaya_perdata" method="POST" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Perkara:</label>
                                    <div class="col-sm-4">
                                        <select name="jenis_perkara" class="form-control select2" required>
                                            <option value="Pdt.G" <?php echo (isset($jenis_perkara) && $jenis_perkara === 'Pdt.G') ? 'selected' : ''; ?>>Perkara Gugatan (Pdt.G)</option>
                                            <option value="Pdt.P" <?php echo (isset($jenis_perkara) && $jenis_perkara === 'Pdt.P') ? 'selected' : ''; ?>>Perkara Permohonan (Pdt.P)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Periode Laporan:</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <select name="lap_bulan" class="form-control select2" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <?php
                                                $currentMonth = date('m');
                                                foreach ($months as $value => $label) {
                                                    $selected = (isset($lap_bulan) && $lap_bulan == $value) ? 'selected="selected"' : '';
                                                    echo "<option value=\"$value\" $selected>$label</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                            </div>
                                            <select name="lap_tahun" class="form-control select2" required>
                                                <option value="">-- Pilih Tahun --</option>
                                                <?php
                                                $currentYear = date('Y');
                                                for ($year = 2016; $year <= $currentYear + 5; $year++) {
                                                    $selected = (isset($lap_tahun) && $lap_tahun == $year) ? 'selected="selected"' : '';
                                                    echo "<option value=\"$year\" $selected>$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" name="btn" value="Tampilkan" class="btn btn-primary">
                                            <i class="fas fa-search mr-1"></i> Tampilkan Data
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Information Alert -->
                    <?php if (isset($lap_bulan) && isset($lap_tahun)): ?>
                        <div class="alert alert-info">
                            <i class="icon fas fa-info-circle"></i>
                            <strong>Info Pencarian:</strong>
                            Menampilkan analisis biaya perkara <strong><?= $jenis_perkara ?></strong> pada periode <strong><?= $months[$lap_bulan] ?> <?= $lap_tahun ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($biaya_data) && !empty($biaya_data)): ?>
                        <!-- Cost Analysis Overview -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?= count($biaya_data) ?></h3>
                                        <p>Total Perkara Non-Prodeo</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Periode: <?= $months[$lap_bulan] ?> <?= $lap_tahun ?>
                                        <i class="fas fa-info-circle mx-1"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Rp. <?= number_format(isset($stats->avg_biaya) ? $stats->avg_biaya : 0, 0, ',', '.') ?></h3>
                                        <p>Rata-rata Biaya per Perkara</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Standar deviasi: <?= isset($stats->std_biaya) ? number_format($stats->std_biaya, 0, ',', '.') : 0 ?>
                                        <i class="fas fa-info-circle mx-1"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?= isset($stats->total_prodeo) ? $stats->total_prodeo : 0 ?></h3>
                                        <p>Jumlah Perkara Prodeo</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Perkara cuma-cuma
                                        <i class="fas fa-info-circle mx-1"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>Rp. <?= number_format(isset($stats->potential_savings) ? $stats->potential_savings : 0, 0, ',', '.') ?></h3>
                                        <p>Penghematan dari Prodeo</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-piggy-bank"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Estimasi penghematan biaya
                                        <i class="fas fa-info-circle mx-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Components Card -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-chart-bar mr-1"></i>
                                            Komponen Biaya Perkara
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="height: 300px">
                                            <canvas id="feeComponentsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-list-alt mr-1"></i>
                                            Rincian Komponen Biaya
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Biaya</th>
                                                        <th class="text-center">Jumlah Kasus</th>
                                                        <th class="text-right">Rata-rata</th>
                                                        <th class="text-right">Min-Max</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($komponen_biaya) && !empty($komponen_biaya)): ?>
                                                        <?php foreach ($komponen_biaya as $comp): ?>
                                                            <tr>
                                                                <td><?= $comp->jenis_biaya ?></td>
                                                                <td class="text-center"><?= $comp->jumlah_kasus ?></td>
                                                                <td class="text-right">Rp. <?= number_format($comp->rata_rata, 0, ',', '.') ?></td>
                                                                <td class="text-right">
                                                                    <small><?= number_format($comp->minimum, 0, ',', '.') ?> - <?= number_format($comp->maksimum, 0, ',', '.') ?></small>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">Tidak ada data komponen biaya</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Yearly Trend Chart -->
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Tren Biaya Perkara <?= $jenis_perkara ?> Tahun <?= $lap_tahun ?>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="height: 300px">
                                    <canvas id="yearlyTrendChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Export Buttons Row -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="bg-light p-3" style="border-radius: 5px; border: 1px solid #ddd;">
                                    <h5><i class="fas fa-file-export mr-2"></i> Export Analisis Biaya Perkara</h5>
                                    <div class="mt-3">
                                        <a href="<?= site_url('Biaya_perdata/export_excel?jenis_perkara=' . $jenis_perkara . '&lap_bulan=' . $lap_bulan . '&lap_tahun=' . $lap_tahun) ?>" class="btn btn-success btn-lg">
                                            <i class="fas fa-file-excel mr-2"></i> Export ke Excel
                                        </a>
                                        <button type="button" class="btn btn-danger btn-lg ml-2 export-pdf">
                                            <i class="fas fa-file-pdf mr-2"></i> Export ke PDF
                                        </button>
                                        <button type="button" class="btn btn-primary btn-lg ml-2 print-data">
                                            <i class="fas fa-print mr-2"></i> Cetak
                                        </button>
                                        <span class="text-muted ml-3">
                                            <i class="fas fa-info-circle mr-1"></i> Klik tombol untuk mengunduh data dalam format yang diinginkan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Data Table -->
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-table mr-1"></i>
                                    Data Biaya Perkara <?= $jenis_perkara ?> - <?= $months[$lap_bulan] ?> <?= $lap_tahun ?>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">No</th>
                                            <th width="15%">Nomor Perkara</th>
                                            <th width="10%">Jenis Perkara</th>
                                            <th width="10%">Tgl Pendaftaran</th>
                                            <th width="10%">Tgl Putusan</th>
                                            <th width="12%">Total Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($biaya_data as $row):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $row->nomor_perkara ?></td>
                                                <td><?= $row->jenis_perkara_nama ?></td>
                                                <td><?= date('d-m-Y', strtotime($row->tanggal_pendaftaran)) ?></td>
                                                <td><?= !empty($row->tanggal_putusan) ? date('d-m-Y', strtotime($row->tanggal_putusan)) : '-' ?></td>
                                                <td class="text-right">
                                                    Rp. <?= number_format($row->total_biaya, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Rata-rata Biaya:</th>
                                            <th class="text-right">
                                                Rp. <?= number_format(isset($stats->avg_biaya) ? $stats->avg_biaya : 0, 0, ',', '.') ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <small class="text-muted">
                                        Total data: <?= count($biaya_data) ?> |
                                        Diperbarui: <?= date('d-m-Y H:i:s') ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php elseif (isset($lap_bulan) && isset($lap_tahun)): ?>
                        <!-- No Data Alert -->
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Tidak Ada Data</h5>
                            <p>Tidak ditemukan data biaya perkara untuk jenis <strong><?= $jenis_perkara ?></strong> pada periode <strong><?= $months[$lap_bulan] ?> <?= $lap_tahun ?></strong>.</p>
                            <p>Silakan coba periode lain atau jenis perkara yang berbeda.</p>
                        </div>
                    <?php else: ?>
                        <!-- Welcome Message -->
                        <div class="jumbotron bg-light">
                            <h1 class="display-5"><i class="fas fa-money-bill-wave mr-2"></i> Analisis Biaya Perkara Perdata</h1>
                            <p class="lead">Silakan tentukan parameter pencarian untuk menampilkan data analisis biaya perkara perdata.</p>
                            <hr class="my-4">
                            <p>Analisis ini memberikan gambaran mengenai rata-rata biaya perkara perdata serta rincian komponen biayanya.</p>
                            <p>Data ini juga dapat digunakan untuk melakukan estimasi penghematan biaya dari perkara prodeo (cuma-cuma).</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Initialize DataTables
            $("#dataTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "buttons": [{
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Analisis Biaya Perkara <?= isset($jenis_perkara) ? $jenis_perkara : "" ?> <?= isset($lap_bulan) ? $months[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Analisis Biaya Perkara <?= isset($jenis_perkara) ? $jenis_perkara : "" ?> <?= isset($lap_bulan) ? $months[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>',
                        orientation: 'landscape',
                        className: 'btn-danger'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'Analisis Biaya Perkara <?= isset($jenis_perkara) ? $jenis_perkara : "" ?> <?= isset($lap_bulan) ? $months[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>',
                        className: 'btn-primary'
                    }
                ]
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');

            // Export buttons binding
            $('.export-pdf').click(function() {
                $('.buttons-pdf').click();
            });

            $('.print-data').click(function() {
                $('.buttons-print').click();
            });

            <?php if (isset($komponen_biaya) && !empty($komponen_biaya)): ?>
                // Fee Components Chart
                if (document.getElementById('feeComponentsChart')) {
                    var ctx = document.getElementById('feeComponentsChart').getContext('2d');
                    var feeChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [
                                <?php
                                $labels = [];
                                foreach ($komponen_biaya as $comp) {
                                    $labels[] = "'" . addslashes($comp->jenis_biaya) . "'";
                                }
                                echo implode(',', $labels);
                                ?>
                            ],
                            datasets: [{
                                label: 'Rata-rata Biaya (Rp)',
                                data: [
                                    <?php
                                    $values = [];
                                    foreach ($komponen_biaya as $comp) {
                                        $values[] = $comp->rata_rata;
                                    }
                                    echo implode(',', $values);
                                    ?>
                                ],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(255, 206, 86, 0.8)',
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(153, 102, 255, 0.8)',
                                    'rgba(255, 159, 64, 0.8)',
                                    'rgba(199, 199, 199, 0.8)',
                                    'rgba(83, 102, 255, 0.8)',
                                    'rgba(40, 159, 64, 0.8)',
                                    'rgba(210, 199, 199, 0.8)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(199, 199, 199, 1)',
                                    'rgba(83, 102, 255, 1)',
                                    'rgba(40, 159, 64, 1)',
                                    'rgba(210, 199, 199, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value, index, values) {
                                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        }
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return 'Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                }
                            }
                        }
                    });
                }
            <?php endif; ?>

            <?php if (isset($yearly_trend) && !empty($yearly_trend)): ?>
                // Yearly Trend Chart
                if (document.getElementById('yearlyTrendChart')) {
                    var ctx = document.getElementById('yearlyTrendChart').getContext('2d');

                    var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                    var monthData = Array(12).fill(0);
                    var caseCountData = Array(12).fill(0);

                    <?php foreach ($yearly_trend as $item): ?>
                        monthData[<?= $item->bulan - 1 ?>] = <?= $item->avg_biaya ?>;
                        caseCountData[<?= $item->bulan - 1 ?>] = <?= $item->total_perkara ?>;
                    <?php endforeach; ?>

                    var trendChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: monthNames,
                            datasets: [{
                                    label: 'Rata-rata Biaya (Rp)',
                                    data: monthData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 2,
                                    yAxisID: 'y-axis-1'
                                },
                                {
                                    label: 'Jumlah Kasus',
                                    data: caseCountData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    yAxisID: 'y-axis-2',
                                    type: 'bar'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                        type: 'linear',
                                        display: true,
                                        position: 'left',
                                        id: 'y-axis-1',
                                        ticks: {
                                            beginAtZero: true,
                                            callback: function(value, index, values) {
                                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                            }
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Biaya (Rp)'
                                        }
                                    },
                                    {
                                        type: 'linear',
                                        display: true,
                                        position: 'right',
                                        id: 'y-axis-2',
                                        ticks: {
                                            beginAtZero: true,
                                            precision: 0 // Ensure integers
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Jumlah Kasus'
                                        },
                                        gridLines: {
                                            drawOnChartArea: false
                                        }
                                    }
                                ]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        if (tooltipItem.datasetIndex === 0) {
                                            return 'Biaya: Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        } else {
                                            return 'Jumlah: ' + tooltipItem.yLabel;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>