/**
 * File inisialisasi komponen UI untuk aplikasi Lab SIPP
 * Memastikan semua komponen UI diinisialisasi dengan benar 
 * dan menangani error dengan tepat
 */

$(document).ready(function () {
    // Inisialisasi Select2 dengan penanganan error
    initSelect2();

    // Inisialisasi komponen lain
    initDataTables();
    initTooltips();
    initCharts();
});

/**
 * Inisialisasi komponen Select2
 */
function initSelect2() {
    if (typeof $.fn.select2 === 'undefined') {
        console.error('Select2 belum dimuat. Mencoba memuat dari CDN...');

        // Tambahkan CSS Select2
        $('head').append('<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />');
        $('head').append('<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />');

        // Muat JavaScript Select2 dari CDN
        $.getScript('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js')
            .done(function () {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
                console.log('Select2 berhasil dimuat dari CDN');
            })
            .fail(function () {
                console.error('Gagal memuat Select2 dari CDN');
                alert('Gagal memuat komponen Select2. Beberapa fungsi mungkin tidak bekerja dengan baik.');
            });
    } else {
        try {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
            console.log('Select2 berhasil diinisialisasi');
        } catch (e) {
            console.error('Error saat inisialisasi Select2:', e);
        }
    }
}

/**
 * Inisialisasi DataTables
 */
function initDataTables() {
    if (typeof $.fn.DataTable !== 'undefined') {
        try {
            $('table.dataTable, table.table-datatable').each(function () {
                var tableId = $(this).attr('id');
                if (tableId && !$.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable({
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
                        }
                    });
                    console.log('DataTable untuk #' + tableId + ' berhasil diinisialisasi');
                }
            });
        } catch (e) {
            console.error('Error saat inisialisasi DataTables:', e);
        }
    } else {
        console.warn('DataTables tidak tersedia');
    }
}

/**
 * Inisialisasi tooltips
 */
function initTooltips() {
    if (typeof $.fn.tooltip !== 'undefined') {
        try {
            $('[data-toggle="tooltip"]').tooltip();
            console.log('Tooltips berhasil diinisialisasi');
        } catch (e) {
            console.error('Error saat inisialisasi Tooltips:', e);
        }
    }
}

/**
 * Inisialisasi charts
 */
function initCharts() {
    if (typeof Chart !== 'undefined') {
        console.log('Chart.js tersedia');
    } else {
        console.warn('Chart.js tidak tersedia. Memuat dari CDN...');
        $.getScript('https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js')
            .done(function () {
                console.log('Chart.js berhasil dimuat dari CDN');
            })
            .fail(function () {
                console.error('Gagal memuat Chart.js dari CDN');
            });
    }
}
