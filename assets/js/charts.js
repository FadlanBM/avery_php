document.addEventListener('DOMContentLoaded', function() {
  const isDark = document.body.classList.contains('dark');
  
  const chartColors = {
    primary: '#465fff',
    success: '#22c55e',
    warning: '#f59e0b',
    danger: '#ef4444',
    gray: isDark ? '#374151' : '#e5e7eb',
    text: isDark ? '#9ca3af' : '#6b7280'
  };

  if (document.getElementById('chartOne')) {
    new ApexCharts(document.getElementById('chartOne'), {
      series: [{
        name: 'Sales',
        data: [44, 55, 41, 67, 22, 43, 65, 88, 52, 35, 78, 90]
      }],
      chart: {
        type: 'line',
        height: 310,
        toolbar: { show: false },
        zoom: { enabled: false }
      },
      stroke: {
        curve: 'smooth',
        width: 3,
        colors: [chartColors.primary]
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: chartColors.text } }
      },
      yaxis: {
        labels: { style: { colors: chartColors.text } }
      },
      grid: {
        borderColor: chartColors.gray,
        strokeDashArray: 4
      },
      markers: {
        size: 4,
        colors: [chartColors.primary],
        strokeWidth: 0
      }
    }).render();
  }

  if (document.getElementById('chartTwo')) {
    new ApexCharts(document.getElementById('chartTwo'), {
      series: [44, 55, 41, 17, 15],
      chart: {
        type: 'donut',
        height: 350
      },
      labels: ['Desktop', 'Mobile', 'Tablet', 'Unknown', 'Bot'],
      colors: [chartColors.primary, chartColors.success, chartColors.warning, chartColors.danger, chartColors.gray],
      legend: {
        position: 'bottom',
        labels: { colors: chartColors.text }
      }
    }).render();
  }

  if (document.getElementById('chartThree')) {
    new ApexCharts(document.getElementById('chartThree'), {
      series: [{
        name: 'Revenue',
        data: [16800, 16800, 15500, 17800, 15500, 17000, 15600, 16200, 15000, 16500, 17200, 18000]
      }],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          columnWidth: '60%'
        }
      },
      colors: [chartColors.primary],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: chartColors.text } }
      },
      yaxis: {
        labels: { style: { colors: chartColors.text } }
      },
      grid: {
        borderColor: chartColors.gray,
        strokeDashArray: 4
      }
    }).render();
  }
});
