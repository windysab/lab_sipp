<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-file-alt mr-2"></i> Penyerahan Akta Cerai</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item active">Penyerahan Akta Cerai</li>
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
												$selected = (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === $value) ? 'selected' : ((!isset($_POST['lap_bulan']) && isset($selected_bulan) && $selected_bulan == $value) ? 'selected' : '');
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
												$selected = (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] == $year) ? 'selected' : ((!isset($_POST['lap_tahun']) && isset($selected_tahun) && $selected_tahun == $year) ? 'selected' : '');
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
					<?php if (isset($_POST['btn'])): ?>
						<!-- Statistik Card -->
						<?php if (isset($statistics) && !empty($datafilter)): ?>
							<div class="row">
								<div class="col-lg-4 col-6">
									<div class="small-box bg-info">
										<div class="inner">
											<h3><?= count($datafilter) ?></h3>
											<p>Total Penyerahan</p>
										</div>
										<div class="icon">
											<i class="fas fa-file-alt"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-6">
									<div class="small-box bg-success">
										<div class="inner">
											<h3><?= !empty($statistics->total_suami) ? $statistics->total_suami : 0 ?></h3>
											<p>Diserahkan ke Suami</p>
										</div>
										<div class="icon">
											<i class="fas fa-male"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-6">
									<div class="small-box bg-danger">
										<div class="inner">
											<h3><?= !empty($statistics->total_istri) ? $statistics->total_istri : 0 ?></h3>
											<p>Diserahkan ke Istri</p>
										</div>
										<div class="icon">
											<i class="fas fa-female"></i>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<!-- Data Card -->
						<div class="card">
							<div class="card-header bg-gradient-success">
								<h3 class="card-title">
									<i class="fas fa-list-alt mr-1"></i>
									Data Penyerahan Akta Cerai -
									<?= isset($months[$selected_bulan]) ? $months[$selected_bulan] : '' ?> <?= $selected_tahun ?>
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
											<a href="#" class="dropdown-item">
												<i class="fas fa-file-excel mr-2"></i> Excel
											</a>
											<a href="#" class="dropdown-item">
												<i class="fas fa-file-pdf mr-2"></i> PDF
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body p-0">
								<?php if (!empty($datafilter)): ?>
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped table-hover">
											<thead class="bg-light">
												<tr>
													<th class="text-center" style="width:3%">No</th>
													<th>Nomor Perkara</th>
													<th>Nomor Akta Cerai</th>
													<th>Tanggal Putus</th>
													<th>Tanggal Ikrar Talak</th>
													<th>BHT</th>
													<th>Penyerahan ke Suami</th>
													<th>Penyerahan ke Istri</th>
													<th>Nama Suami</th>
													<th>Nama Istri</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1;
												foreach ($datafilter as $row): ?>
													<tr>
														<td class="text-center"><?= $no++ ?></td>
														<td><span class="badge badge-primary d-block"><?= $row->nomor_perkara ?></span></td>
														<td><?= $row->nomor_akta_cerai ?></td>
														<td><?= $row->tanggal_putusan ?></td>
														<td><?= $row->tgl_ikrar_talak ?></td>
														<td><?= $row->tanggal_bht ?></td>
														<td>
															<?php if ($row->jenis_perkara_nama == 'Cerai Talak') {
																echo $row->tgl_AC_P;
															}
															if ($row->jenis_perkara_nama == 'Cerai Gugat') {
																echo $row->tgl_AC_T;
															} ?>
														</td>
														<td>
															<?php if ($row->jenis_perkara_nama == 'Cerai Talak') {
																echo $row->tgl_AC_T;
															}
															if ($row->jenis_perkara_nama == 'Cerai Gugat') {
																echo $row->tgl_AC_P;
															} ?>
														</td>
														<td>
															<?php if ($row->jenis_perkara_nama == 'Cerai Talak') {
																if ($row->tgl_AC_P != null) {
																	echo $row->nama_p;
																}
															}
															if ($row->jenis_perkara_nama == 'Cerai Gugat') {
																if ($row->tgl_AC_P != null) {
																	echo "";
																}
																if ($row->tgl_AC_T != null) {
																	echo $row->nama_t;
																}
															} ?>
														</td>
														<td>
															<?php if ($row->jenis_perkara_nama == 'Cerai Talak') {
																if ($row->tgl_AC_T != null) {
																	echo $row->nama_t;
																}
															}
															if ($row->jenis_perkara_nama == 'Cerai Gugat') {
																if ($row->tgl_AC_T != null) {
																	echo "";
																}
																if ($row->tgl_AC_P != null) {
																	echo $row->nama_p;
																}
															} ?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="alert alert-info m-3">
										<h5><i class="icon fas fa-info"></i> Informasi</h5>
										Tidak ada data Penyerahan Akta Cerai pada periode yang dipilih.
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables  & Plugins -->
	<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script>
		$(document).ready(function() {
			// Cegah reinitialisasi DataTable
			if (!$.fn.DataTable.isDataTable('#example1')) {
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
			}
		});
	</script>
</body>
