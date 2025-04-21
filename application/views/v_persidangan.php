<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5>Catatan Persidangan Jurusita</h5>
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
                <form action="<?php echo base_url()?>index.php/Persidangan" method="POST" >
                    <?php
                    if(isset($_POST['btn'])) 
                    {
                        $tanggal_sidang=$_POST['tanggal_sidang']; 
                    }
                    ?> 

                Jurusita : 
                <select name="jurusita_nama" required="">
                    <option value="Khairullah" <?php echo (isset($_POST['jurusita_nama']) && $_POST['jurusita_nama'] === 'Khairullah') ? 'selected' : ''; ?>>Khairullah</option>
                    <option value="Rahmadi" <?php echo (isset($_POST['jurusita_nama']) && $_POST['jurusita_nama'] === 'Rahmadi') ? 'selected' : ''; ?>>Rahmadi, S.AP</option>
                    <option value="Lupi Ananda" <?php echo (isset($_POST['jurusita_nama']) && $_POST['jurusita_nama'] === 'Lupi Ananda') ? 'selected' : ''; ?>>Lupi Ananda, S.Kom</option>
                </select>
                Tanggal Sidang :
                <input type="date" name ="tanggal_sidang" required="" value="<?php echo @$tanggal_sidang; ?>">
                <input class="btn btn-primary" type="submit" name="btn" value="Tampilkan" />
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" id="example1">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Nomor Perkara</th>
                    <th>Penggugat/Pemohon</th>
                    <th>Tergugat/Termohon</th>
                    <th>Panitera Pengganti</th>
                    <th>Sidang Ke-</th>
                    <th>Dihadiri oleh</th>
                    <th>Tanggal Putus</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $no = 1;
                    foreach ($datafilter as $row ) : ?>
                  <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo $row->nomor_perkara?></td>
                    <td><?php echo $row->nama_p?></td>
                    <td><?php echo $row->nama_t?></td>
                    <td><?php echo $row->panitera_nama?></td>
                    <td><?php echo $row->sidang_ke?></td>   
                    <td><?php if ($row->dihadiri_oleh == 1) 
                    {
                        echo 'Semua pihak';
                    }
                    else if ($row->dihadiri_oleh == 2) 
                    {
                        echo 'Penggugat saja';
                    }
                    else if ($row->dihadiri_oleh == 3) 
                    {
                        echo 'Tergugat saja';
                    }
                    else if ($row->dihadiri_oleh == 4) 
                    {
                        echo 'Para pihak tidak hadir';
                    }
                    else
                    {
                        echo '' ;
                    }?>
                    </td>
                    <td><?php echo $row->tanggal_putusan?></td>
                    <td><?php echo anchor('Persidangan/detail/'.$row->idperkara, '<div class="btn btn-success btn-sm"><i class="fa fa-search-plus"></i></div>')?></td>   
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
 --></body>
</html>