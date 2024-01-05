<x-app>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info ">
                            <div class="container">
                                <div class="info-box bg-info px-0 py-lg-2 py-0 mb-0 border-0 shadow-none">
                                    <div class="info-box-content">
                                        <h5 class="m-0">Pesanan</h5>
                                        <h3 class="m-0"><b>{{count($order)}}</b></h3>
                                    </div>
                                    <span class="info-box-icon shadow-none border-0 text-white d-none d-lg-block" style="font-size: 50px;"><i
                                        class="fas fa-shopping-bag"></i></span>
                                </div>
                                <div class="inner p-lg-2" style="height: 40px;">
                                    <div class="d-lg-flex align-items-center">
                                        <div class="flex-lg-fill text-lg-left">
                                            <h6 class="m-0">Dalam Proses : {{count($dalam_proses)}}</h6>
                                        </div>
                                        <div class="flex-lg-fill text-lg-right">
                                            <h6 class="m-0">Selesai : {{count($selesai)}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('order')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning ">
                            <div class="container">
                                <div class="info-box bg-warning px-0 mb-0 border-0 shadow-none">
                                    <div class="info-box-content">
                                    <h5 class="m-0">User Terdaftar</h5>
                                    <h3 class="m-0"><b>{{count($user)}}</b></h3>
                                    </div>
                                    <span class="info-box-icon shadow-none border-0 text-dark d-none d-lg-block" style="font-size: 50px;"><i
                                        class="fas fa-users"></i></span>
                                </div>
                                <div class="inner p-2" style="height: 40px;"></div>
                            </div>
                            <a href="{{url('user')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="card card-info" style="height: auto;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Penjualan</h3>
                                </div>
                            </div>
                            @if ( count($penjualan_total) == 0 )
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="d-flex flex-column">
                                      <h6 class="text align-self-center p-2">Belum ada penjualan yang terselesaikan</h6>
                                    </div>
                                  </div>
                            </div>     
                            @else
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="visitors-chart" height="200" width="444" style="display: block; width: 444px; height: 200px;" class="chartjs-render-monitor"></canvas>
                                    
                                </div>              
                            </div>                            
                            @endif
                        </div>
                    </section>
                    <section class="col-lg-5 connectedSortable">
                        <div class="card card-danger" style="height: auto;">
                            <div class="card-header">
                                <h3 class="card-title">Produk Terlaris</h3>
                            </div>
                            @if ( count($penjualan) == 0 )
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="d-flex flex-column">
                                      <h6 class="text align-self-center p-2">Belum ada penjualan yang terselesaikan</h6>
                                    </div>
                                  </div>
                            </div>     
                            @else
                            <div class="card-body">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 444px;" width="444" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
</x-app>
<script src={{asset("AdminLTE/plugins/chart.js/Chart.min.js")}}></script>
<script>
    $(function () {
        'use strict'
    
        var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
        }
    
        var mode = 'index'
        var intersect = true
    
        var $visitorsChart = $('#visitors-chart')
        // eslint-disable-next-line no-unused-vars
        var visitorsChart = new Chart($visitorsChart, {
        data: {
            labels: [
                @foreach ($penjualan_total as $item => $value)
                    "{{date('F',mktime(0,0,0,$value->month,1,2011))}} {{$value->year}}",
                @endforeach
            ],
            datasets: [{
            type: 'line',
            data: [
                @foreach ($penjualan_total as $item => $value)
                    '{{$value->total_orders}}',
                @endforeach
            ],
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
            }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            mode: mode,
            intersect: intersect
            },
            hover: {
            mode: mode,
            intersect: intersect
            },
            legend: {
            display: false
            },
            scales: {
            yAxes: [{
                // display: false,
                gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
                },
                ticks: $.extend({
                beginAtZero: true,
                suggestedMax: 200
                }, ticksStyle)
            }],
            xAxes: [{
                display: true,
                gridLines: {
                display: false
                },
                ticks: ticksStyle
            }]
            }
        }
        })
    })
  
 //-------------
    //- DONUT CHART -
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
        @foreach ($penjualan as $item => $value)
            '{{$value->product_name}} ({{$value->variant_name}})',
        @endforeach
      ],
      datasets: [
        {
          data: [
            @foreach ($penjualan as $item => $value)
                '{{$value->total_orders}}',
            @endforeach
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });
</script>
