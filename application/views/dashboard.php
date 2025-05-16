<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Year Filter -->
			<div class="card card-outline card-primary mb-3">
				<div class="card-header">
					<h3 class="card-title">
						<i class="fas fa-filter mr-1"></i> Filter Tahun
					</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<form action="<?= site_url('dashboard') ?>" method="get" class="form-inline">
						<div class="form-group mr-2">
							<label class="mr-2">Pilih Tahun:</label>
							<select name="year" class="form-control">
								<?php foreach ($available_years as $yr): ?>
									<option value="<?= $yr ?>" <?= ($year == $yr) ? 'selected' : '' ?>><?= $yr ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-sync-alt mr-1"></i> Tampilkan
						</button>
					</form>
				</div>
			</div>

			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $perkara_diterima ?></h3>
							<p>Perkara Diterima</p>
						</div>
						<div class="icon">
							<i class="ion ion-bag"></i>
						</div>
						<a href="<?= site_url('masuk') ?>" class="small-box-footer">Info lengkap <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $perkara_putus ?></h3>
							<p>Perkara Putus</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="<?= site_url('putus') ?>" class="small-box-footer">Info lengkap <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $perkara_minutasi ?></h3>
							<p>Perkara Minutasi</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="#" class="small-box-footer">Info lengkap <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $perkara_sisa ?></h3>
							<p>Perkara Sisa</p>
						</div>
						<div class="icon">
							<i class="ion ion-pie-graph"></i>
						</div>
						<a href="<?= site_url('sisa_bulan_ini') ?>" class="small-box-footer">Info lengkap <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-7 connectedSortable">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-chart-line mr-1"></i>
								Statistik Perkara Tahun <?= $year ?>
							</h3>
							<div class="card-tools">
								<ul class="nav nav-pills ml-auto">
									<li class="nav-item">
										<a class="nav-link active" href="#line-chart-tab" data-toggle="tab">Line</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#pie-chart-tab" data-toggle="tab">Pie</a>
									</li>
								</ul>
							</div>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content p-0">
								<!-- Line chart -->
								<div class="chart tab-pane active" id="line-chart-tab"
									style="position: relative; height: 300px;">
									<canvas id="line-chart-canvas" height="300" style="height: 300px;"></canvas>
								</div>
								<!-- Pie chart -->
								<div class="chart tab-pane" id="pie-chart-tab" style="position: relative; height: 300px;">
									<canvas id="pie-chart-canvas" height="300" style="height: 300px;"></canvas>
								</div>
							</div>
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->

					<!-- Case Type Distribution -->
					<div class="card">
						<div class="card-header border-0">
							<h3 class="card-title">
								<i class="fas fa-balance-scale mr-1"></i>
								Distribusi Jenis Perkara
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center border-bottom mb-3">
								<p class="text-success text-xl">
									<i class="ion ion-ios-list-outline"></i>
								</p>
								<p class="d-flex flex-column text-right">
									<span class="font-weight-bold">
										<i class="ion ion-android-arrow-up text-success"></i> <?= $perkara_diterima ?>
									</span>
									<span class="text-muted">TOTAL PERKARA DITERIMA</span>
								</p>
							</div>
							<!-- /.d-flex -->

							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Jenis Perkara</th>
											<th class="text-center">Jumlah</th>
											<th class="text-center">Persentase</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($case_types as $case): ?>
											<tr>
												<td><?= $case->jenis_perkara_nama ?></td>
												<td class="text-center"><?= $case->count ?></td>
												<td class="text-center">
													<?= round(($case->count / $perkara_diterima * 100), 1) ?>%
													<div class="progress progress-xs">
														<div class="progress-bar bg-primary" style="width: <?= ($case->count / $perkara_diterima * 100) ?>%"></div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- /.card -->

				</section>
				<!-- /.Left col -->

				<!-- right col (We are only adding the ID to make the widgets sortable)-->
				<section class="col-lg-5 connectedSortable">

					<!-- Performance Overview -->
					<div class="card">
						<div class="card-header border-0">
							<h3 class="card-title">
								<i class="fas fa-tachometer-alt mr-1"></i>
								Performa Putusan vs Penerimaan
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center mb-0">
								<p class="text-info text-xl">
									<i class="ion ion-ios-people"></i>
								</p>
								<p class="d-flex flex-column text-right">
									<?php
									$percentage = ($perkara_diterima > 0)
										? round(($perkara_putus / $perkara_diterima) * 100, 1)
										: 0;
									$icon = ($percentage >= 100)
										? '<i class="ion ion-android-arrow-up text-success"></i>'
										: '<i class="ion ion-android-arrow-down text-danger"></i>';
									?>
									<span class="font-weight-bold">
										<?= $icon ?> <?= $percentage ?>%
									</span>
									<span class="text-muted">RASIO PUTUS / TERIMA</span>
								</p>
							</div>

							<div class="progress-group mt-4">
								<span class="progress-text">Perkara Putus / Perkara Terima</span>
								<span class="float-right"><?= $perkara_putus ?> / <?= $perkara_diterima ?></span>
								<div class="progress progress-sm">
									<div class="progress-bar bg-primary" style="width: <?= min($percentage, 100) ?>%"></div>
								</div>
							</div>

							<div class="progress-group mt-4">
								<span class="progress-text">Perkara Minutasi / Perkara Putus</span>
								<?php
								$minutasi_percentage = ($perkara_putus > 0)
									? round(($perkara_minutasi / $perkara_putus) * 100, 1)
									: 0;
								?>
								<span class="float-right"><?= $perkara_minutasi ?> / <?= $perkara_putus ?></span>
								<div class="progress progress-sm">
									<div class="progress-bar bg-success" style="width: <?= min($minutasi_percentage, 100) ?>%"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card -->

					<!-- Reminder Card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="far fa-calendar-alt mr-1"></i>
								Pengingat
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body p-0">
							<div id="calendar" style="width: 100%;"></div>
						</div>
					</div>
					<!-- /.card -->

				</section>
				<!-- right col -->
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Page specific script -->
<script>
	$(function() {
		// Monthly statistics chart
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

		// Line chart
		var lineChartCanvas = $('#line-chart-canvas').get(0).getContext('2d');
		var lineChartData = {
			labels: months,
			datasets: [{
					label: 'Perkara Diterima',
					backgroundColor: 'rgba(60,141,188,0.9)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: 3,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: <?= json_encode($monthly_stats['received']) ?>
				},
				{
					label: 'Perkara Putus',
					backgroundColor: 'rgba(40,167,69,0.9)',
					borderColor: 'rgba(40,167,69,0.8)',
					pointRadius: 3,
					pointColor: '#28a745',
					pointStrokeColor: 'rgba(40,167,69,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(40,167,69,1)',
					data: <?= json_encode($monthly_stats['decided']) ?>
				},
				{
					label: 'Perkara Minutasi',
					backgroundColor: 'rgba(255,193,7,0.9)',
					borderColor: 'rgba(255,193,7,0.8)',
					pointRadius: 3,
					pointColor: '#ffc107',
					pointStrokeColor: 'rgba(255,193,7,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(255,193,7,1)',
					data: <?= json_encode($monthly_stats['minutasi']) ?>
				}
			]
		};

		var lineChartOptions = {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true
			},
			scales: {
				xAxes: [{
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					gridLines: {
						display: false,
					},
					ticks: {
						beginAtZero: true,
						precision: 0
					}
				}]
			}
		};

		// Create the line chart
		new Chart(lineChartCanvas, {
			type: 'line',
			data: lineChartData,
			options: lineChartOptions
		});

		// Pie chart
		var pieChartCanvas = $('#pie-chart-canvas').get(0).getContext('2d');
		var pieData = {
			labels: ['Perkara Diterima', 'Perkara Putus', 'Perkara Minutasi', 'Perkara Sisa'],
			datasets: [{
				data: [
					<?= $perkara_diterima ?>,
					<?= $perkara_putus ?>,
					<?= $perkara_minutasi ?>,
					<?= $perkara_sisa ?>
				],
				backgroundColor: ['#17a2b8', '#28a745', '#ffc107', '#dc3545']
			}]
		};

		var pieOptions = {
			maintainAspectRatio: false,
			responsive: true
		};

		// Create the pie chart
		new Chart(pieChartCanvas, {
			type: 'pie',
			data: pieData,
			options: pieOptions
		});

		// Calendar initialization
		$('#calendar').datetimepicker({
			format: 'L',
			inline: true
		});
	});
</script>
</body>

</html>