/**
 * Chart Helper - Fungsi untuk membantu inisialisasi chart
 * Memastikan chart dimuat dan ditampilkan dengan benar
 */

// Pastikan jQuery sudah dimuat
if (typeof jQuery === 'undefined') {
    console.error('Chart Helper requires jQuery');
} else {
    $(function () {
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded. Loading from CDN...');

            // Try to load Chart.js from CDN
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js';
            script.onload = function () {
                console.log('Chart.js loaded from CDN successfully');
                initializeCharts();
            };
            script.onerror = function () {
                console.error('Failed to load Chart.js from CDN');
                showChartErrors();
            };
            document.head.appendChild(script);
        } else {
            console.log('Chart.js is already loaded');
            initializeCharts();
        }
    });
}

/**
 * Initialize all charts on the page
 */
function initializeCharts() {
    console.log('Initializing all charts on the page');

    // Find all canvas elements with ID containing "chart"
    $('canvas[id*="chart"]').each(function () {
        var canvasId = $(this).attr('id');
        console.log('Found canvas with ID:', canvasId);

        // Show loading indicator
        var loadingId = '#' + canvasId + '-loading';
        if ($(loadingId).length) {
            $(loadingId).show();
        }

        // Check if this is a known chart type that needs automatic initialization
        if (canvasId === 'odmPieChart' && typeof initializeOdmPieChart === 'function') {
            initializeOdmPieChart(canvasId);
        } else if (canvasId === 'donut-chart' && typeof initializeDonutChart === 'function') {
            initializeDonutChart(canvasId);
        }
    });
}

/**
 * Show chart error messages
 */
function showChartErrors() {
    $('canvas[id*="chart"]').each(function () {
        var canvasId = $(this).attr('id');
        var container = $(this).parent();

        // Hide loading indicator
        var loadingId = '#' + canvasId + '-loading';
        if ($(loadingId).length) {
            $(loadingId).hide();
        }

        // Show error message
        container.html('<div class="alert alert-danger">Tidak dapat memuat chart. Chart.js tidak tersedia.</div>');
    });
}

/**
 * Initialize ODM Pie Chart
 * @param {string} canvasId - The ID of the canvas element
 */
function initializeOdmPieChart(canvasId) {
    try {
        // Get data attributes from the canvas element
        var canvas = document.getElementById(canvasId);
        var ctx = canvas.getContext('2d');

        var odmCount = parseInt(canvas.getAttribute('data-odm-count') || 0);
        var nonOdmCount = parseInt(canvas.getAttribute('data-non-odm-count') || 0);

        if (odmCount === 0 && nonOdmCount === 0) {
            // No data, show message
            $(canvas).parent().html('<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>');
            return;
        }

        // Create chart
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['One Day Minute', 'Lebih dari 1 hari'],
                datasets: [{
                    data: [odmCount, nonOdmCount],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });

        // Hide loading indicator
        var loadingId = '#' + canvasId + '-loading';
        if ($(loadingId).length) {
            $(loadingId).hide();
        }
    } catch (error) {
        console.error('Error initializing ODM Pie Chart:', error);
        $('#' + canvasId).parent().html('<div class="alert alert-danger">Error: ' + error.message + '</div>');
    }
}

/**
 * Initialize Donut Chart (used in E-Court Monitoring)
 * @param {string} canvasId - The ID of the canvas element
 */
function initializeDonutChart(canvasId) {
    try {
        var canvas = document.getElementById(canvasId);
        var ctx = canvas.getContext('2d');

        // Get data from parent container's data attributes
        var container = $(canvas).parent();
        var notRegistered = parseInt(container.data('not-registered') || 0);
        var pendingPmh = parseInt(container.data('pending-pmh') || 0);
        var pendingDecision = parseInt(container.data('pending-decision') || 0);
        var pendingUpload = parseInt(container.data('pending-upload') || 0);
        var completed = parseInt(container.data('completed') || 0);

        if (!notRegistered && !pendingPmh && !pendingDecision && !pendingUpload && !completed) {
            // No data available
            $(canvas).parent().html('<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>');
            return;
        }

        // Create chart
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Belum Registrasi',
                    'Menunggu PMH',
                    'Menunggu Putusan',
                    'Menunggu Upload',
                    'Selesai'
                ],
                datasets: [{
                    data: [
                        notRegistered,
                        pendingPmh,
                        pendingDecision,
                        pendingUpload,
                        completed
                    ],
                    backgroundColor: ['#f56954', '#f39c12', '#00c0ef', '#00a65a', '#3c8dbc']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right',
                    labels: {
                        fontColor: '#fff',
                        boxWidth: 15,
                        padding: 10
                    }
                }
            }
        });

        // Hide loading indicator
        $('#chart-loading').hide();
    } catch (error) {
        console.error('Error initializing Donut Chart:', error);
        $(canvas).parent().html('<div class="alert alert-danger">Error: ' + error.message + '</div>');
    }
}
