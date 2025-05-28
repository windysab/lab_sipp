<footer class="main-footer">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			<strong>Sistem Informasi Pengadilan Agama Amuntai &copy; <?php echo date('Y'); ?></strong>
		</div>
		<div>
			<span class="text-muted">Dikembangkan oleh</span>
			<a href="#" class="text-primary">Tim IT Pengadilan Agama Amuntai</a>
			<span class="badge badge-info">v2.1</span>
		</div>
	</div>
</footer>

<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables & Plugins -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>

<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>

<!-- Chart.js -->
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

<!-- Component Initializer -->
<script>
	$(function() {
		// Initialize tooltips
		if (typeof $().tooltip === 'function') {
			$('[data-toggle="tooltip"]').tooltip();
		}

		// Initialize Select2
		if (typeof $().select2 === 'function') {
			$('.select2').select2({
				theme: 'bootstrap4'
			});
		} else {
			console.error('Select2 is not loaded correctly');
		}

		// Initialize DataTables
		if (typeof $().DataTable === 'function') {
			$('.dataTable').each(function() {
				var tableId = $(this).attr('id');
				if (!$.fn.DataTable.isDataTable('#' + tableId)) {
					$('#' + tableId).DataTable({
						"responsive": true,
						"lengthChange": true,
						"autoWidth": false,
						"language": {
							"search": "Cari:",
							"lengthMenu": "Tampilkan _MENU_ data per halaman",
							"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
							"infoEmpty": "Tidak ada data yang ditampilkan",
							"infoFiltered": "(difilter dari _MAX_ data)",
							"zeroRecords": "Tidak ada data yang cocok ditemukan",
							"paginate": {
								"first": "Pertama",
								"last": "Terakhir",
								"next": "Selanjutnya",
								"previous": "Sebelumnya"
							}
						}
					});
				}
			});
		}
	});
</script>
</body>

</html>