<!DOCTYPE html>
<html>
<head>
    <title>Sistem Penyerahan Akta Cerai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
            padding: 15px 20px;
        }
        .search-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        .btn-search {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .table thead th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .badge-status {
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
        }
        .badge-delivered {
            background-color: #28a745;
            color: white;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #212529;
        }
        .action-btn {
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            border-color: #4b6cb7;
        }
        .pagination .page-link {
            color: #4b6cb7;
        }
        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .stats-card-blue {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        }
        .stats-card-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stats-card-orange {
            background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
        }
        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 600;
        }
        .stats-title {
            font-size: 1rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Sistem Penyerahan Akta Cerai</h1>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card stats-card-blue">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number"><?= $total_akta_cerai ?></div>
                            <div class="stats-title">Total Akta Cerai</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-card-green">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number"><?= $total_diserahkan ?></div>
                            <div class="stats-title">Sudah Diserahkan</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-card-orange">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="stats-number"><?= $total_belum_diserahkan ?></div>
                            <div class="stats-title">Belum Diserahkan</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-search mr-2"></i> Pencarian Akta Cerai
            </div>
            <div class="card-body">
                <form action="<?= base_url('penyerahan_ac/search') ?>" method="get" class="row">
                    <div class="col-md-3 form-group">
                        <label>Nomor Perkara</label>
                        <input type="text" name="nomor_perkara" class="form-control" placeholder="Cth: 123/Pdt.G/2023/PA.XX">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Nomor Akta Cerai</label>
                        <input type="text" name="nomor_akta_cerai" class="form-control" placeholder="Cth: AC/2023/PA.XX/XXX">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Nama Pihak</label>
                        <input type="text" name="nama_pihak" class="form-control" placeholder="Masukkan nama pihak">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Status Penyerahan</label>
                        <select name="status_penyerahan" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="1">Sudah Diserahkan</option>
                            <option value="0">Belum Diserahkan</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tanggal Akta Cerai (Dari)</label>
                        <input type="date" name="tgl_akta_cerai_dari" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tanggal Akta Cerai (Sampai)</label>
                        <input type="date" name="tgl_akta_cerai_sampai" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-search btn-block">
                            <i class="fas fa-search mr-2"></i> Cari Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Results Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table mr-2"></i> Daftar Akta Cerai
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Perkara</th>
                                <th>Nomor Akta Cerai</th>
                                <th>Tanggal Akta Cerai</th>
                                <th>Para Pihak</th>
                                <th>Status Penyerahan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($akta_cerai)): ?>
                                <?php $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1; ?>
                                <?php foreach ($akta_cerai as $ac): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $ac->nomor_perkara ?></td>
                                        <td><?= $ac->nomor_akta_cerai ?></td>
                                        <td><?= date('d-m-Y', strtotime($ac->tgl_akta_cerai)) ?></td>
                                        <td>
                                            <strong>P:</strong> <?= isset($ac->nama_penggugat) ? $ac->nama_penggugat : 'Tidak tersedia' ?><br>
                                            <strong>T:</strong> <?= isset($ac->nama_tergugat) ? $ac->nama_tergugat : 'Tidak tersedia' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($ac->tgl_penyerahan_akta_cerai): ?>
                                                <span class="badge badge-status badge-delivered">
                                                    <i class="fas fa-check-circle mr-1"></i> Diserahkan
                                                </span>
                                                <div class="small mt-1"><?= date('d-m-Y', strtotime($ac->tgl_penyerahan_akta_cerai)) ?></div>
                                            <?php else: ?>
                                                <span class="badge badge-status badge-pending">
                                                    <i class="fas fa-clock mr-1"></i> Belum Diserahkan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('penyerahan_ac/detail/'.$ac->perkara_id) ?>" class="btn btn-info action-btn" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if (!$ac->tgl_penyerahan_akta_cerai): ?>
                                                <a href="<?= base_url('penyerahan_ac/serahkan/'.$ac->perkara_id) ?>" class="btn btn-success action-btn" title="Serahkan Akta Cerai">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('penyerahan_ac/cetak/'.$ac->perkara_id) ?>" class="btn btn-primary action-btn" title="Cetak Tanda Terima" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data yang ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    <?= $pagination ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
