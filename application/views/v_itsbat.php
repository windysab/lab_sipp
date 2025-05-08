<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><i class="fas fa-certificate mr-2"></i> Itsbat Nikah</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
								<li class="breadcrumb-item">Permohonan</li>
								<li class="breadcrumb-item active">Itsbat Nikah</li>
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
						</div>
						<div class="card-body">
							<form action="<?php echo base_url() ?>index.php/Itsbat" method="POST" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Laporan Bulan:</label>
									<div class="col-sm-4">
										<select name="lap_bulan" class="form-control select2" required="">
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
												$selected = (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === $value) ? 'selected' : '';
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
												$selected = (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] == $year)
													? 'selected'
													: ($year == $currentYear && !isset($_POST['lap_tahun']) ? 'selected' : '');
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
						<!-- Data Card -->
						<div class="card">
							<div class="card-header bg-success">
								<h3 class="card-title">
									<i class="fas fa-certificate mr-1"></i>
									Data Itsbat Nikah -
									<?php
									echo isset($months[$_POST['lap_bulan']]) ? $months[$_POST['lap_bulan']] : '';
									echo " ";
									echo isset($_POST['lap_tahun']) ? $_POST['lap_tahun'] : '';
									?>
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
								<?php if (!empty($datafilter)): ?>
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped table-hover">
											<thead class="bg-info">
												<tr>
													<th width="3%" class="text-center">No</th>
													<th width="12%">Nomor Perkara</th>
													<th width="10%">Tanggal Daftar</th>
													<th width="10%">Tanggal Putus</th>
													<th width="10%">Status Putusan</th>
													<th width="8%">Tahun Nikah</th>
													<th width="10%">Pemohon I</th>
													<th width="9%">Usia I</th>
													<th width="10%">Pemohon II</th>
													<th width="9%">Usia II</th>
													<th width="9%">Durasi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($datafilter as $row):
													// Calculate marriage duration
													$marriageYear = null;
													$duration = null;
													if (!empty($row->tahun_nikah)) {
														preg_match('/\b(19|20)\d{2}\b/', $row->tahun_nikah, $matches);
														if (!empty($matches[0])) {
															$marriageYear = (int)$matches[0];
															$currentYear = date('Y');
															$duration = $currentYear - $marriageYear;
														}
													}
												?>
													<tr>
														<td class="text-center"><?= $no++ ?></td>
														<td>
															<span class="badge badge-primary"><?= $row->nomor_perkara ?></span>
														</td>
														<td><?= date('d-m-Y', strtotime($row->tanggal_pendaftaran)) ?></td>
														<td><?= !empty($row->tanggal_putusan) ? date('d-m-Y', strtotime($row->tanggal_putusan)) : '-' ?></td>
														<td>
															<?php if (!empty($row->jenis_putusan)): ?>
																<span class="badge badge-success"><?= $row->jenis_putusan ?></span>
															<?php else: ?>
																<span class="badge badge-warning">Belum Putus</span>
															<?php endif; ?>
														</td>
														<td>
															<?php
															if (!empty($marriageYear)) {
																echo "<span class='badge badge-info'>$marriageYear</span>";
															} else {
																echo '-';
															}
															?>
														</td>
														<td>
															<strong><?= $row->nama_p1 ?></strong>
															<?php if (!empty($row->tanggal_lahir_p1)): ?>
																<div class="small text-muted">
																	<?= date('d-m-Y', strtotime($row->tanggal_lahir_p1)) ?>
																</div>
															<?php endif; ?>
														</td>
														<td class="text-center">
															<span class="badge badge-secondary">
																<?= $row->usia_p1 ?> tahun
															</span>
														</td>
														<td>
															<strong><?= $row->nama_p2 ?></strong>
															<?php if (!empty($row->tanggal_lahir_p2)): ?>
																<div class="small text-muted">
																	<?= date('d-m-Y', strtotime($row->tanggal_lahir_p2)) ?>
																</div>
															<?php endif; ?>
														</td>
														<td class="text-center">
															<span class="badge badge-secondary">
																<?= $row->usia_p2 ?> tahun
															</span>
														</td>
														<td class="text-center">
															<?php if (!empty($duration)): ?>
																<span class="badge badge-dark">
																	<?= $duration ?> tahun
																</span>
															<?php else: ?>
																-
															<?php endif; ?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="alert alert-info">
										<h5><i class="icon fas fa-info"></i> Informasi</h5>
										Tidak ada data Itsbat Nikah pada periode yang dipilih.
									</div>
								<?php endif; ?>
							</div>

							<?php if (!empty($datafilter)): ?>
								<div class="card-footer">
									<div class="row">
										<div class="col-md-4">
											<div class="info-box bg-light">
												<div class="info-box-content">
													<span class="info-box-text text-center text-muted">Total Perkara</span>
													<span class="info-box-number text-center text-muted mb-0"><?= count($datafilter) ?></span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="info-box bg-light">
												<div class="info-box-content">
													<span class="info-box-text text-center text-muted">Rata-rata Usia Pemohon I</span>
													<span class="info-box-number text-center text-muted mb-0">
														<?php
														$totalUsia = 0;
														foreach ($datafilter as $row) {
															$totalUsia += $row->usia_p1;
														}
														echo round($totalUsia / count($datafilter), 1) . ' tahun';
														?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="info-box bg-light">
												<div class="info-box-content">
													<span class="info-box-text text-center text-muted">Rata-rata Usia Pemohon II</span>
													<span class="info-box-number text-center text-muted mb-0">
														<?php
														$totalUsia = 0;
														foreach ($datafilter as $row) {
															$totalUsia += $row->usia_p2;
														}
														echo round($totalUsia / count($datafilter), 1) . ' tahun';
														?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
	<!-- ./wrapper -->




	<!-- Page specific script -->
	<!-- <script>
  $(function () {
    $("#DataTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#DataTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script> 
 -->
</body>

</html>
