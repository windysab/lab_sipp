<!DOCTYPE html>
<html>
<head>
    <title>Detail Penyerahan Akta Cerai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .container {
            max-width: 1200px;
        }
        .page-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
            border-left: 5px solid #3498db;
            padding-left: 15px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.12);
        }
        .card-header {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 18px 20px;
            border: none;
        }
        .info-section {
            margin-bottom: 25px;
            padding: 25px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .info-section:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .info-section h3 {
            color: #3a7bd5;
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f2f5;
            position: relative;
        }
        .info-section h3:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 80px;
            height: 2px;
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }
        .info-row {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            width: 200px;
            color: #555;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 13px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            border: none;
        }
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }
        .btn-info {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border: none;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
            border: none;
            color: white;
        }
        .btn-secondary {
            background: linear-gradient(135deg, #8e9eab 0%, #eef2f3 100%);
            color: #333;
            border: none;
        }
        .alert {
            border-radius: 15px;
            padding: 15px 20px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .badge-danger {
            background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
        }
        .badge-warning {
            background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
            color: white;
        }
        .badge-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .action-section {
            margin-top: 25px;
            padding: 25px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .timeline {
            position: relative;
            padding-left: 40px;
            margin-top: 25px;
        }
        .timeline:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, #3a7bd5 0%, #00d2ff 100%);
            border-radius: 3px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -40px;
            top: 0;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #3a7bd5;
            z-index: 1;
        }
        .timeline-item.completed:before {
            background: #38ef7d;
            border-color: #11998e;
        }
        .timeline-item.pending:before {
            background: #f46b45;
            border-color: #ef473a;
        }
        .timeline-date {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .timeline-content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .timeline-content:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .timeline-content strong {
            display: block;
            margin-bottom: 8px;
            color: #3a7bd5;
        }
        .pihak-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }
        .pihak-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .pihak-card .card-header {
            padding: 15px 20px;
            font-weight: 600;
        }
        .pihak-card .card-body {
            padding: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 999;
        }
        .print-btn:hover {
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .print-btn i {
            font-size: 24px;
        }
        @media print {
            .print-btn, .action-section {
                display: none;
            }
            body {
                background-color: #fff;
            }
            .card, .info-section {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <div class="page-title">
            <i class="fas fa-file-alt mr-2"></i> Detail Penyerahan Akta Cerai
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-alt mr-2"></i> Informasi Penyerahan Akta Cerai
                    </div>
                    <a href="<?= base_url('penyerahan_ac') ?>" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
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
                
                <div class="info-section">
                    <h3><i class="fas fa-gavel mr-2"></i> Informasi Perkara</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-hashtag mr-2"></i>Nomor Perkara:</span>
                                <span class="info-value font-weight-bold"><?= $perkara->nomor_perkara ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-balance-scale mr-2"></i>Jenis Perkara:</span>
                                <span class="info-value"><?= $perkara->jenis_perkara_nama ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-calendar-plus mr-2"></i>Tanggal Daftar:</span>
                                <span class="info-value"><?= date('d-m-Y', strtotime($perkara->tanggal_pendaftaran)) ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-gavel mr-2"></i>Tanggal Putusan:</span>
                                <span class="info-value"><?= date('d-m-Y', strtotime($perkara->tanggal_putusan)) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-info-circle mr-2"></i>Status Perkara:</span>
                                <span class="info-value">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle mr-1"></i> <?= $perkara->status_perkara_text ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3><i class="fas fa-users mr-2"></i> Informasi Para Pihak</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card pihak-card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-user mr-2"></i> Pihak Pertama (Penggugat/Pemohon)
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label"><i class="fas fa-user mr-2"></i>Nama:</span>
                                        <span class="info-value font-weight-bold"><?= $pihak1->nama ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label"><i class="fas fa-map-marker-alt mr-2"></i>Alamat:</span>
                                        <span class="info-value"><?= $pihak1->alamat ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card pihak-card mb-3">
                                <div class="card-header bg-info text-white">
                                    <i class="fas fa-user mr-2"></i> Pihak Kedua (Tergugat/Termohon)
                                </div>
                                <div class="card-body">
                                    <div class="info-row">
                                        <span class="info-label"><i class="fas fa-user mr-2"></i>Nama:</span>
                                        <span class="info-value font-weight-bold"><?= $pihak2->nama ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label"><i class="fas fa-map-marker-alt mr-2"></i>Alamat:</span>
                                        <span class="info-value"><?= $pihak2->alamat ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3><i class="fas fa-file-contract mr-2"></i> Informasi Akta Cerai</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-hashtag mr-2"></i>Nomor Akta Cerai:</span>
                                <span class="info-value font-weight-bold"><?= $akta_cerai->nomor_akta_cerai ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-calendar-alt mr-2"></i>Tanggal Akta Cerai:</span>
                                <span class="info-value"><?= date('d-m-Y', strtotime($akta_cerai->tgl_akta_cerai)) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-barcode mr-2"></i>No. Seri Akta Cerai:</span>
                                <span class="info-value"><?= $akta_cerai->no_seri_akta_cerai ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-tag mr-2"></i>Jenis Cerai:</span>
                                <span class="info-value"><?= $akta_cerai->jenis_cerai ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-exclamation-circle mr-2"></i>Faktor Perceraian:</span>
                                <span class="info-value"><?= $akta_cerai->faktor_perceraian_text ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-clipboard-check mr-2"></i>Status Penyerahan:</span>
                                <span class="info-value">
                                    <?php if ($akta_cerai->tgl_penyerahan_akta_cerai): ?>
                                        <div class="status-badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i> Sudah Diserahkan
                                        </div>
                                        <div class="mt-2">
                                            <i class="fas fa-calendar-check mr-1"></i> Tanggal: <?= date('d-m-Y', strtotime($akta_cerai->tgl_penyerahan_akta_cerai)) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="status-badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i> Belum Diserahkan
                                        </div>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3><i class="fas fa-history mr-2"></i> Timeline Perkara</h3>
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-date">
                                <i class="fas fa-calendar-day mr-1"></i> <?= date('d-m-Y', strtotime($perkara->tanggal_pendaftaran)) ?>
                            </div>
                            <div class="timeline-content">
                                <strong><i class="fas fa-file-alt mr-2"></i> Pendaftaran Perkara</strong>
                                <p>Perkara didaftarkan dengan nomor <?= $perkara->nomor_perkara ?></p>
                            </div>
                        </div>
                        
                        <div class="timeline-item completed">
                            <div class="timeline-date">
                                <i class="fas fa-calendar-day mr-1"></i> <?= date('d-m-Y', strtotime($perkara->tanggal_putusan)) ?>
                            </div>
                            <div class="timeline-content">
                                <strong><i class="fas fa-gavel mr-2"></i> Putusan Perkara</strong>
                                <p>Perkara diputus oleh Majelis Hakim</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item completed">
                            <div class="timeline-date">
                                <i class="fas fa-calendar-day mr-1"></i> <?= date('d-m-Y', strtotime($akta_cerai->tgl_akta_cerai)) ?>
                            </div>
                            <div class="timeline-content">
                                <strong><i class="fas fa-file-contract mr-2"></i> Penerbitan Akta Cerai</strong>
                                <p>Akta Cerai diterbitkan dengan nomor <?= $akta_cerai->nomor_akta_cerai ?></p>
                            </div>
                        </div>
                        
                        <?php if ($akta_cerai->tgl_penyerahan_akta_cerai): ?>
                            <div class="timeline-item completed">
                                <div class="timeline-date">
                                    <i class="fas fa-calendar-day mr-1"></i> <?= date('d-m-Y', strtotime($akta_cerai->tgl_penyerahan_akta_cerai)) ?>
                                </div>
                                <div class="timeline-content">
                                    <strong><i class="fas fa-hand-holding-heart mr-2"></i> Penyerahan Akta Cerai</strong>
                                    <p>Akta Cerai telah diserahkan kepada pihak</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="timeline-item pending">
                                <div class="timeline-date">
                                    <i class="fas fa-calendar-times mr-1"></i> Belum dilaksanakan
                                </div>
                                <div class="timeline-content">
                                    <strong><i class="fas fa-hand-holding-heart mr-2"></i> Penyerahan Akta Cerai</strong>
                                    <p>Akta Cerai belum diserahkan kepada pihak</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="action-section">
                    <h3><i class="fas fa-cogs mr-2"></i> Aksi</h3>
                    <div class="d-flex flex-wrap">
                        <a href="<?= base_url('penyerahan_ac') ?>" class="btn btn-secondary mr-3 mb-2">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        
                        <?php if (!$akta_cerai->tgl_penyerahan_akta_cerai): ?>
                            <a href="<?= base_url('penyerahan_ac/update_penyerahan/'.$perkara->perkara_id) ?>" class="btn btn-success mr-3 mb-2">
                                <i class="fas fa-check-circle mr-1"></i> Tandai Sudah Diserahkan
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?= base_url('penyerahan_ac/print/'.$perkara->perkara_id) ?>" class="btn btn-info mr-3 mb-2" target="_blank">
                            <i class="fas fa-print mr-1"></i> Cetak Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <a href="<?= base_url('penyerahan_ac/print/'.$perkara->perkara_id) ?>" class="print-btn" title="Cetak Detail" target="_blank">
        <i class="fas fa-print"></i>
    </a>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
