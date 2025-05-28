<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-tachometer-alt mr-2"></i> Monitoring E-Court</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">E-Court</li>
								<li class="breadcrumb-item active">Monitoring</li>
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
							<form action="<?= site_url('Ecourt_monitoring') ?>" method="POST" class="form-horizontal">
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
									<div class="col-sm-2">
										<button type="submit" name="btn" value="search" class="btn btn-primary btn-block">
											<i class="fas fa-search mr-2"></i> Tampilkan
										</button>
									</div>
									<div class="col-sm-4">
										<a href="<?= site_url('Ecourt') ?>" class="btn btn-info float-right">
											<i class="fas fa-table mr-2"></i> Lihat Laporan E-Court
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
									<span class="info-box-number"><?= $summary->total_ecourt ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-danger">
								<span class="info-box-icon"><i class="fas fa-clock"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Belum Teregistrasi</span>
									<span class="info-box-number"><?= $summary->not_registered ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-warning">
								<span class="info-box-icon"><i class="fas fa-user-cog"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Menunggu PMH</span>
									<span class="info-box-number"><?= $summary->pending_pmh ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box bg-gradient-success">
								<span class="info-box-icon"><i class="fas fa-file-upload"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Menunggu Upload</span>
									<span class="info-box-number"><?= $summary->pending_upload ?></span>
								</div>
							</div>
						</div>
					</div>

					<!-- Progress Card -->
					<div class="card card-outline card-primary">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-chart-line mr-1"></i> Progress E-Court <?= $selected_year ?>
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-8">
									<div class="progress-group">
										<span class="progress-text">Progress Keseluruhan</span>
										<span class="float-right"><b><?= $summary->completion_percentage ?>%</b></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary" style="width: <?= $summary->completion_percentage ?>%"></div>
										</div>
									</div>

									<div class="progress-group mt-3">
										<span class="progress-text">Belum Registrasi</span>
										<span class="float-right"><b><?= $summary->not_registered ?>/<?= $summary->total_ecourt ?></b></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger" style="width: <?= $summary->total_ecourt ? ($summary->not_registered / $summary->total_ecourt * 100) : 0 ?>%"></div>
										</div>
									</div>

									<div class="progress-group">
										<span class="progress-text">Menunggu PMH</span>
										<span class="float-right"><b><?= $summary->pending_pmh ?>/<?= $summary->total_ecourt ?></b></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-warning" style="width: <?= $summary->total_ecourt ? ($summary->pending_pmh / $summary->total_ecourt * 100) : 0 ?>%"></div>
										</div>
									</div>

									<div class="progress-group">
										<span class="progress-text">Menunggu Putusan</span>
										<span class="float-right"><b><?= $summary->pending_decision ?>/<?= $summary->total_ecourt ?></b></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-info" style="width: <?= $summary->total_ecourt ? ($summary->pending_decision / $summary->total_ecourt * 100) : 0 ?>%"></div>
										</div>
									</div>

									<div class="progress-group">
										<span class="progress-text">Menunggu Upload Dokumen</span>
										<span class="float-right"><b><?= $summary->pending_upload ?>/<?= $summary->total_ecourt ?></b></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success" style="width: <?= $summary->total_ecourt ? ($summary->pending_upload / $summary->total_ecourt * 100) : 0 ?>%"></div>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="card bg-gradient-primary">
										<div class="card-header border-0">
											<h3 class="card-title">
												<i class="fas fa-map-marker-alt mr-1"></i>
												Status Perkara
											</h3>
										</div>
										<div class="card-body">
											<!-- Div untuk error -->
											<div id="chart-error" class="alert alert-danger" style="display: none;"></div>

											<!-- Div loading -->
											<div id="chart-loading" class="text-center text-white p-3">
												<i class="fas fa-spinner fa-spin mr-2"></i> Memuat chart...
											</div>

											<!-- Chart container - TIDAK perlu display:none awal -->
											<div class="chart-container" style="position: relative; height: 250px;">
												<canvas id="donut-chart"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Track Cards -->
					<div class="row">
						<!-- Pending Registration -->
						<div class="col-md-6">
							<div class="card card-danger">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-exclamation-circle mr-1"></i>
										Menunggu Registrasi
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-striped table-hover m-0">
											<thead>
												<tr>
													<th>ID</th>
													<th>Tgl. Daftar</th>
													<th>Jenis</th>
													<th>Status Bayar</th>
													<th>Tunggu</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($unregistered as $case): ?>
													<tr>
														<td><?= $case->efiling_id ?></td>
														<td><?= date('d-m-Y', strtotime($case->tanggal_pendaftaran)) ?></td>
														<td><?= $case->jenis_perkara_nama ?></td>
														<td>
															<?php if ($case->status_pembayaran == '1'): ?>
																<span class="badge badge-success">Lunas</span>
															<?php else: ?>
																<span class="badge badge-secondary">Belum</span>
															<?php endif; ?>
														</td>
														<td><span class="badge badge-warning"><?= $case->lama_tunggu ?> hari</span></td>
													</tr>
												<?php endforeach; ?>
												<?php if (empty($unregistered)): ?>
													<tr>
														<td colspan="5" class="text-center">Tidak ada data</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
									<?php if (count($unregistered) > 0): ?>
										<div class="card-footer text-center">
											<a href="#" class="text-primary">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<!-- Pending PMH -->
						<div class="col-md-6">
							<div class="card card-warning">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-user-cog mr-1"></i>
										Menunggu Penetapan Majelis Hakim
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-striped table-hover m-0">
											<thead>
												<tr>
													<th>No. Perkara</th>
													<th>Jenis</th>
													<th>Tgl. Register</th>
													<th>Tunggu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($pending_pmh as $case): ?>
													<tr>
														<td><?= $case->nomor_perkara ?></td>
														<td><?= $case->jenis_perkara_nama ?></td>
														<td><?= date('d-m-Y', strtotime($case->tanggal_pendaftaran)) ?></td>
														<td><span class="badge badge-warning"><?= $case->lama_tunggu ?> hari</span></td>
														<td>
															<a href="<?= site_url('Ecourt_monitoring/timeline/' . $case->perkara_id) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat Timeline">
																<i class="fas fa-history"></i>
															</a>
														</td>
													</tr>
												<?php endforeach; ?>
												<?php if (empty($pending_pmh)): ?>
													<tr>
														<td colspan="5" class="text-center">Tidak ada data</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
									<?php if (count($pending_pmh) > 0): ?>
										<div class="card-footer text-center">
											<a href="#" class="text-primary">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Pending Decision -->
						<div class="col-md-6">
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-gavel mr-1"></i>
										Menunggu Putusan
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-striped table-hover m-0">
											<thead>
												<tr>
													<th>No. Perkara</th>
													<th>Jenis</th>
													<th>Tgl. PMH</th>
													<th>Tunggu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($pending_decision as $case): ?>
													<tr>
														<td><?= $case->nomor_perkara ?></td>
														<td><?= $case->jenis_perkara_nama ?></td>
														<td><?= date('d-m-Y', strtotime($case->penetapan_majelis_hakim)) ?></td>
														<td><span class="badge badge-info"><?= $case->lama_tunggu ?> hari</span></td>
														<td>
															<a href="<?= site_url('Ecourt_monitoring/timeline/' . $case->perkara_id) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat Timeline">
																<i class="fas fa-history"></i>
															</a>
														</td>
													</tr>
												<?php endforeach; ?>
												<?php if (empty($pending_decision)): ?>
													<tr>
														<td colspan="5" class="text-center">Tidak ada data</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
									<?php if (count($pending_decision) > 0): ?>
										<div class="card-footer text-center">
											<a href="#" class="text-primary">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<!-- Pending Document Upload -->
						<div class="col-md-6">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-file-upload mr-1"></i>
										Menunggu Upload Dokumen
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-striped table-hover m-0">
											<thead>
												<tr>
													<th>No. Perkara</th>
													<th>Jenis</th>
													<th>Tgl. Putusan</th>
													<th>Tunggu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($pending_upload as $case): ?>
													<tr>
														<td><?= $case->nomor_perkara ?></td>
														<td><?= $case->jenis_perkara_nama ?></td>
														<td><?= date('d-m-Y', strtotime($case->tanggal_putusan)) ?></td>
														<td><span class="badge badge-success"><?= $case->lama_tunggu ?> hari</span></td>
														<td>
															<a href="<?= site_url('Ecourt_monitoring/timeline/' . $case->perkara_id) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat Timeline">
																<i class="fas fa-history"></i>
															</a>
														</td>
													</tr>
												<?php endforeach; ?>
												<?php if (empty($pending_upload)): ?>
													<tr>
														<td colspan="5" class="text-center">Tidak ada data</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
									<?php if (count($pending_upload) > 0): ?>
										<div class="card-footer text-center">
											<a href="#" class="text-primary">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>
		</div>
	</div>

	<!-- Chart.js dari CDN - letakkan di ATAS script kita -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

	<script>
		$(function() {
			// Inisialisasi Select2 dengan pengecekan
			if ($.fn.select2) {
				try {
					$('.select2').select2({
						theme: 'bootstrap4'
					});
					console.log('Select2 berhasil diinisialisasi');
				} catch (e) {
					console.error('Gagal menginisialisasi Select2:', e);
				}
			} else {
				console.error('Plugin Select2 tidak tersedia. Memuat dari CDN...');
				// Coba muat dari CDN jika tidak tersedia
				$.getScript('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', function() {
					$('.select2').select2({
						theme: 'bootstrap4'
					});
					console.log('Select2 berhasil dimuat dari CDN');
				});
			}

			$('[data-toggle="tooltip"]').tooltip();

			// Fungsi untuk menampilkan error chart
			function showChartError(message) {
				$('#chart-loading').hide();
				$('#chart-error').html(message).show();
			}

			// PERBAIKAN: Fungsi untuk membuat donut chart terpisah
			function createDonutChart() {
				console.log('Memulai pembuatan chart status perkara');

				try {
					// Hitung data yang diperlukan untuk chart
					var notRegistered = <?= intval($summary->not_registered) ?>;
					var pendingPmh = <?= intval($summary->pending_pmh) ?>;
					var pendingDecision = <?= intval($summary->pending_decision) ?>;
					var pendingUpload = <?= intval($summary->pending_upload) ?>;
					var totalEcourt = <?= intval($summary->total_ecourt) ?>;

					// Hitung kasus yang sudah selesai
					var completedCases = Math.max(0, totalEcourt - (notRegistered + pendingPmh + pendingDecision + pendingUpload));

					console.log('Data untuk chart:', {
						not_registered: notRegistered,
						pending_pmh: pendingPmh,
						pending_decision: pendingDecision,
						pending_upload: pendingUpload,
						completed: completedCases,
						total: totalEcourt
					});

					// Jika tidak ada data, tampilkan pesan
					if (totalEcourt === 0) {
						showChartError('Tidak ada data untuk ditampilkan');
						return;
					}

					// Ambil elemen canvas
					var canvas = document.getElementById('donut-chart');
					var ctx = canvas.getContext('2d');

					// PERBAIKAN: Kita buat chart baru langsung tanpa setTimeout
					var myChart = new Chart(ctx, {
						type: 'doughnut',
						data: {
							labels: [
								'Belum Registrasi',
								'Menunggu PMH',
								'Menunggu Putusan',
								'Menunggu Upload',
								'Selesai'
							],
							datasets: [{
								data: [
									notRegistered,
									pendingPmh,
									pendingDecision,
									pendingUpload,
									completedCases
								],
								backgroundColor: ['#f56954', '#f39c12', '#00c0ef', '#00a65a', '#3c8dbc'],
								borderWidth: 1
							}]
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							legend: {
								position: 'right',
								labels: {
									fontColor: '#fff',
									boxWidth: 15,
									padding: 10
								}
							}
						}
					});

					// Sembunyikan loading
					$('#chart-loading').hide();
					console.log('Chart berhasil dibuat!');

				} catch (error) {
					// Tampilkan pesan error dengan jelas
					console.error('Error saat membuat chart:', error);
					showChartError('Gagal membuat chart: ' + error.message);
				}
			}

			// PERBAIKAN: Cek apakah Chart.js tersedia
			if (typeof Chart === 'undefined') {
				console.error('Chart.js belum dimuat!');
				$.getScript('https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js', function() {
					console.log('Chart.js berhasil dimuat dari CDN');
					createDonutChart();
				}).fail(function() {
					showChartError('Gagal memuat Chart.js. Periksa koneksi internet Anda');
				});
			} else {
				// Jalankan pembuatan chart setelah halaman dimuat penuh
				$(document).ready(function() {
					createDonutChart();
				});
			}
		});
	</script>
</body>