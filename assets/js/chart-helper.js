/**
 * Helper functions for Chart.js
 */
var ChartHelper = {
    /**
     * Debug a canvas element
     * @param {string} canvasId - The ID of the canvas element
     */
    debugCanvas: function (canvasId) {
        var canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.warn('Canvas with ID ' + canvasId + ' not found!');
            return;
        }

        console.log('Canvas ' + canvasId + ' found:', canvas);
        console.log('Canvas dimensions:', canvas.width, 'x', canvas.height);

        var ctx = canvas.getContext('2d');
        if (!ctx) {
            console.warn('Could not get 2D context for canvas ' + canvasId);
        } else {
            console.log('2D context obtained for canvas ' + canvasId);
        }
    },

    /**
     * Initialize a chart
     * @param {string} canvasId - The ID of the canvas element
     * @param {string} type - Chart type (bar, line, pie, etc.)
     * @param {Object} data - Chart data
     * @param {Object} options - Chart options
     * @return {Chart} The created Chart instance
     */
    initChart: function (canvasId, type, data, options) {
        var canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error('Canvas ' + canvasId + ' not found');
            return null;
        }

        var ctx = canvas.getContext('2d');
        var chart = new Chart(ctx, {
            type: type,
            data: data,
            options: options || {}
        });

        return chart;
    },

    /**
     * Initialize all charts on the page
     * This was missing and causing the error
     */
    initAllCharts: function () {
        console.log('Initializing all charts on the page');

        // Find all canvas elements that might be charts
        var canvases = document.querySelectorAll('canvas[id]');

        canvases.forEach(function (canvas) {
            console.log('Found canvas with ID:', canvas.id);
            // You can add specific chart initialization logic here if needed
        });

        // Initialize specific charts if they exist
        if (document.getElementById('performaOdpChart')) {
            try {
                var ctx = document.getElementById('performaOdpChart').getContext('2d');
                var chartData = window.odpChartData || {
                    labels: [],
                    datasets: [{
                        label: 'No Data',
                        data: [],
                        backgroundColor: 'rgba(255, 255, 255, 0.7)'
                    }]
                };

                var performaOdpChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: { display: false },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: 'rgba(255, 255, 255, 0.8)'
                                },
                                gridLines: {
                                    display: true,
                                    color: 'rgba(255, 255, 255, 0.2)'
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    fontColor: 'rgba(255, 255, 255, 0.8)'
                                },
                                gridLines: {
                                    display: false,
                                    color: 'rgba(255, 255, 255, 0.2)'
                                }
                            }]
                        }
                    }
                });
                console.log('performaOdpChart initialized');
            } catch (e) {
                console.error('Error initializing performaOdpChart:', e);
            }
        }

        if (document.getElementById('perkaraDistributionChart')) {
            try {
                var ctx = document.getElementById('perkaraDistributionChart').getContext('2d');
                var chartData = window.distributionChartData || {
                    labels: ['No Data'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['rgba(255, 255, 255, 0.7)']
                    }]
                };

                var perkaraDistributionChart = new Chart(ctx, {
                    type: 'pie',
                    data: chartData,
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontColor: 'rgba(255, 255, 255, 0.8)',
                                boxWidth: 15,
                                padding: 10
                            }
                        }
                    }
                });
                console.log('perkaraDistributionChart initialized');
            } catch (e) {
                console.error('Error initializing perkaraDistributionChart:', e);
            }
        }
    }
};

// Add listener for DOM loading
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM loaded, preparing to initialize charts');
    setTimeout(function () {
        if (typeof ChartHelper.initAllCharts === 'function') {
            ChartHelper.initAllCharts();
        } else {
            console.error('ChartHelper.initAllCharts function not available');
        }
    }, 500);
});
