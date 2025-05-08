<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIPP | Pengadilan Agama Amuntai</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Custom CSS -->
	<style>
		.navbar-green {
			background-color: #046354;
			color: white;
		}

		.navbar-green .nav-link,
		.navbar-green .nav-link i {
			color: rgba(255, 255, 255, 0.85) !important;
		}

		.navbar-green .nav-link:hover,
		.navbar-green .nav-link:hover i {
			color: #ffffff !important;
		}

		.navbar-green .form-control-navbar {
			background-color: #035045;
			border-color: #046e5d;
		}

		.main-sidebar {
			background-color: #046354;
		}

		.sidebar-dark-green .nav-sidebar>.nav-item>.nav-link.active {
			background-color: #035045;
			color: #ffffff;
		}

		.brand-image-xl {
			width: auto;
			max-height: 34px;
		}

		.user-panel img {
			height: 2.1rem;
			width: 2.1rem;
			object-fit: cover;
		}

		.nav-item .badge {
			margin-left: 5px;
		}

		.nav-sidebar .nav-header {
			color: #d0d0d0 !important;
			font-size: 0.9rem;
			padding: 0.5rem 1rem 0.5rem 1rem;
		}

		.user-panel .image {
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}

		.navbar .badge {
			font-size: 0.65rem;
		}

		.dropdown-menu-lg {
			min-width: 280px;
		}
	</style>

	<link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-green navbar-dark">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="<?php echo site_url('Admin/Dashboard') ?>" class="nav-link">
						<i class="fas fa-home mr-1"></i> Beranda
					</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">
						<i class="fas fa-question-circle mr-1"></i> Bantuan
					</a>
				</li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Search -->
				<li class="nav-item">
					<a class="nav-link" data-widget="navbar-search" href="#" role="button">
						<i class="fas fa-search"></i>
					</a>
					<div class="navbar-search-block">
						<form class="form-inline">
							<div class="input-group input-group-sm">
								<input class="form-control form-control-navbar" type="search" placeholder="Cari..." aria-label="Search">
								<div class="input-group-append">
									<button class="btn btn-navbar" type="submit">
										<i class="fas fa-search"></i>
									</button>
									<button class="btn btn-navbar" type="button" data-widget="navbar-search">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</li>

				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge">5</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">5 Notifikasi</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file-alt mr-2"></i> 3 laporan baru
							<span class="float-right text-muted text-sm">hari ini</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-calendar-check mr-2"></i> 2 sidang tertunda
							<span class="float-right text-muted text-sm">2 hari</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
					</div>
				</li>

				<!-- User Account Dropdown Menu -->
				<li class="nav-item dropdown user-menu">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" class="user-image img-circle elevation-2" alt="User Image">
						<span class="d-none d-md-inline">Admin SIPP</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<!-- User image -->
						<li class="user-header bg-primary">
							<img src="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" class="img-circle elevation-2" alt="User Image">
							<p>
								Admin SIPP - PA Amuntai
								<small>Administrator</small>
							</p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<a href="#" class="btn btn-default btn-flat">Profil</a>
							<a href="#" class="btn btn-default btn-flat float-right">Keluar</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Layar Penuh">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->
