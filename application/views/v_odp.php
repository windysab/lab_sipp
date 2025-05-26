<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-business-time mr-2"></i>One Day Publish</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">One Day Service</li>
								<li class="breadcrumb-item active">One Day Publish</li>
							</ol>
						</div>
					</div>
				</div>
			</section>

			<section class="content">
				<div class="container-fluid">
					<!-- Include custom CSS for ODP -->
					<link rel="stylesheet" href="<?= base_url() ?>assets/css/odp-custom.css">

					<!-- Filter Card -->
					<div class="card filter-card card-primary card-outline fade-in-up">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Data</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<form action="<?= base_url() ?>index.php/Odp" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Jenis Laporan:</label>
									<div class="col-sm-10">
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="laporan_bulanan" name="jenis_filter" value="bulanan" class="custom-control-input" <?= (!isset($jenis_filter) || (isset($jenis_filter) && $jenis_filter === 'bulanan')) ? 'checked' : '' ?>>
											<label class="custom-control-label" for="laporan_bulanan">Laporan Bulanan</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="laporan_tahunan" name="jenis_filter" value="tahunan" class="custom-control-input" <?= (isset($jenis_filter) && $jenis_filter === 'tahunan') ? 'checked' : '' ?>>
											<label class="custom-control-label" for="laporan_tahunan">Laporan Tahunan</label>
										</div>
									</div>
								</div>
								<div class="form-group row" id="bulan_container">
									<label class="col-sm-2 col-form-label">Bulan:</label>
									<div class="col-sm-4">
										<select name="lap_bulan" class="form-control select2" id="lap_bulan">
											<option value="">-- Pilih Bulan --</option>
											<?php
											foreach ($nama_bulan as $value => $label) {
												$selected = (isset($lap_bulan) && $lap_bulan == $value) ? 'selected="selected"' : '';
												echo "<option value=\"$value\" $selected>$label</option>";
											}
											?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">Tahun:</label>
									<div class="col-sm-4">
										<select name="lap_tahun" class="form-control select2" required>
											<option value="">-- Pilih Tahun --</option>
											<?php
											$currentYear = date('Y');
											for ($year = 2016; $year <= $currentYear + 1; $year++) {
												$selected = (isset($lap_tahun) && $lap_tahun == $year) ? 'selected="selected"' : '';
												echo "<option value=\"$year\" $selected>$year</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 offset-sm-8">
										<button type="submit" name="btn" value="Tampilkan" class="btn btn-primary btn-block">
											<i class="fas fa-search mr-2"></i> Tampilkan Data
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<?php if (!empty($datafilter)): ?>
						<!-- Export Buttons Row - Add directly below the filter card -->
						<div class="row mb-3">
							<div class="col-md-12">
								<a href="<?= site_url('Odp/export_excel/' . (isset($lap_bulan) ? $lap_bulan : 'all') . '/' . $lap_tahun) ?>" class="btn btn-success">
									<i class="fas fa-file-excel mr-2"></i> Export ke Excel
								</a>
								<span class="text-muted ml-2">
									<i class="fas fa-info-circle"></i>
									Klik tombol untuk mengunduh data dalam format Excel
								</span>
							</div>
						</div>

						<!-- Statistics Cards -->
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?= isset($stats->total_putus) ? $stats->total_putus : 0 ?></h3>
										<p>Total Perkara Putus</p>
									</div>
									<div class="icon">
										<i class="fas fa-gavel"></i>
									</div>
									<a href="#" class="small-box-footer">
										<?php if (!empty($lap_bulan)): ?>
											Periode: <?= $nama_bulan[$lap_bulan] ?> <?= $lap_tahun ?>
										<?php else: ?>
											Periode: Tahun <?= $lap_tahun ?>
										<?php endif; ?>
										<i class="fas fa-calendar-alt mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= isset($stats->total_publish) ? $stats->total_publish : 0 ?></h3>
										<p>Total Terpublikasi</p>
									</div>
									<div class="icon">
										<i class="fas fa-cloud-upload-alt"></i>
									</div>
									<a href="#" class="small-box-footer">
										<?= isset($stats->total_publish) && isset($stats->total_putus) ?
											round(($stats->total_publish / $stats->total_putus) * 100, 1) . '%' :
											'0%' ?> dari total perkara
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3><?= isset($stats->total_odp_same_day) ? $stats->total_odp_same_day : 0 ?></h3>
										<p>One Day Publish</p>
									</div>
									<div class="icon">
										<i class="fas fa-bolt"></i>
									</div>
									<a href="#" class="small-box-footer">
										<?= isset($stats->pct_odp_same_day) ? $stats->pct_odp_same_day . '%' : '0%' ?> dari total perkara
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3><?= isset($stats->avg_publish_days) ? round($stats->avg_publish_days, 1) : '-' ?></h3>
										<p>Rata-rata Hari Publikasi</p>
									</div>
									<div class="icon">
										<i class="fas fa-clock"></i>
									</div>
									<a href="#" class="small-box-footer">
										Hari sejak putusan
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>
						</div>

						<!-- Chart Row -->
						<div class="row">
							<!-- Performa ODP Bulanan -->
							<div class="col-md-6">
								<div class="card">
									<div class="card-header bg-primary text-white">
										<h3 class="card-title">
											<i class="fas fa-chart-line mr-1"></i>
											Performa ODP Bulanan Tahun <?= $lap_tahun ?>
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<!-- Menambahkan pesan loading -->
										<div id="performance-loading" class="text-center p-3">
											<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
										</div>
										<div id="monthly-performance-chart" style="min-height: 300px; width: 100%;"></div>
									</div>
								</div>
							</div>

							<!-- Distribusi Jenis Perkara -->
							<div class="col-md-6">
								<div class="card">
									<div class="card-header bg-success text-white">
										<h3 class="card-title">
											<i class="fas fa-chart-pie mr-1"></i>
											Distribusi Jenis Perkara
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<!-- Menambahkan pesan loading -->
										<div id="distribution-loading" class="text-center p-3">
											<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
										</div>
										<div id="case-distribution-chart" style="min-height: 300px; width: 100%;"></div>
									</div>
								</div>
							</div>
						</div>

						<!-- Timeline Performance -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-purple text-white">
										<h3 class="card-title">
											<i class="fas fa-calendar-alt mr-1"></i>
											Timeline ODP <?= $lap_tahun ?>
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<!-- Menambahkan pesan loading -->
										<div id="timeline-loading" class="text-center p-3">
											<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
										</div>
										<div id="odp-timeline-chart" style="min-height: 250px; width: 100%;"></div>
									</div>
								</div>
							</div>
						</div>

						<!-- Additional Info Card -->
						<div class="card bg-gradient-info">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-info-circle mr-1"></i>
									Informasi One Day Publish
								</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<p>One Day Publish (ODP) adalah layanan percepatan publikasi putusan/penetapan perkara pada hari yang sama dengan hari diputuskannya perkara. Layanan ini bertujuan untuk:</p>
								<ul>
									<li>Meningkatkan kecepatan layanan informasi kepada para pencari keadilan</li>
									<li>Mempercepat publikasi putusan untuk kepentingan transparansi peradilan</li>
									<li>Memastikan putusan pengadilan dapat diakses oleh publik secara cepat melalui Direktori Putusan</li>
								</ul>
								<div class="alert alert-light">
									<i class="fas fa-exclamation-circle mr-2"></i> Perkara yang tidak dipublikasi pada hari yang sama dengan hari putusan, tidak dianggap sebagai ODP dan memerlukan tindak lanjut lebih cepat.
								</div>
							</div>
						</div>

						<!-- Main Data Card -->
						<div class="card card-outline card-primary">
							<div class="card-header bg-light">
								<h3 class="card-title">
									<i class="fas fa-table mr-1"></i>
									Data One Day Publish
									<?php if (!empty($lap_bulan)): ?>
										- <?= $nama_bulan[$lap_bulan] ?> <?= $lap_tahun ?>
									<?php else: ?>
										- Tahun <?= $lap_tahun ?>
									<?php endif; ?>
								</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<button type="button" class="btn btn-tool" data-card-widget="maximize">
										<i class="fas fa-expand"></i>
									</button>
									<div class="btn-group ml-2">
										<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
											<i class="fas fa-download"></i> Export
										</button>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" class="dropdown-item export-excel">
												<i class="fas fa-file-excel mr-2"></i> Excel
											</a>
											<a href="#" class="dropdown-item export-pdf">
												<i class="fas fa-file-pdf mr-2"></i> PDF
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th class="text-center" width="5%">No</th>
												<th width="15%">Nomor Perkara</th>
												<th width="15%">Jenis Perkara</th>
												<th width="12%">Tanggal Putus</th>
												<th width="12%">Tanggal Minutasi</th>
												<th width="12%">Tanggal Publish</th>
												<th width="8%">Selisih Hari</th>
												<th width="8%">Status ODP</th>
												<th width="13%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($datafilter as $row):
												// Determine row class based on ODP status
												$rowClass = '';
												$badgeClass = 'badge-secondary';
												$badgeText = 'Tidak';

												// ODP status
												if ($row->is_odp === 'Ya') {
													$rowClass = 'table-success';
													$badgeClass = 'badge-success';
													$badgeText = 'ODP';
												} elseif ($row->is_odp === 'Ya (1 Hari)') {
													$rowClass = 'table-info';
													$badgeClass = 'badge-info';
													$badgeText = 'ODP (1 Hari)';
												}
											?>
												<tr class="<?= $rowClass ?>">
													<td class="text-center"><?= $no++ ?></td>
													<td><?= $row->nomor_perkara ?></td>
													<td><?= $row->jenis_perkara_nama ?></td>
													<td><?= date('d-m-Y', strtotime($row->tanggal_putusan)) ?></td>
													<td><?= !empty($row->tanggal_minutasi) ? date('d-m-Y', strtotime($row->tanggal_minutasi)) : '<span class="text-danger">-</span>' ?></td>
													<td><?= date('d-m-Y', strtotime($row->tanggal_publish)) ?></td>
													<td class="text-center">
														<?php if ($row->selisih_hari <= 0): ?>
															<span class="badge badge-success">0</span>
														<?php elseif ($row->selisih_hari <= 1): ?>
															<span class="badge badge-info">1</span>
														<?php elseif ($row->selisih_hari <= 3): ?>
															<span class="badge badge-warning"><?= $row->selisih_hari ?></span>
														<?php else: ?>
															<span class="badge badge-danger"><?= $row->selisih_hari ?></span>
														<?php endif; ?>
													</td>
													<td class="text-center">
														<span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
													</td>
													<td>
														<?php if (isset($row->perkara_id)): ?>
															<a href="<?= site_url('Odp/detail/' . $row->perkara_id) ?>" class="btn btn-xs btn-success" target="_blank" data-toggle="tooltip" title="Lihat Detail Lengkap">
																<i class="fas fa-eye"></i>
															</a>
														<?php endif; ?>
														<?php if (!empty($row->link_dirput)): ?>
															<a href="<?= $row->link_dirput ?>" class="btn btn-xs btn-info" target="_blank" data-toggle="tooltip" title="Lihat Putusan">
																<i class="fas fa-file-pdf"></i>
															</a>
														<?php else: ?>
															<a href="https://putusan3.mahkamahagung.go.id/search.html?q=<?= $row->nomor_perkara ?>" class="btn btn-xs btn-secondary" target="_blank" data-toggle="tooltip" title="Cari di Direktori Putusan">
																<i class="fas fa-search"></i>
															</a>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer bg-light">
								<div class="row">
									<div class="col-md-6">
										<span class="text-muted"><i class="fas fa-info-circle mr-1"></i> Keterangan:</span>
										<ul class="list-inline ml-4 mb-0">
											<li class="list-inline-item"><span class="badge badge-success">ODP</span> = Dipublikasi hari yang sama dengan putusan</li>
											<li class="list-inline-item"><span class="badge badge-info">ODP (1 Hari)</span> = Dipublikasi 1 hari setelah putusan</li>
										</ul>
									</div>
									<div class="col-md-6 text-right">
										<small class="text-muted">Total data: <?= count($datafilter) ?> | Diperbarui: <?= date('d-m-Y H:i:s') ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php else: ?>
						<!-- No Data Message -->
						<div class="alert alert-warning alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-exclamation-triangle"></i> Tidak Ada Data</h5>
							<p>Tidak ditemukan data ODP pada periode yang dipilih. Silahkan pilih periode lainnya.</p> No Data Message -->
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>

	<!-- Detail Modal -->
	<div class="modal fade" id="detailModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title">Detail Publikasi Putusan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-striped">
						<tr>
							<th style="width: 40%">Nomor Perkara</th>
							<td id="detail-nomor"></td>
						</tr>
						<tr>
							<th>Jenis Perkara</th>
							<td id="detail-jenis"></td>
						</tr>
						<tr>
							<th>Tanggal Putusan</th>
							<td id="detail-putus"></td>
						</tr>
						<tr>
							<th>Tanggal Minutasi</th>
							<td id="detail-minutasi"></td>
						</tr>
						<tr>
							<th>Tanggal Publikasi</th>
							<td id="detail-publish"></td>
						</tr>
						<tr>
							<th>Selisih Hari</th>
							<td id="detail-selisih"></td>
						</tr>
						<tr>
							<th>Status ODP</th>
							<td id="detail-status"></td>
						</tr>
						<tr>
							<th>Nama File</th>
							<td id="detail-filename"></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Gunakan hanya Highcharts (hapus ApexCharts) -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<!-- Load Select2 CSS dan JS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- Script untuk chart -->
	<script>
		$(function() {
			// Initialize Select2, tooltips, etc.
			if ($.fn.select2) {
				$('.select2').select2({
					theme: 'bootstrap4'
				});
			}

			// Toggle bulan field
			function toggleBulanField() {
				if ($("#laporan_tahunan").is(":checked")) {
					$("#bulan_container").hide();
					$("#lap_bulan").prop("required", false).prop("disabled", true);
				} else {
					$("#bulan_container").show();
					$("#lap_bulan").prop("required", true).prop("disabled", false);
				}
			}
			toggleBulanField();
			$("input[name='jenis_filter']").change(toggleBulanField);

			// Initialize DataTables
			if ($.fn.DataTable) {
				$("#dataTable").DataTable({
					// Definisi DataTable Anda
					"responsive": true,
					"lengthChange": true,
					"autoWidth": false,
					"pageLength": 10,
					"language": {
						"search": "Cari:",
						"lengthMenu": "Tampilkan _MENU_ baris per halaman",
						"zeroRecords": "Tidak ada data yang ditemukan",
						"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
						"infoEmpty": "Tidak ada data untuk ditampilkan",
						"infoFiltered": "(disaring dari _MAX_ total data)",
						"paginate": {
							"first": "Pertama",
							"last": "Terakhir",
							"next": "Selanjutnya",
							"previous": "Sebelumnya"
						}
					}
				});
			}

			// Initialize tooltips
			$('[data-toggle="tooltip"]').tooltip();

			// Export handlers
			$('.export-excel').click(function(e) {
				e.preventDefault();
				window.location.href = '<?= site_url('Odp/export_excel/' . (isset($lap_bulan) ? $lap_bulan : 'all') . '/' . $lap_tahun) ?>';
			});

			<?php if (!empty($datafilter)): ?>

				console.log('Initializing charts...');

				// Create data arrays
				try {
					// Monthly names
					const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

					// 1. Monthly performance data
					const totalCasesData = [
						<?php
						$monthData = array_fill(0, 12, 0);
						if (!empty($monthly_performance)) {
							foreach ($monthly_performance as $item) {
								$monthData[(int)$item->month_num - 1] = (int)$item->total_putus;
							}
						}
						echo implode(', ', $monthData);
						?>
					];

					console.log('Total cases data:', totalCasesData);

					const odpData = [
						<?php
						$odpData = array_fill(0, 12, 0);
						if (!empty($monthly_performance)) {
							foreach ($monthly_performance as $item) {
								$odpData[(int)$item->month_num - 1] = (int)$item->total_odp_same_day;
							}
						}
						echo implode(', ', $odpData);
						?>
					];

					console.log('ODP data:', odpData);

					// Initialize monthly performance chart
					setTimeout(function() {
						console.log('Creating monthly performance chart...');

						try {
							// Hide loading indicator
							$('#performance-loading').hide();

							// Monthly Performance Chart
							Highcharts.chart('monthly-performance-chart', {
								chart: {
									type: 'column',
									backgroundColor: '#ffffff'
								},
								title: {
									text: null
								},
								credits: {
									enabled: false
								},
								xAxis: {
									categories: monthNames,
									crosshair: true
								},
								yAxis: {
									min: 0,
									title: {
										text: 'Jumlah Perkara'
									}
								},
								tooltip: {
									headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
									pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
										'<td style="padding:0"><b>{point.y} perkara</b></td></tr>',
									footerFormat: '</table>',
									shared: true,
									useHTML: true
								},
								plotOptions: {
									column: {
										pointPadding: 0.2,
										borderWidth: 0
									}
								},
								series: [{
									name: 'Total Perkara',
									color: '#007bff',
									data: totalCasesData
								}, {
									name: 'ODP',
									color: '#28a745',
									data: odpData
								}]
							});

							console.log('Monthly performance chart created successfully');
						} catch (error) {
							console.error('Error creating monthly chart:', error);
							$('#monthly-performance-chart').html('<div class="alert alert-danger">Gagal membuat chart. Error: ' + error.message + '</div>');
						}
					}, 500);

					// Case distribution data
					<?php if (!empty($perkara_distribution)): ?>

						// Format case distribution data
						const caseData = [
							<?php
							if (!empty($perkara_distribution)) {
								foreach ($perkara_distribution as $item) {
									echo "{
								name: '" . addslashes($item->jenis_perkara_nama) . "',
								y: " . (int)$item->total_cases . "
							},";
								}
							}
							?>
						];

						console.log('Case distribution data:', caseData);

						// Initialize case distribution chart
						setTimeout(function() {
							console.log('Creating case distribution chart...');

							try {
								// Hide loading indicator
								$('#distribution-loading').hide();

								// Create case distribution chart
								Highcharts.chart('case-distribution-chart', {
									chart: {
										plotBackgroundColor: null,
										plotBorderWidth: null,
										plotShadow: false,
										type: 'pie',
										backgroundColor: '#ffffff'
									},
									title: {
										text: null
									},
									credits: {
										enabled: false
									},
									tooltip: {
										pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Total: {point.y} perkara'
									},
									accessibility: {
										point: {
											valueSuffix: '%'
										}
									},
									plotOptions: {
										pie: {
											allowPointSelect: true,
											cursor: 'pointer',
											dataLabels: {
												enabled: true,
												format: '<b>{point.name}</b>: {point.percentage:.1f} %'
											}
										}
									},
									series: [{
										name: 'Jenis Perkara',
										colorByPoint: true,
										data: caseData
									}]
								});

								console.log('Case distribution chart created successfully');
							} catch (error) {
								console.error('Error creating distribution chart:', error);
								$('#case-distribution-chart').html('<div class="alert alert-danger">Gagal membuat chart. Error: ' + error.message + '</div>');
							}
						}, 800);
					<?php endif; ?>

					// Timeline data
					const odpPercentage = [
						<?php
						$pctData = array_fill(0, 12, 0);
						if (!empty($monthly_performance)) {
							foreach ($monthly_performance as $item) {
								if ((int)$item->total_putus > 0) {
									$pct = round(((int)$item->total_odp_same_day / (int)$item->total_putus) * 100, 1);
								} else {
									$pct = 0;
								}
								$pctData[(int)$item->month_num - 1] = $pct;
							}
						}
						echo implode(', ', $pctData);
						?>
					];

					console.log('ODP percentage data:', odpPercentage);

					// Initialize timeline chart
					setTimeout(function() {
						console.log('Creating timeline chart...');

						try {
							// Hide loading indicator
							$('#timeline-loading').hide();

							// Create timeline chart
							Highcharts.chart('odp-timeline-chart', {
								chart: {
									type: 'areaspline',
									backgroundColor: '#ffffff'
								},
								title: {
									text: null
								},
								credits: {
									enabled: false
								},
								xAxis: {
									categories: monthNames
								},
								yAxis: {
									title: {
										text: 'Persentase ODP (%)'
									},
									labels: {
										format: '{value}%'
									},
									min: 0,
									max: 100
								},
								tooltip: {
									pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b><br/>'
								},
								plotOptions: {
									areaspline: {
										fillOpacity: 0.5
									}
								},
								series: [{
									name: 'Persentase ODP',
									data: odpPercentage,
									color: '#8e44ad'
								}]
							});

							console.log('Timeline chart created successfully');
						} catch (error) {
							console.error('Error creating timeline chart:', error);
							$('#odp-timeline-chart').html('<div class="alert alert-danger">Gagal membuat chart. Error: ' + error.message + '</div>');
						}
					}, 1000);

				} catch (error) {
					console.error('Error in chart initialization:', error);
				}
			<?php endif; ?>
		});
	</script>
</body>

</html>