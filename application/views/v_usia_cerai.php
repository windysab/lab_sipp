<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-chart-pie mr-2"></i> Laporan Usia Perceraian</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">Gugatan</li>
								<li class="breadcrumb-item active">Laporan Usia Perceraian</li>
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
							<form action="<?php echo base_url() ?>index.php/Usia_cerai" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Laporan Bulan:</label>
									<div class="col-sm-4">
										<select name="lap_bulan" class="form-control select2" required>
											<?php
											$months = [
												'01' => 'Januari',
												'02' => 'Februari',
												'03' => 'Maret',
												'04' => 'April',
												'05' => 'Mei',
												'06' => 'Juni',
												'07' => 'Juli',
												'08' => 'Agustus',
												'09' => 'September',
												'10' => 'Oktober',
												'11' => 'November',
												'12' => 'Desember'
											];
											foreach ($months as $value => $label) {
												$selected = (isset($lap_bulan) && $lap_bulan === $value) ? 'selected' : '';
												echo "<option value=\"$value\" $selected>$label</option>";
											}
											?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">Tahun:</label>
									<div class="col-sm-4">
										<select name="lap_tahun" class="form-control select2" required>
											<?php
											$currentYear = date('Y');
											for ($year = 2016; $year <= $currentYear + 1; $year++) {
												$selected = (isset($lap_tahun) && $lap_tahun == $year) ? 'selected' : '';
												echo "<option value=\"$year\" $selected>$year</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 offset-sm-8">
										<button type="submit" name="btn" class="btn btn-primary btn-block">
											<i class="fas fa-search mr-2"></i> Tampilkan Data
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<?php if (!empty($datafilter)): ?>
						<!-- Statistics Cards -->
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?= count($datafilter) ?></h3>
										<p>Total Perceraian</p>
									</div>
									<div class="icon">
										<i class="fas fa-gavel"></i>
									</div>
									<a href="#" class="small-box-footer">
										<?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : '' ?> <?= isset($lap_tahun) ? $lap_tahun : '' ?>
										<i class="fas fa-calendar-alt mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= isset($stats->avg_usia_p) ? round($stats->avg_usia_p, 1) : '-' ?></h3>
										<p>Rata-rata Usia Penggugat</p>
									</div>
									<div class="icon">
										<i class="fas fa-user"></i>
									</div>
									<a href="#" class="small-box-footer">
										Min: <?= isset($stats->min_usia_p) ? $stats->min_usia_p : '-' ?> |
										Max: <?= isset($stats->max_usia_p) ? $stats->max_usia_p : '-' ?>
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3><?= isset($stats->avg_usia_t) ? round($stats->avg_usia_t, 1) : '-' ?></h3>
										<p>Rata-rata Usia Tergugat</p>
									</div>
									<div class="icon">
										<i class="fas fa-user-friends"></i>
									</div>
									<a href="#" class="small-box-footer">
										Min: <?= isset($stats->min_usia_t) ? $stats->min_usia_t : '-' ?> |
										Max: <?= isset($stats->max_usia_t) ? $stats->max_usia_t : '-' ?>
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3><?= isset($stats->avg_lama_nikah) ? round($stats->avg_lama_nikah, 1) : '-' ?></h3>
										<p>Rata-rata Lama Pernikahan</p>
									</div>
									<div class="icon">
										<i class="fas fa-heart-broken"></i>
									</div>
									<a href="#" class="small-box-footer">
										Max: <?= isset($stats->max_lama_nikah) ? $stats->max_lama_nikah : '-' ?> tahun
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>
						</div>

						<!-- Charts Row -->
						<div class="row">
							<!-- Age Distribution Chart -->
							<div class="col-md-6">
								<div class="card card-primary">
									<div class="card-header">
										<h3 class="card-title">
											<i class="fas fa-chart-bar mr-1"></i>
											Distribusi Usia
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Rentang Usia</th>
														<th class="text-center">Penggugat/Pemohon</th>
														<th class="text-center">Tergugat/Termohon</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Di bawah 20 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->p_usia_dibawah_20) ? $usia_ranges->p_usia_dibawah_20 : 0 ?></td>
														<td class="text-center"><?= isset($usia_ranges->t_usia_dibawah_20) ? $usia_ranges->t_usia_dibawah_20 : 0 ?></td>
													</tr>
													<tr>
														<td>20 - 30 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->p_usia_20_30) ? $usia_ranges->p_usia_20_30 : 0 ?></td>
														<td class="text-center"><?= isset($usia_ranges->t_usia_20_30) ? $usia_ranges->t_usia_20_30 : 0 ?></td>
													</tr>
													<tr>
														<td>31 - 40 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->p_usia_31_40) ? $usia_ranges->p_usia_31_40 : 0 ?></td>
														<td class="text-center"><?= isset($usia_ranges->t_usia_31_40) ? $usia_ranges->t_usia_31_40 : 0 ?></td>
													</tr>
													<tr>
														<td>41 - 50 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->p_usia_41_50) ? $usia_ranges->p_usia_41_50 : 0 ?></td>
														<td class="text-center"><?= isset($usia_ranges->t_usia_41_50) ? $usia_ranges->t_usia_41_50 : 0 ?></td>
													</tr>
													<tr>
														<td>Di atas 50 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->p_usia_diatas_50) ? $usia_ranges->p_usia_diatas_50 : 0 ?></td>
														<td class="text-center"><?= isset($usia_ranges->t_usia_diatas_50) ? $usia_ranges->t_usia_diatas_50 : 0 ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div id="ageDistributionChart" style="height: 250px; margin-top: 15px;"></div>
									</div>
								</div>
							</div>

							<!-- Marriage Duration Chart -->
							<div class="col-md-6">
								<div class="card card-success">
									<div class="card-header">
										<h3 class="card-title">
											<i class="fas fa-chart-pie mr-1"></i>
											Durasi Pernikahan
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Durasi Pernikahan</th>
														<th class="text-center">Jumlah</th>
														<th class="text-center">Persentase</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$total_with_marriage_data =
														(isset($usia_ranges->nikah_kurang_1_tahun) ? $usia_ranges->nikah_kurang_1_tahun : 0) +
														(isset($usia_ranges->nikah_1_5_tahun) ? $usia_ranges->nikah_1_5_tahun : 0) +
														(isset($usia_ranges->nikah_6_10_tahun) ? $usia_ranges->nikah_6_10_tahun : 0) +
														(isset($usia_ranges->nikah_lebih_10_tahun) ? $usia_ranges->nikah_lebih_10_tahun : 0);
													?>
													<tr>
														<td>Kurang dari 1 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->nikah_kurang_1_tahun) ? $usia_ranges->nikah_kurang_1_tahun : 0 ?></td>
														<td class="text-center">
															<?= $total_with_marriage_data ? round(($usia_ranges->nikah_kurang_1_tahun / $total_with_marriage_data) * 100, 1) . '%' : '-' ?>
														</td>
													</tr>
													<tr>
														<td>1 - 5 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->nikah_1_5_tahun) ? $usia_ranges->nikah_1_5_tahun : 0 ?></td>
														<td class="text-center">
															<?= $total_with_marriage_data ? round(($usia_ranges->nikah_1_5_tahun / $total_with_marriage_data) * 100, 1) . '%' : '-' ?>
														</td>
													</tr>
													<tr>
														<td>6 - 10 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->nikah_6_10_tahun) ? $usia_ranges->nikah_6_10_tahun : 0 ?></td>
														<td class="text-center">
															<?= $total_with_marriage_data ? round(($usia_ranges->nikah_6_10_tahun / $total_with_marriage_data) * 100, 1) . '%' : '-' ?>
														</td>
													</tr>
													<tr>
														<td>Lebih dari 10 tahun</td>
														<td class="text-center"><?= isset($usia_ranges->nikah_lebih_10_tahun) ? $usia_ranges->nikah_lebih_10_tahun : 0 ?></td>
														<td class="text-center">
															<?= $total_with_marriage_data ? round(($usia_ranges->nikah_lebih_10_tahun / $total_with_marriage_data) * 100, 1) . '%' : '-' ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div id="marriageDurationChart" style="height: 250px; margin-top: 15px;"></div>
									</div>
								</div>
							</div>
						</div>

						<!-- Additional Statistics Cards -->
						<div class="row">
							<div class="col-md-6">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title">
											<i class="fas fa-balance-scale mr-1"></i>
											Jenis Perkara Perceraian
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body p-0">
										<div class="row">
											<div class="col-md-8">
												<div id="divorceTypeChart" style="height: 250px;"></div>
											</div>
											<div class="col-md-4">
												<ul class="list-group list-group-flush">
													<li class="list-group-item d-flex justify-content-between align-items-center">
														Cerai Talak
														<span class="badge badge-primary badge-pill"><?= isset($stats->total_cerai_talak) ? $stats->total_cerai_talak : 0 ?></span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center">
														Cerai Gugat
														<span class="badge badge-info badge-pill"><?= isset($stats->total_cerai_gugat) ? $stats->total_cerai_gugat : 0 ?></span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center">
														Total
														<span class="badge badge-dark badge-pill"><?= count($datafilter) ?></span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title">
											<i class="fas fa-comments mr-1"></i>
											Faktor Penyebab Perceraian
										</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body p-0">
										<table class="table table-striped mb-0">
											<thead>
												<tr>
													<th>Faktor</th>
													<th class="text-center">Jumlah</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (!empty($stats->faktor_perceraian)) {
													$factors = explode('|', $stats->faktor_perceraian);
													foreach ($factors as $factor) {
														$parts = explode(':', $factor);
														if (count($parts) == 2 && !empty($parts[0])) {
															$name = $parts[0];
															$count = $parts[1];
															echo "<tr>
																<td>$name</td>
																<td class='text-center'>$count</td>
															</tr>";
														}
													}
													// If no factors were found
													if (empty($factors[0])) {
														echo "<tr><td colspan='2' class='text-center'>Tidak ada data</td></tr>";
													}
												} else {
													echo "<tr><td colspan='2' class='text-center'>Tidak ada data</td></tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<!-- Main Data Card -->
						<div class="card card-outline card-primary">
							<div class="card-header bg-light">
								<h3 class="card-title">
									<i class="fas fa-table mr-1"></i>
									Data Perceraian <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : '' ?> <?= isset($lap_tahun) ? $lap_tahun : '' ?>
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
												<th class="text-center" width="3%">No</th>
												<th width="11%">Nomor Perkara</th>
												<th width="9%">Tanggal Daftar</th>
												<th width="8%">Tanggal Putus</th>
												<th width="15%">Penggugat/Pemohon</th>
												<th width="7%">Usia P</th>
												<th width="15%">Tergugat/Termohon</th>
												<th width="7%">Usia T</th>
												<th width="10%">Lama Nikah</th>
												<th width="15%">Faktor Perceraian</th>
											</tr>
										</thead>
										<tbody>
											<?php if (isset($datafilter) && !empty($datafilter)):
												$no = 1;
												foreach ($datafilter as $row): ?>
													<tr>
														<td class="text-center"><?= $no++ ?></td>
														<td><?= $row->nomor_perkara ?></td>
														<td><?= date('d-m-Y', strtotime($row->tanggal_pendaftaran)) ?></td>
														<td>
															<?php if (!empty($row->tanggal_putusan)): ?>
																<?= date('d-m-Y', strtotime($row->tanggal_putusan)) ?>
															<?php else: ?>
																-
															<?php endif; ?>
														</td>
														<td>
															<strong><?= $row->nama_p ?></strong>
															<?php if (!empty($row->tanggal_lahir_p)): ?>
																<div class="small text-muted">
																	<i class="far fa-calendar-alt"></i>
																	<?= date('d-m-Y', strtotime($row->tanggal_lahir_p)) ?>
																</div>
															<?php endif; ?>
														</td>
														<td>
															<?php if (!empty($row->usia_p)): ?>
																<span class="badge badge-info"><?= $row->usia_p ?> tahun</span>
															<?php else: ?>
																-
															<?php endif; ?>
														</td>
														<td>
															<strong><?= $row->nama_t ?></strong>
															<?php if (!empty($row->tanggal_lahir_t)): ?>
																<div class="small text-muted">
																	<i class="far fa-calendar-alt"></i>
																	<?= date('d-m-Y', strtotime($row->tanggal_lahir_t)) ?>
																</div>
															<?php endif; ?>
														</td>
														<td>
															<?php if (!empty($row->usia_t)): ?>
																<span class="badge badge-warning"><?= $row->usia_t ?> tahun</span>
															<?php else: ?>
																-
															<?php endif; ?>
														</td>
														<td>
															<?php if (!empty($row->tgl_nikah)): ?>
																<div class="text-center">
																	<span class="badge badge-success"><?= isset($row->lama_nikah) ? $row->lama_nikah : '-' ?> tahun</span>
																	<div class="small text-muted mt-1">
																		<i class="far fa-calendar-alt"></i>
																		<?= date('d-m-Y', strtotime($row->tgl_nikah)) ?>
																	</div>
																</div>
															<?php else: ?>
																<span class="text-muted text-center d-block">Tidak ada data</span>
															<?php endif; ?>
														</td>
														<td>
															<?php if (!empty($row->alasan)): ?>
																<span class="badge badge-secondary d-block"><?= $row->alasan ?></span>
																<?php if (!empty($row->jenis_cerai)): ?>
																	<small class="text-muted d-block mt-1"><?= $row->jenis_cerai ?></small>
																<?php endif; ?>
															<?php else: ?>
																<span class="text-muted">Tidak tercatat</span>
															<?php endif; ?>
														</td>
													</tr>
											<?php endforeach;
											endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php else: ?>
						<!-- No Data Message -->
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-info"></i> Informasi</h5>
							Tidak ada data perceraian pada periode yang dipilih.
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>

	<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
	<script>
		$(document).ready(function() {
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
						title: 'Laporan Usia Perceraian - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
						}
					},
					{
						extend: 'pdf',
						text: 'PDF',
						title: 'Laporan Usia Perceraian - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						orientation: 'landscape'
					},
					{
						extend: 'print',
						text: 'Print',
						title: 'Laporan Usia Perceraian - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : "" ?> <?= isset($lap_tahun) ? $lap_tahun : "" ?>'
					}
				]
			});

			// Export buttons binding
			$('.export-excel').click(function(e) {
				e.preventDefault();
				$('.buttons-excel').click();
			});

			$('.export-pdf').click(function(e) {
				e.preventDefault();
				$('.buttons-pdf').click();
			});

			<?php if (!empty($datafilter)): ?>
				// Age Distribution Chart
				if (document.getElementById('ageDistributionChart')) {
					var ageCtx = document.getElementById('ageDistributionChart').getContext('2d');
					var ageData = {
						labels: ['<20 tahun', '20-30 tahun', '31-40 tahun', '41-50 tahun', '>50 tahun'],
						datasets: [{
								label: 'Penggugat/Pemohon',
								backgroundColor: 'rgba(60, 141, 188, 0.8)',
								data: [
									<?= isset($usia_ranges->p_usia_dibawah_20) ? $usia_ranges->p_usia_dibawah_20 : 0 ?>,
									<?= isset($usia_ranges->p_usia_20_30) ? $usia_ranges->p_usia_20_30 : 0 ?>,
									<?= isset($usia_ranges->p_usia_31_40) ? $usia_ranges->p_usia_31_40 : 0 ?>,
									<?= isset($usia_ranges->p_usia_41_50) ? $usia_ranges->p_usia_41_50 : 0 ?>,
									<?= isset($usia_ranges->p_usia_diatas_50) ? $usia_ranges->p_usia_diatas_50 : 0 ?>
								]
							},
							{
								label: 'Tergugat/Termohon',
								backgroundColor: 'rgba(255, 193, 7, 0.8)',
								data: [
									<?= isset($usia_ranges->t_usia_dibawah_20) ? $usia_ranges->t_usia_dibawah_20 : 0 ?>,
									<?= isset($usia_ranges->t_usia_20_30) ? $usia_ranges->t_usia_20_30 : 0 ?>,
									<?= isset($usia_ranges->t_usia_31_40) ? $usia_ranges->t_usia_31_40 : 0 ?>,
									<?= isset($usia_ranges->t_usia_41_50) ? $usia_ranges->t_usia_41_50 : 0 ?>,
									<?= isset($usia_ranges->t_usia_diatas_50) ? $usia_ranges->t_usia_diatas_50 : 0 ?>
								]
							}
						]
					};

					new Chart(ageCtx, {
						type: 'bar',
						data: ageData,
						options: {
							responsive: true,
							maintainAspectRatio: false,
							legend: {
								position: 'top'
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										precision: 0
									}
								}]
							}
						}
					});
				}

				// Marriage Duration Chart
				if (document.getElementById('marriageDurationChart')) {
					var marriageCtx = document.getElementById('marriageDurationChart').getContext('2d');
					var marriageData = {
						labels: ['<1 tahun', '1-5 tahun', '6-10 tahun', '>10 tahun'],
						datasets: [{
							data: [
								<?= isset($usia_ranges->nikah_kurang_1_tahun) ? $usia_ranges->nikah_kurang_1_tahun : 0 ?>,
								<?= isset($usia_ranges->nikah_1_5_tahun) ? $usia_ranges->nikah_1_5_tahun : 0 ?>,
								<?= isset($usia_ranges->nikah_6_10_tahun) ? $usia_ranges->nikah_6_10_tahun : 0 ?>,
								<?= isset($usia_ranges->nikah_lebih_10_tahun) ? $usia_ranges->nikah_lebih_10_tahun : 0 ?>
							],
							backgroundColor: [
								'#f56954', // red
								'#00a65a', // green
								'#f39c12', // yellow
								'#00c0ef' // blue
							]
						}]
					};

					new Chart(marriageCtx, {
						type: 'doughnut',
						data: marriageData,
						options: {
							responsive: true,
							maintainAspectRatio: false,
							legend: {
								position: 'right'
							}
						}
					});
				}

				// Divorce Type Chart
				if (document.getElementById('divorceTypeChart')) {
					var divorceTypeCtx = document.getElementById('divorceTypeChart').getContext('2d');
					var divorceTypeData = {
						labels: ['Cerai Talak', 'Cerai Gugat'],
						datasets: [{
							data: [
								<?= isset($stats->total_cerai_talak) ? $stats->total_cerai_talak : 0 ?>,
								<?= isset($stats->total_cerai_gugat) ? $stats->total_cerai_gugat : 0 ?>
							],
							backgroundColor: ['#3c8dbc', '#00c0ef']
						}]
					};

					new Chart(divorceTypeCtx, {
						type: 'pie',
						data: divorceTypeData,
						options: {
							responsive: true,
							maintainAspectRatio: false
						}
					});
				}
			<?php endif; ?>
		});
	</script>
</body>

</html>