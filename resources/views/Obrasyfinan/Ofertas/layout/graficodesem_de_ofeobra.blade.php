<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    contadorMes = {{$cronograma->last()->mes ?? 0}};
    meses = [];
    let acu = 0;
    monto = [];
    var app = @json($desembolsos);
    
    app.forEach(element => {
        // console.log(element.costo.toFixed(2));
        acu += Number(element.costo);
        monto.push(acu.toFixed(2));
    });

    for (let index = 0; index <= contadorMes; index++) {
        meses.push('mes '+index); 
    }
    meses.push('mes '+(contadorMes+1)); 
    const ctx = document.getElementById('myChart');
    // Chart.register(ChartDataLabels);
    
    new Chart(ctx, {
       type: 'line',
       data: {
         labels: meses,
         datasets: [{
           label: 'Desembolso por mes',
           data: monto,
           borderWidth: 1,
           pointStyle: 'rect',
         }]
       },
       plugins: [ChartDataLabels],
       options: {
        plugins: {
      // Change options for ALL labels of THIS CHART
            datalabels: {
                font: {
                    size: 15
                },
            }
        },
         scales: {
           y: {
            beginAtZero: true
           },
         },
       }
     });
</script>