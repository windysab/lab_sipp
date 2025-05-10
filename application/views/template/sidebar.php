  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('Admin/Dashboard') ?>" class="brand-link">
      <img src="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" alt="Logo PA Amuntai" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LABORATORIUM SIPP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>assets/dist/img/picture.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Lupi Ananda, S.Kom</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="<?php echo site_url('Admin/Dashboard') ?>" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Laporan Kegiatan Hakim
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Sisa_bulan_lalu') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sisa Perkara Bulan Lalu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Masuk') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perkara Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Putus') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perkara Putus</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Sisa_bulan_ini') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sisa Perkara Bulan Ini</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Jurusita
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Persidangan') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Catatan Persidangan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Usia Pihak
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('usia_pihak_p') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penggugat/Pemohon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('usia_pihak_t') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tergugat/Termohon</p>
                </a>
              </li>
            </ul>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Data') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Uji Coba</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Important</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Warning</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Informational</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
