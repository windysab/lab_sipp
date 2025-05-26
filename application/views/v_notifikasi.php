<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-bell mr-2"></i> Notifikasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('Admin/Dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Notifikasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-gavel mr-1"></i>
                        Perkara yang Diputus Hari Ini
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($perkara_putus_today)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 50px;">No</th>
                                        <th>Nomor Perkara</th>
                                        <th>Jenis Perkara</th>
                                        <th>Status Putusan</th>
                                        <th>Tanggal Putusan</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($perkara_putus_today as $perkara): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><span class="badge badge-primary"><?= $perkara->nomor_perkara ?></span></td>
                                            <td><?= $perkara->jenis_perkara_nama ?></td>
                                            <td>
                                                <span class="badge badge-success">
                                                    <?= $perkara->status_putusan_nama ?? 'PUTUS' ?>
                                                </span>
                                            </td>
                                            <td><?= date('d-m-Y', strtotime($perkara->tanggal_putusan)) ?></td>
                                            <td>
                                                <a href="<?= site_url('perkara/detail/' . $perkara->perkara_id) ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Informasi</h5>
                            Tidak ada perkara yang diputus hari ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>