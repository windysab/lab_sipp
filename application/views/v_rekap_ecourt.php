<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-chart-bar mr-2"></i> Rekap Perkara E-Court</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">E-Court</li>
								<li class="breadcrumb-item active">Rekap E-Court</li>
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
							<form action="<?= site_url('Rekap_ecourt') ?>" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Tahun:</label>
									<div class="col-sm-4">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="far fa-calendar-check"></i></span>
											</div>
											<select name="tahun" class="form-control select2" required>
												<?php
												$currentYear = date('Y');
												for ($year = 2016; $year <= $currentYear + 1; $year++) {
													$selected = ($year == $selected_year) ? 'selected' : '';
													echo "<option value=\"$year\" $selected>$year</option>";
												}
												?>
											</select>
										</div>
									</div>
									<label class="col-sm-2 col-form-label">Jenis Perkara:</label>
									<div class="col-sm-4">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-gavel"></i></span>
											</div>
											<select name="jenis_perkara" class="form-control select2">
												<option value="">-- Semua Jenis Perkara --</option>
												<?php foreach ($jenis_perkara_list as $jenis): ?>
													<?php $selected = ($jenis->jenis_perkara == $selected_jenis_perkara) ? 'selected' : ''; ?>
													<option value="<?= $jenis->jenis_perkara ?>" <?= $selected ?>><?= $jenis->jenis_perkara ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-2">
										<button type="submit" name="btn" value="search" class="btn btn-primary btn-block">
											<i class="fas fa-search mr-2"></i> Tampilkan
										</button>
									</div>
									<div class="col-sm-10">
										<a href="<?= site_url('Rekap_ecourt/export_excel?tahun=' . $selected_year . '&jenis_perkara=' . urlencode($selected_jenis_perkara)) ?>" class="btn btn-success float-right">
											<i class="fas fa-file-excel mr-2"></i> Export ke Excel
										</a>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Summary Stats -->
					<div class="row">
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-info">
								<span class="info-box-icon"><i class="fas fa-laptop-code"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total E-Court</span>
									<span class="info-box-number"><?= $summary->total_perkara ?></span>
									<div class="progress">
										<div class="progress-bar" style="width: <?= $summary->percentage_ecourt ?>%"></div>
									</div>
									<span class="progress-description">
										<?= $summary->percentage_ecourt ?>% dari total perkara
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-success">
								<span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Sudah Diputus</span>
									<span class="info-box-number"><?= $summary->total_decided ?></span>
									<div class="progress">
										<div class="progress-bar" style="width: <?= $summary->percentage_decided ?>%"></div>
									</div>
									<span class="progress-description">
										<?= $summary->percentage_decided ?>% dari perkara E-Court
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-warning">
								<span class="info-box-icon"><i class="fas fa-clock"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Dalam Proses</span>
									<span class="info-box-number"><?= $summary->total_ongoing ?></span>
									<div class="progress">
										<div class="progress-bar" style="width: <?= $summary->percentage_ongoing ?>%"></div>
									</div>
									<span class="progress-description">
										<?= $summary->percentage_ongoing ?>% dari perkara E-Court
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-danger">
								<span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Tren Perkara</span>
									<span class="info-box-number">
										<?php
										// Calculate trend percentage
										$month_now = date('n');
										$avg_per_month = $month_now > 0 ? round($summary->total_perkara / $month_now, 1) : 0;
										echo $avg_per_month;
										?>
									</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
										Rata-rata per bulan
									</span>
								</div>
							</div>
						</div>
					</div>

					<!-- Chart Row -->
					<div class="row">
						<!-- Monthly Statistics Chart -->
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-chart-line mr-1"></i>
										Statistik Bulanan E-Court Tahun <?= $selected_year ?>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Chart error messages container -->
									<div id="monthlyChartError" class="alert alert-danger" style="display: none;"></div>

									<!-- Loading indicator -->
									<div id="monthlyChartLoading" class="text-center p-3">
										<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
									</div>

									<div id="monthlyChartContainer" style="height: 300px;">
										<canvas id="monthlyChart" width="100%" height="300"></canvas>
									</div>
								</div>
							</div>
						</div>

						<!-- Case Type Distribution Chart -->
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-chart-pie mr-1"></i>
										Distribusi Jenis Perkara
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Chart error messages container -->
									<div id="pieChartError" class="alert alert-danger" style="display: none;"></div>

									<!-- Loading indicator -->
									<div id="pieChartLoading" class="text-center p-3">
										<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
									</div>

									<div id="pieChartContainer" style="height: 300px;">
										<canvas id="caseTypeChart" width="100%" height="300"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Status Distribution Row -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-tasks mr-1"></i>
										Distribusi Status Perkara
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<?php foreach ($status_distribution as $status): ?>
											<div class="col-md-3 col-sm-6 col-12">
												<div class="info-box">
													<span class="info-box-icon <?= $status->status == 'Putus' ? 'bg-success' : ($status->status == 'Proses Persidangan' ? 'bg-warning' : ($status->status == 'Terdaftar' ? 'bg-info' : 'bg-danger')) ?>">
														<i class="<?= $status->status == 'Putus' ? 'fas fa-check' : ($status->status == 'Proses Persidangan' ? 'fas fa-gavel' : ($status->status == 'Terdaftar' ? 'fas fa-file-alt' : 'fas fa-hourglass-start')) ?>"></i>
													</span>
													<div class="info-box-content">
														<span class="info-box-text"><?= $status->status ?></span>
														<span class="info-box-number"><?= $status->count ?></span>
														<div class="progress">
															<div class="progress-bar" style="width: <?= ($status->count / $summary->total_perkara) * 100 ?>%"></div>
														</div>
														<span class="progress-description">
															<?= round(($status->count / $summary->total_perkara) * 100, 1) ?>% dari total
														</span>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Data Table Card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-table mr-1"></i>
								Daftar Perkara E-Court Tahun <?= $selected_year ?>
								<?= !empty($selected_jenis_perkara) ? " - Jenis: $selected_jenis_perkara" : "" ?>
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
							<table id="dataTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th width="20%">Nomor Perkara</th>
										<th width="15%">Jenis Perkara</th>
										<th width="15%">Tgl. Daftar</th>
										<th width="15%">Tgl. Putus</th>
										<th width="15%">Status</th>
										<th width="15%">Advokat</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1;
									foreach ($ecourt_cases as $case): ?>
										<tr>
											<td><?= $no++ ?></td>
											<td>
												<?php if (!empty($case->nomor_perkara)): ?>
													<a href="<?= site_url('Ecourt_monitoring/timeline/' . $case->perkara_id) ?>" target="_blank">
														<?= $case->nomor_perkara ?>
													</a>
												<?php else: ?>
													<span class="text-muted"><?= $case->efiling_id ?></span>
												<?php endif; ?>
											</td>
											<td><?= $case->jenis_perkara_nama ?></td>
											<td><?= date('d-m-Y', strtotime($case->tanggal_pendaftaran)) ?></td>
											<td>
												<?php if (!empty($case->tanggal_putusan)): ?>
													<?= date('d-m-Y', strtotime($case->tanggal_putusan)) ?>
												<?php else: ?>
													<span class="text-muted">-</span>
												<?php endif; ?>
											</td>
											<td>
												<?php
												$badge_class = 'badge-secondary';
												if ($case->status_perkara == 'Putus') {
													$badge_class = 'badge-success';
												} elseif ($case->status_perkara == 'Proses Persidangan') {
													$badge_class = 'badge-warning';
												} elseif ($case->status_perkara == 'Terdaftar') {
													$badge_class = 'badge-info';
												}
												?>
												<span class="badge <?= $badge_class ?>"><?= $case->status_perkara ?></span>
											</td>
											<td><?= $case->nama_advokat ?: '<span class="text-muted">-</span>' ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<!-- Tambahkan Chart.js dari CDN sebelum script lainnya -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

	<script>
		$(document).ready(function() {
			// Initialize DataTable
			$("#dataTable").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": false,
				"buttons": ["copy", "excel", "pdf", "print"],
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
				}
			});

			// Fungsi untuk menampilkan error chart
			function showChartError(elementId, message) {
				console.error(message);
				$('#' + elementId + 'Loading').hide();
				$('#' + elementId + 'Error').text(message).show();
			}

			// Cek apakah Chart.js sudah dimuat
			if (typeof Chart === 'undefined') {
				showChartError('monthlyChart', 'Chart.js tidak tersedia. Memuat dari CDN...');
				showChartError('caseTypeChart', 'Chart.js tidak tersedia. Memuat dari CDN...');

				// Muat Chart.js dari CDN sebagai fallback
				$.getScript("https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js")
					.done(function() {
						console.log("Chart.js berhasil dimuat dari CDN");
						initializeCharts();
					})
					.fail(function() {
						showChartError('monthlyChart', 'Gagal memuat Chart.js dari CDN');
						showChartError('caseTypeChart', 'Gagal memuat Chart.js dari CDN');
					});
			} else {
				// Chart.js tersedia, lanjutkan dengan inisialisasi
				setTimeout(initializeCharts, 500); // Berikan sedikit waktu untuk DOM siap
			}

			// Fungsi untuk inisialisasi semua chart
			function initializeCharts() {
				try {
					// Monthly Chart - Konversi data PHP ke JavaScript
					var monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

					var totalCases = [
						<?php
						$months_data = [];
						foreach ($monthly_stats as $stat) {
							$months_data[] = isset($stat->total_cases) ? intval($stat->total_cases) : 0;
						}
						echo implode(',', $months_data);
						?>
					];

					var decidedCases = [
						<?php
						$decided_data = [];
						foreach ($monthly_stats as $stat) {
							$decided_data[] = isset($stat->total_decided) ? intval($stat->total_decided) : 0;
						}
						echo implode(',', $decided_data);
						?>
					];

					console.log('Monthly data:', {
						labels: monthlyLabels,
						totalCases,
						decidedCases
					});

					// Cek jika ada data untuk chart
					var hasMonthlyData = totalCases.some(val => val > 0) || decidedCases.some(val => val > 0);

					if (!hasMonthlyData) {
						$('#monthlyChartLoading').hide();
						$('#monthlyChart').parent().html('<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>');
					} else {
						// Buat chart bulanan
						var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
						new Chart(monthlyCtx, {
							type: 'bar',
							data: {
								labels: monthlyLabels,
								datasets: [{
										label: 'Total Perkara',
										backgroundColor: '#4e73df',
										borderColor: '#4e73df',
										data: totalCases
									},
									{
										label: 'Perkara Putus',
										backgroundColor: '#1cc88a',
										borderColor: '#1cc88a',
										data: decidedCases
									}
								]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								legend: {
									display: true,
									position: 'top'
								},
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						});
						$('#monthlyChartLoading').hide();
					}

					// Case Type Chart - Pie chart untuk distribusi jenis perkara
					var caseTypeLabels = [
						<?php
						$labels = [];
						foreach ($case_types as $type) {
							$labels[] = "'" . addslashes($type->jenis_perkara_nama) . "'";
						}
						echo implode(',', $labels);
						?>
					];

					var caseTypeData = [
						<?php
						$data = [];
						foreach ($case_types as $type) {
							$data[] = isset($type->count) ? intval($type->count) : 0;
						}
						echo implode(',', $data);
						?>
					];

					console.log('Case type data:', {
						labels: caseTypeLabels,
						data: caseTypeData
					});

					// Cek jika ada data untuk chart
					if (caseTypeLabels.length === 0 || caseTypeData.every(val => val === 0)) {
						$('#caseTypeChartLoading').hide();
						$('#caseTypeChart').parent().html('<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>');
					} else {
						// Buat chart jenis perkara
						var caseTypeCtx = document.getElementById('caseTypeChart').getContext('2d');
						new Chart(caseTypeCtx, {
							type: 'doughnut',
							data: {
								labels: caseTypeLabels,
								datasets: [{
									data: caseTypeData,
									backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#5a5c69', '#6f42c1', '#fd7e14', '#20c9a6', '#858796'],
									hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b', '#484a52', '#5d36a4', '#fd6a00', '#169b7a', '#6e707e'],
									hoverBorderColor: "rgba(234, 236, 244, 1)",
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								legend: {
									display: true,
									position: 'right'
								},
								tooltips: {
									backgroundColor: "rgb(255,255,255)",
									bodyFontColor: "#858796",
									borderColor: '#dddfeb',
									borderWidth: 1,
									xPadding: 15,
									yPadding: 15,
									displayColors: false,
									caretPadding: 10,
								}
							}
						});
						$('#caseTypeChartLoading').hide();
					}

				} catch (error) {
					console.error('Error initializing charts:', error);
					showChartError('monthlyChart', 'Terjadi kesalahan: ' + error.message);
					showChartError('caseTypeChart', 'Terjadi kesalahan: ' + error.message);
				}
			}
		});
	</script>
</body>