/**
 * Chart Helper - Utility functions for reliable chart rendering
 */
var ChartHelper = {
    /**
     * Check if Chart.js is loaded, load if not
     */
    ensureChartLibrary: function (callback) {
        if (typeof Chart === 'undefined') {
            console.log('Chart.js is not loaded. Loading now...');
            var script = document.createElement('script');
            script.src = baseURL + 'assets/plugins/chart.js/Chart.min.js';
            script.onload = function () {
                console.log('Chart.js loaded successfully');
                if (callback) callback();
            };
            script.onerror = function () {
                console.error('Failed to load Chart.js');
            };
            document.head.appendChild(script);
            return false;
        }
        return true;
    },

    /**
     * Initialize a chart with proper error handling
     */
    initChart: function (canvasId, chartType, chartData, chartOptions) {
        if (!canvasId || !chartType || !chartData) {
            console.error('Missing required parameters for chart initialization');
            return null;
        }

        var canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error('Chart canvas element not found: ' + canvasId);
            return null;
        }

        try {
            var ctx = canvas.getContext('2d');
            if (!ctx) {
                console.error('Failed to get canvas context for: ' + canvasId);
                return null;
            }

            // Apply default options if not provided
            var options = chartOptions || {
                responsive: true,
                maintainAspectRatio: false
            };

            console.log('Creating chart: ' + canvasId);
            return new Chart(ctx, {
                type: chartType,
                data: chartData,
                options: options
            });
        } catch (e) {
            console.error('Error creating chart: ' + canvasId, e);
            return null;
        }
    },

    /**
     * Initialize all charts when DOM is fully loaded
     */
    initAllCharts: function () {
        console.log('Initializing all charts');
        if (!this.ensureChartLibrary(() => this.initAllCharts())) {
            return; // Wait for library to load
        }

        // Add a slight delay to ensure DOM is ready
        setTimeout(() => {
            // Check for specific chart elements and initialize them
            this.initPerkaraDistributionChart();
            this.initOdpStatusChart();
            this.initMonthlyPerformanceChart();
            this.initAgeDistributionChart();
            this.initMarriageDurationChart();
            this.initDivorceTypeChart();
            this.initKuaDistributionChart();
        }, 500);
    },

    /**
     * Make a canvas visible in debug mode
     */
    debugCanvas: function (canvasId) {
        var canvas = document.getElementById(canvasId);
        if (canvas) {
            canvas.style.border = '2px solid red';
            canvas.style.backgroundColor = '#f0f0f0';
            console.log('Debug mode enabled for canvas: ' + canvasId);
        }
    },

    // Individual chart initializers
    initPerkaraDistributionChart: function () {
        if (document.getElementById('perkaraDistributionChart')) {
            console.log('Found perkaraDistributionChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initOdpStatusChart: function () {
        if (document.getElementById('odpStatusChart')) {
            console.log('Found odpStatusChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initMonthlyPerformanceChart: function () {
        if (document.getElementById('monthlyPerformanceChart')) {
            console.log('Found monthlyPerformanceChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initAgeDistributionChart: function () {
        if (document.getElementById('ageDistributionChart')) {
            console.log('Found ageDistributionChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initMarriageDurationChart: function () {
        if (document.getElementById('marriageDurationChart')) {
            console.log('Found marriageDurationChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initDivorceTypeChart: function () {
        if (document.getElementById('divorceTypeChart')) {
            console.log('Found divorceTypeChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    },

    initKuaDistributionChart: function () {
        if (document.getElementById('kuaDistributionChart')) {
            console.log('Found kuaDistributionChart, initializing...');
            // Chart will be initialized by specific page code with data
        }
    }
};

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM loaded, preparing to initialize charts');
    setTimeout(function () {
        ChartHelper.initAllCharts();
    }, 300);
});
