import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
var $ = require("jquery");

$('.value-modal-js').on('click', function(){
  let modalId = $(this).data('modal-id');

  // Заголовок графіка
  let yLabel = $(this).data('value-label');

  // Тип графіка
  let chartType = $(this).data('chart-type');

  // Тижні // перероблюємо і записуємо
  let isDropWeek = $(this).data('which-week');
  if (isDropWeek === 'drop') {
    var chartWeekValue = $('.chart-week-drop').data('week-array');
  } else {
    var chartWeekValue = $('.chart-week').data('week-array');
  }
  
  let chartWeekArray = chartWeekValue.split(',');
  let chartWeekArrayInt = [];
  chartWeekArray.forEach(function(element) {
    chartWeekArrayInt.push(element);
  });

  // Данні (data) / перероблюємо в массив і записуємо
  let valueData = $(this).data('value-array');
  let dataArray = valueData.split(',');
  let dataArrayInt = [];
  dataArray.forEach(function(element) {
    dataArrayInt.push(parseInt(element));
  });
  

  // Довжина графіка
  let countData = dataArrayInt.length;
  let slicedchartWeekArray = chartWeekArrayInt.slice(0).slice(-countData);
  console.log(countData);
  console.log(slicedchartWeekArray);
  
  // Малюємо графік
  let ctx = document.querySelector('.line-chart[data-chart-id='+modalId+']');
  let speedData = {
    labels: slicedchartWeekArray,
    datasets: [{
      label: yLabel,
      data: dataArrayInt,
      borderColor: '#a0d0f6',
      borderDash: [5, 5],
      backgroundColor: '#a0d0f6',
      pointBorderColor: '#a0d0f6',
      pointBackgroundColor: '#a0d0f6',
      pointRadius: 10,
      pointHoverRadius: 15,
      pointHitRadius: 30,
      pointBorderWidth: 2,
      pointStyle: 'circle'
    }]
  };
  let chartOptions = {
    legend: {
      display: true,
      position: 'top',
      labels: {
        boxWidth: 80,
        fontColor: 'black'
      }
    }
  };
  let lineChart = new Chart(ctx, {
      plugins: [ChartDataLabels],
      type: chartType,
      data: speedData,
      options: chartOptions
  });
});
