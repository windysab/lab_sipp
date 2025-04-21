  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('Admin/Dashboard') ?>" class="brand-link">
      <img src="<?php echo base_url() ?>assets/dist/img/logo-mahkamah-agung.png" alt="Logo PA Amuntai" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LABORATORIUM SIPP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">PA Amuntai</a>
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
                Ket. Keadaan Perkara
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('PNS') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PNS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Ghaib') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ghaib</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Prodeo') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prodeo</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Permohonan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Itsbat') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Itsbat Nikah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Diska') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dispensasi Kawin</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Gugatan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Penyerahan_ac') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penyerahan Akta Cerai</p>
                </a>
              </li>
            </ul>
       
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Usia_cerai') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lap. Usia Perceraian</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Cerai_kua') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lap. Perceraian KUA</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Reg_salput') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register Salput ke KUA</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                E-Court
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Ecourt') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perkara E-Court</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Rekap_ecourt') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rekap E-Court</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Catatan Persidangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Persidangan') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurusita</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Hadir_sidang') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kehadiran Pihak</p>
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
          </li>
        </ul>
      </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                One Day
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Odm') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>One Day Minut</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Odp') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>One Day Publish</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Penelitian</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Grafik') ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Grafik Uji Coba</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Uji_Chart') ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Chart Uji Coba</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Data') ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Data Uji Coba</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
