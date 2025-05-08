<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<!-- Content Header -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-file-alt mr-2"></i> Penyerahan Akta Cerai</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item active">Laporan Penyerahan Akta Cerai</li>
							</ol>
						</div>
					</div>
				</div>
			</section>

			<!-- Main content -->
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
							<form action="<?php echo base_url() ?>index.php/Penyerahan_ac" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Jenis Laporan:</label>
									<div class="col-sm-10">
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="laporan_bulanan" name="jenis_laporan" value="bulanan" class="custom-control-input" <?= (!isset($_POST['jenis_laporan']) || (isset($_POST['jenis_laporan']) && $_POST['jenis_laporan'] === 'bulanan')) ? 'checked' : '' ?>>
											<label class="custom-control-label" for="laporan_bulanan">Laporan Bulanan</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="laporan_tahunan" name="jenis_laporan" value="tahunan" class="custom-control-input" <?= (isset($_POST['jenis_laporan']) && $_POST['jenis_laporan'] === 'tahunan') ? 'checked' : '' ?>>
											<label class="custom-control-label" for="laporan_tahunan">Laporan Tahunan</label>
										</div>
									</div>
								</div>
								<div class="form-group row" id="bulan_container">
									<label class="col-sm-2 col-form-label">Bulan:</label>
									<div class="col-sm-4">
										<select name="lap_bulan" class="form-control select2" id="lap_bulan">
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
												$selected = (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === $value) ? 'selected' : ((!isset($_POST['lap_bulan']) && isset($current_month) && $current_month == $value) ? 'selected' : '');
												echo "<option value=\"$value\" $selected>$label</option>";
											}
											?>
										</select>
									</div>

									<label class="col-sm-2 col-form-label">Tahun:</label>
									<div class="col-sm-4">
										<select name="lap_tahun" class="form-control select2" required="">
											<?php
											$currentYear = date('Y');
											for ($year = 2016; $year <= $currentYear + 1; $year++) {
												$selected = (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] == $year) ? 'selected' : ((!isset($_POST['lap_tahun']) && isset($current_year) && $current_year == $year) ? 'selected' : '');
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

					<?php if (isset($_POST['btn']) && !empty($datafilter)): ?>
						<!-- Stats Row -->
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?= count($datafilter) ?></h3>
										<p>Total Akta Cerai</p>
									</div>
									<div class="icon">
										<i class="fas fa-file-alt"></i>
									</div>
								</div>
							</div>

							<?php
							$cerai_talak = 0;
							$cerai_gugat = 0;
							foreach ($datafilter as $row) {
								if ($row->jenis_perkara_nama == 'Cerai Talak') {
									$cerai_talak++;
								} else if ($row->jenis_perkara_nama == 'Cerai Gugat') {
									$cerai_gugat++;
								}
							}
							?>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= $cerai_talak ?></h3>
										<p>Cerai Talak</p>
									</div>
									<div class="icon">
										<i class="fas fa-male"></i>
									</div>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3><?= $cerai_gugat ?></h3>
										<p>Cerai Gugat</p>
									</div>
									<div class="icon">
										<i class="fas fa-female"></i>
									</div>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<?php
										$belum_diambil = 0;
										foreach ($datafilter as $row) {
											if (empty($row->tgl_AC_P) || empty($row->tgl_AC_T)) {
												$belum_diambil++;
											}
										}
										?>
										<h3><?= $belum_diambil ?></h3>
										<p>Belum Diambil</p>
									</div>
									<div class="icon">
										<i class="fas fa-clock"></i>
									</div>
								</div>
							</div>
						</div>

						<!-- Main Data Card -->
						<div class="card card-success card-outline">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-table mr-1"></i>
									Data Penyerahan Akta Cerai -
									<?php if (isset($_POST['jenis_laporan']) && $_POST['jenis_laporan'] === 'tahunan'): ?>
										Tahun <?= isset($_POST['lap_tahun']) ? $_POST['lap_tahun'] : '' ?>
									<?php else: ?>
										<?= isset($months[$_POST['lap_bulan']]) ? $months[$_POST['lap_bulan']] : '' ?> <?= isset($_POST['lap_tahun']) ? $_POST['lap_tahun'] : '' ?>
									<?php endif; ?>
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
							<div class="card-body p-0">
								<div class="table-responsive">
									<table id="example1" class="table table-bordered table-striped table-hover">
										<thead class="bg-light">
											<tr>
												<th class="text-center" style="width: 3%">No</th>
												<th style="width: 12%">Nomor Perkara</th>
												<th style="width: 9%">Nomor AC</th>
												<th style="width: 9%">Tgl Putusan</th>
												<th style="width: 9%">Tgl Ikrar Talak</th>
												<th style="width: 9%">Tgl BHT</th>
												<th style="width: 15%">Nama Suami</th>
												<th style="width: 9%">Tgl Terima AC</th>
												<th style="width: 15%">Nama Istri</th>
												<th style="width: 9%">Tgl Terima AC</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($datafilter as $row): ?>
												<tr>
													<td class="text-center"><?= $no++ ?></td>
													<td>
														<span class="badge badge-primary d-block"><?= $row->nomor_perkara ?></span>
														<small class="text-muted"><?= $row->jenis_perkara_nama ?></small>
													</td>
													<td><?= $row->nomor_akta_cerai ?></td>
													<td><?= !empty($row->tanggal_putusan) ? date('d-m-Y', strtotime($row->tanggal_putusan)) : '-' ?></td>
													<td><?= !empty($row->tgl_ikrar_talak) ? date('d-m-Y', strtotime($row->tgl_ikrar_talak)) : '-' ?></td>
													<td><?= !empty($row->tanggal_bht) ? date('d-m-Y', strtotime($row->tanggal_bht)) : '-' ?></td>

													<!-- Nama Suami -->
													<td>
														<?php if ($row->jenis_perkara_nama == 'Cerai Talak'): ?>
															<div class="d-flex">
																<div class="mr-2">
																	<span class="avatar-initial rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
																		<i class="fas fa-male text-white"></i>
																	</span>
																</div>
																<div>
																	<strong><?= $row->nama_p ?></strong>
																</div>
															</div>
														<?php elseif ($row->jenis_perkara_nama == 'Cerai Gugat'): ?>
															<div class="d-flex">
																<div class="mr-2">
																	<span class="avatar-initial rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
																		<i class="fas fa-male text-white"></i>
																	</span>
																</div>
																<div>
																	<strong><?= $row->nama_t ?></strong>
																</div>
															</div>
														<?php endif; ?>
													</td>

													<!-- Tanggal Terima AC Suami -->
													<td>
														<?php if ($row->jenis_perkara_nama == 'Cerai Talak'): ?>
															<?php if (!empty($row->tgl_AC_P)): ?>
																<span class="badge badge-success">
																	<i class="fas fa-check-circle mr-1"></i>
																	<?= date('d-m-Y', strtotime($row->tgl_AC_P)) ?>
																</span>
															<?php else: ?>
																<span class="badge badge-secondary">Belum diambil</span>
															<?php endif; ?>
														<?php elseif ($row->jenis_perkara_nama == 'Cerai Gugat'): ?>
															<?php if (!empty($row->tgl_AC_T)): ?>
																<span class="badge badge-success">
																	<i class="fas fa-check-circle mr-1"></i>
																	<?= date('d-m-Y', strtotime($row->tgl_AC_T)) ?>
																</span>
															<?php else: ?>
																<span class="badge badge-secondary">Belum diambil</span>
															<?php endif; ?>
														<?php endif; ?>
													</td>

													<!-- Nama Istri -->
													<td>
														<?php if ($row->jenis_perkara_nama == 'Cerai Talak'): ?>
															<div class="d-flex">
																<div class="mr-2">
																	<span class="avatar-initial rounded-circle bg-gradient-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
																		<i class="fas fa-female text-white"></i>
																	</span>
																</div>
																<div>
																	<strong><?= $row->nama_t ?></strong>
																</div>
															</div>
														<?php elseif ($row->jenis_perkara_nama == 'Cerai Gugat'): ?>
															<div class="d-flex">
																<div class="mr-2">
																	<span class="avatar-initial rounded-circle bg-gradient-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
																		<i class="fas fa-female text-white"></i>
																	</span>
																</div>
																<div>
																	<strong><?= $row->nama_p ?></strong>
																</div>
															</div>
														<?php endif; ?>
													</td>

													<!-- Tanggal Terima AC Istri -->
													<td>
														<?php if ($row->jenis_perkara_nama == 'Cerai Talak'): ?>
															<?php if (!empty($row->tgl_AC_T)): ?>
																<span class="badge badge-success">
																	<i class="fas fa-check-circle mr-1"></i>
																	<?= date('d-m-Y', strtotime($row->tgl_AC_T)) ?>
																</span>
															<?php else: ?>
																<span class="badge badge-secondary">Belum diambil</span>
															<?php endif; ?>
														<?php elseif ($row->jenis_perkara_nama == 'Cerai Gugat'): ?>
															<?php if (!empty($row->tgl_AC_P)): ?>
																<span class="badge badge-success">
																	<i class="fas fa-check-circle mr-1"></i>
																	<?= date('d-m-Y', strtotime($row->tgl_AC_P)) ?>
																</span>
															<?php else: ?>
																<span class="badge badge-secondary">Belum diambil</span>
															<?php endif; ?>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php elseif (isset($_POST['btn']) && empty($datafilter)): ?>
						<div class="alert alert-info">
							<h5><i class="icon fas fa-info"></i> Informasi</h5>
							Tidak ada data Akta Cerai pada periode yang dipilih.
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// Initialize DataTable with export buttons
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": false,
				"dom": '<"top d-flex justify-content-between"Bf>rt<"bottom d-flex justify-content-between"lip>',
				"buttons": [{
						extend: "copy",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-copy"></i> Salin'
					},
					{
						extend: "csv",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-file-csv"></i> CSV'
					},
					{
						extend: "excel",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-file-excel"></i> Excel'
					},
					{
						extend: "pdf",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-file-pdf"></i> PDF'
					},
					{
						extend: "print",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-print"></i> Cetak'
					},
					{
						extend: "colvis",
						className: "btn-sm btn-secondary",
						text: '<i class="fas fa-columns"></i> Kolom'
					}
				],
				"language": {
					"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
					"infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
					"infoFiltered": "(disaring dari _MAX_ total data)",
					"search": "Cari:",
					"lengthMenu": "Tampilkan _MENU_ data",
					"zeroRecords": "Tidak ada data yang cocok",
					"paginate": {
						"first": "Pertama",
						"last": "Terakhir",
						"next": "Selanjutnya",
						"previous": "Sebelumnya"
					}
				}
			});

			// Handle report type toggle
			function toggleBulanField() {
				if ($("#laporan_tahunan").is(":checked")) {
					$("#bulan_container").hide();
					$("#lap_bulan").prop("required", false);
					$("#lap_bulan").prop("disabled", true);
					// Force select2 to update its state if available
					if ($.fn.select2) {
						$("#lap_bulan").select2("enable", false);
					}
				} else {
					$("#bulan_container").show();
					$("#lap_bulan").prop("required", true);
					$("#lap_bulan").prop("disabled", false);
					// Force select2 to update its state if available
					if ($.fn.select2) {
						$("#lap_bulan").select2("enable", true);
					}
				}
			}

			// Initial state - make sure this runs immediately
			toggleBulanField();

			// Listen for changes
			$("input[name='jenis_laporan']").change(function() {
				toggleBulanField();
			});

			// Ensure the function is called after page load
			setTimeout(function() {
				toggleBulanField();
			}, 100);
		});
	</script>