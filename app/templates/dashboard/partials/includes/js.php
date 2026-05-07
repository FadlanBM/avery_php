    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('chartOne')) {
                new ApexCharts(document.getElementById('chartOne'), {
                    series: [{
                        name: 'Sales',
                        data: [44, 55, 41, 67, 22, 43, 65, 88, 52, 35, 78, 90]
                    }],
                    chart: {
                        type: 'line',
                        height: 310,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                        colors: ['#9c3800']
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: '#6b7280'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#6b7280'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 4
                    },
                    markers: {
                        size: 4,
                        colors: ['#9c3800'],
                        strokeWidth: 0
                    }
                }).render();
            }
        });
    </script>