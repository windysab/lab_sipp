/**
 * Chart Debug Helper
 * Alat bantu untuk debugging Chart.js
 */
(function () {
    // Deteksi Chart.js
    console.log('Chart Debug Helper loaded');
    window.chartDebug = {
        isChartJsLoaded: function () {
            var loaded = typeof Chart !== 'undefined';
            console.log('Chart.js loaded:', loaded);
            return loaded;
        },

        loadChartJsFromCDN: function (callback) {
            console.log('Attempting to load Chart.js from CDN');
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js';
            script.onload = function () {
                console.log('Chart.js successfully loaded from CDN');
                if (callback) callback(true);
            };
            script.onerror = function () {
                console.error('Failed to load Chart.js from CDN');
                if (callback) callback(false);
            };
            document.head.appendChild(script);
        },

        createSimpleChart: function (elementId, type) {
            console.log('Creating simple chart in element:', elementId);
            try {
                if (!this.isChartJsLoaded()) {
                    console.error('Chart.js is not loaded. Cannot create chart.');
                    return false;
                }

                var ctx = document.getElementById(elementId).getContext('2d');
                var data = {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
                    datasets: [{
                        label: 'Test Dataset',
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                var options = {
                    responsive: true,
                    maintainAspectRatio: false
                };

                var chart = new Chart(ctx, {
                    type: type || 'bar',
                    data: data,
                    options: options
                });

                console.log('Chart created successfully');
                return chart;
            } catch (error) {
                console.error('Error creating chart:', error);
                return null;
            }
        },

        checkContainerDimensions: function (containerId) {
            var container = document.getElementById(containerId);
            if (!container) {
                console.error('Container not found:', containerId);
                return null;
            }

            var dimensions = {
                width: container.offsetWidth,
                height: container.offsetHeight,
                display: window.getComputedStyle(container).display,
                visibility: window.getComputedStyle(container).visibility
            };

            console.log('Container dimensions:', dimensions);

            // Check if dimensions are too small
            if (dimensions.width < 50 || dimensions.height < 50) {
                console.warn('Container dimensions too small for chart!');
            }

            // Check if container is hidden
            if (dimensions.display === 'none' || dimensions.visibility === 'hidden') {
                console.warn('Container is hidden!');
            }

            return dimensions;
        }
    };

    // Auto-detect if Chart.js is loaded
    window.chartDebug.isChartJsLoaded();
})();
