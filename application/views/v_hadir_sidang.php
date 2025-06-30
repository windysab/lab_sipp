<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h5>Catatan Kehadiran Pihak dalam Persidangan</h5>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">#</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<form action="<?php echo base_url() ?>index.php/Hadir_sidang" method="POST">
										Laporan Bulan :
										<select name="lap_bulan" required="">
											<option value="01" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '01') ? 'selected' : ''; ?>>Januari</option>
											<option value="02" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '02') ? 'selected' : ''; ?>>Februari</option>
											<option value="03" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '03') ? 'selected' : ''; ?>>Maret</option>
											<option value="04" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '04') ? 'selected' : ''; ?>>April</option>
											<option value="05" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '05') ? 'selected' : ''; ?>>Mei</option>
											<option value="06" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '06') ? 'selected' : ''; ?>>Juni</option>
											<option value="07" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '07') ? 'selected' : ''; ?>>Juli</option>
											<option value="08" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '08') ? 'selected' : ''; ?>>Agustus</option>
											<option value="09" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '09') ? 'selected' : ''; ?>>September</option>
											<option value="10" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '10') ? 'selected' : ''; ?>>Oktober</option>
											<option value="11" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '11') ? 'selected' : ''; ?>>Nopember</option>
											<option value="12" <?php echo (isset($_POST['lap_bulan']) && $_POST['lap_bulan'] === '12') ? 'selected' : ''; ?>>Desember</option>
										</select>
										Tahun :
										<select name="lap_tahun" required="">
											<option value="2016" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2016') ? 'selected' : ''; ?>>2016</option>
											<option value="2017" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2017') ? 'selected' : ''; ?>>2017</option>
											<option value="2018" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2018') ? 'selected' : ''; ?>>2018</option>
											<option value="2019" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2019') ? 'selected' : ''; ?>>2019</option>
											<option value="2020" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2020') ? 'selected' : ''; ?>>2020</option>
											<option value="2021" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2021') ? 'selected' : ''; ?>>2021</option>
											<option value="2022" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2022') ? 'selected' : ''; ?>>2022</option>
											<option value="2023" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2023') ? 'selected' : ''; ?>>2023</option>
											<option value="2024" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2024') ? 'selected' : ''; ?>>2024</option>
											<option value="2025" <?php echo (isset($_POST['lap_tahun']) && $_POST['lap_tahun'] === '2025') ? 'selected' : ''; ?>>2025</option>
										</select>
										<input class="btn btn-primary" type="submit" name="btn" value="Tampilkan" />

								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<?php if (!empty($datafilter)): ?>
										<!-- Search Section -->
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-search"></i></span>
													</div>
													<input type="text" id="searchInput" class="form-control" placeholder="Cari nomor perkara, nama pihak, atau tanggal sidang...">
													<div class="input-group-append">
														<button class="btn btn-outline-secondary" type="button" id="clearSearch">
															<i class="fas fa-times"></i> Clear
														</button>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-filter"></i></span>
													</div>
													<select id="statusFilter" class="form-control">
														<option value="">Semua Status Kehadiran</option>
														<option value="Semua pihak">Semua pihak</option>
														<option value="Penggugat saja">Penggugat saja</option>
														<option value="Tergugat saja">Tergugat saja</option>
														<option value="Para pihak tidak hadir">Para pihak tidak hadir</option>
														<option value="Kehadiran pihak belum diisi">Kehadiran pihak belum diisi</option>
													</select>
												</div>
											</div>
										</div>

										<!-- Search Results Info -->
										<div class="row mb-2">
											<div class="col-12">
												<small class="text-muted" id="searchInfo">
													Menampilkan <span id="visibleRows"><?= count($datafilter) ?></span> dari <span id="totalRows"><?= count($datafilter) ?></span> data
												</small>
											</div>
										</div>
									<?php endif; ?>

									<table class="table table-bordered table-striped" id="example1">
										<thead>
											<tr>
												<th>Nomor</th>
												<th>Nomor Perkara</th>
												<th>Penggugat/Pemohon</th>
												<th>Tergugat/Termohon</th>
												<th>Tanggal Sidang</th>
												<th>Dihadiri oleh</th>
												<th>Panitera Pengganti</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($datafilter as $row) : ?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $row->nomor_perkara ?></td>
													<td><?php echo $row->pihak1_text ?></td>
													<td><?php echo $row->pihak2_text ?></td>
													<td><?php echo $row->tanggal_sidang ?></td>
													<td>
														<?php if ($row->dihadiri_oleh == 1): ?>
															<span class="badge badge-success">Semua pihak</span>
														<?php elseif ($row->dihadiri_oleh == 2): ?>
															<span class="badge badge-warning">Penggugat saja</span>
														<?php elseif ($row->dihadiri_oleh == 3): ?>
															<span class="badge badge-info">Tergugat saja</span>
														<?php elseif ($row->dihadiri_oleh == 4): ?>
															<span class="badge badge-danger">Para pihak tidak hadir</span>
														<?php else: ?>
															<span class="badge badge-secondary">Kehadiran pihak belum diisi</span>
														<?php endif; ?>
													</td>
													<td><?php echo $row->panitera_pengganti_text ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								</form>
							</div>
							<!-- /.card -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>
	</div>
	<!-- ./wrapper -->

	<script>
		$(document).ready(function() {
			// Initialize DataTable with search functionality
			var table = $("#example1").DataTable({
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
				"dom": '<"top"l>rt<"bottom"ip><"clear">',
				"pageLength": 25
			});

			// Custom search functionality
			$('#searchInput').on('keyup', function() {
				var searchTerm = this.value;
				table.search(searchTerm).draw();
				updateSearchInfo();
			});

			// Status filter
			$('#statusFilter').on('change', function() {
				var filterValue = this.value;
				if (filterValue === '') {
					table.column(5).search('').draw();
				} else {
					table.column(5).search(filterValue).draw();
				}
				updateSearchInfo();
			});

			// Clear search
			$('#clearSearch').on('click', function() {
				$('#searchInput').val('');
				$('#statusFilter').val('');
				table.search('').columns().search('').draw();
				updateSearchInfo();
			});

			// Update search info
			function updateSearchInfo() {
				var info = table.page.info();
				$('#visibleRows').text(info.recordsDisplay);
				$('#totalRows').text(info.recordsTotal);

				if (info.recordsDisplay === 0 && info.recordsTotal > 0) {
					$('#searchInfo').html('<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Tidak ada data yang sesuai dengan kriteria pencarian</span>');
				} else if (info.recordsDisplay < info.recordsTotal) {
					$('#searchInfo').html('Menampilkan <span class="text-primary font-weight-bold">' + info.recordsDisplay + '</span> dari <span class="font-weight-bold">' + info.recordsTotal + '</span> data (difilter)');
				} else {
					$('#searchInfo').html('Menampilkan <span class="font-weight-bold">' + info.recordsDisplay + '</span> dari <span class="font-weight-bold">' + info.recordsTotal + '</span> data');
				}
			}

			// Highlight search terms
			$('#searchInput').on('keyup', function() {
				var searchTerm = this.value.toLowerCase();

				$('#example1 tbody tr').each(function() {
					var row = $(this);
					var cells = row.find('td');

					// Remove previous highlights
					cells.each(function() {
						var cell = $(this);
						var originalText = cell.data('original-text') || cell.text();
						cell.data('original-text', originalText);
						cell.html(originalText);
					});

					// Add highlights if search term exists
					if (searchTerm.length > 0) {
						cells.each(function() {
							var cell = $(this);
							var text = cell.text();
							if (text.toLowerCase().includes(searchTerm)) {
								var highlightedText = text.replace(new RegExp('(' + searchTerm + ')', 'gi'), '<mark>$1</mark>');
								cell.html(highlightedText);
							}
						});
					}
				});
			});

			// Initialize search info
			updateSearchInfo();
		});
	</script>

</body>

</html>