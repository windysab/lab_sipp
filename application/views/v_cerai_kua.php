<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-file-alt mr-2"></i> Laporan Perceraian Untuk KUA</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">Laporan</li>
								<li class="breadcrumb-item active">Perceraian KUA</li>
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
							<form action="<?php echo base_url() ?>index.php/Cerai_kua" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-1 col-form-label">Periode:</label>
									<div class="col-sm-3">
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
												$selected = (isset($lap_bulan) && $lap_bulan == $value) ? 'selected="selected"' : '';
												echo "<option value=\"$value\" $selected>$label</option>";
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="lap_tahun" class="form-control select2" required>
											<?php
											$currentYear = date('Y');
											for ($year = 2016; $year <= $currentYear + 5; $year++) {
												$selected = (isset($lap_tahun) && $lap_tahun == $year) ? 'selected="selected"' : '';
												echo "<option value=\"$year\" $selected>$year</option>";
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<button type="submit" name="btn" value="search" class="btn btn-primary btn-block">
											<i class="fas fa-search mr-2"></i> Tampilkan
										</button>
									</div>
									<?php if (!empty($datafilter)): ?>
										<div class="col-sm-4">
											<div class="btn-group float-right">
												<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<i class="fas fa-download mr-1"></i> Export
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item export-excel" href="#">
														<i class="fas fa-file-excel mr-2 text-success"></i> Excel
													</a>
													<a class="dropdown-item export-pdf" href="#">
														<i class="fas fa-file-pdf mr-2 text-danger"></i> PDF
													</a>
													<a class="dropdown-item print-data" href="#">
														<i class="fas fa-print mr-2 text-primary"></i> Print
													</a>
												</div>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</form>
						</div>
					</div>

					<?php if (isset($lap_bulan) && isset($lap_tahun)): ?>
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-info"></i> Informasi</h5>
							Menampilkan data perceraian untuk bulan <strong><?= $nama_bulan[$lap_bulan] ?></strong> tahun <strong><?= $lap_tahun ?></strong>
						</div>
					<?php endif; ?>

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
										Periode: <?= $nama_bulan[$lap_bulan] ?> <?= $lap_tahun ?>
										<i class="fas fa-calendar-alt mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= isset($stats->total_kua) ? $stats->total_kua : '0' ?></h3>
										<p>Total KUA</p>
									</div>
									<div class="icon">
										<i class="fas fa-mosque"></i>
									</div>
									<a href="#" class="small-box-footer">
										Tercatat dalam database
										<i class="fas fa-info-circle mx-1"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-6 col-12">
								<div class="info-box bg-gradient-warning">
									<span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Data Untuk Laporan F.16 (KMA No. 42 Tahun 2006)</span>
										<span class="info-box-number">Laporan Bulanan Perkara Perceraian</span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
											<i class="fas fa-info-circle"></i> Data siap untuk dikirim ke KUA
										</span>
									</div>
								</div>
							</div>
						</div>

						<!-- Main Data Card -->
						<div class="card card-outline card-primary">
							<div class="card-header bg-light">
								<h3 class="card-title">
									<i class="fas fa-table mr-1"></i> Data Perceraian <?= $nama_bulan[$lap_bulan] ?> <?= $lap_tahun ?>
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
									<table id="dataTable" class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th class="text-center" width="3%">No</th>
												<th width="12%">Nomor Perkara</th>
												<th width="9%">Tgl Akta Cerai</th>
												<th width="10%">Nomor Akta Cerai</th>
												<th width="16%">Penggugat/Pemohon</th>
												<th width="16%">Alamat Penggugat</th>
												<th width="16%">Tergugat/Termohon</th>
												<th width="16%">Alamat Tergugat</th>
												<th width="10%">KUA Tempat Menikah</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($datafilter as $row): ?>
												<tr>
													<td class="text-center"><?= $no++ ?></td>
													<td><?= $row->nomor_perkara ?></td>
													<td><?= date('d-m-Y', strtotime($row->tgl_akta_cerai)) ?></td>
													<td><?= $row->nomor_akta_cerai ?></td>
													<td>
														<strong><?= $row->nama_p ?></strong>
													</td>
													<td><?= $row->alamat_p ?></td>
													<td>
														<strong><?= $row->nama_t ?></strong>
													</td>
													<td><?= $row->alamat_t ?></td>
													<td>
														<?php if (!empty($row->kua_tempat_nikah)): ?>
															<?= $row->kua_tempat_nikah ?>
														<?php else: ?>
															<span class="badge badge-secondary">Tidak ada data</span>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php else: ?>
						<!-- No Data Message -->
						<?php if (isset($lap_bulan) && isset($lap_tahun)): ?>
							<div class="alert alert-warning alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h5><i class="icon fas fa-exclamation-triangle"></i> Tidak Ada Data</h5>
								Tidak ada data perceraian pada periode yang dipilih. Silahkan pilih periode lainnya.
							</div>
						<?php else: ?>
							<div class="alert alert-info alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h5><i class="icon fas fa-info"></i> Informasi</h5>
								Silahkan pilih periode untuk menampilkan data perceraian.
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>

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
						title: 'Data Perceraian KUA - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : '' ?> <?= isset($lap_tahun) ? $lap_tahun : '' ?>',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
						}
					},
					{
						extend: 'pdf',
						text: 'PDF',
						title: 'Data Perceraian KUA - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : '' ?> <?= isset($lap_tahun) ? $lap_tahun : '' ?>',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
						},
						orientation: 'landscape'
					},
					{
						extend: 'print',
						text: 'Print',
						title: 'Data Perceraian KUA - <?= isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : '' ?> <?= isset($lap_tahun) ? $lap_tahun : '' ?>'
					}
				]
			}).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');

			// Export buttons binding
			$('.export-excel').click(function(e) {
				e.preventDefault();
				$('.buttons-excel').click();
			});

			$('.export-pdf').click(function(e) {
				e.preventDefault();
				$('.buttons-pdf').click();
			});

			$('.print-data').click(function(e) {
				e.preventDefault();
				$('.buttons-print').click();
			});
		});
	</script>
</body>

</html>