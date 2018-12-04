@extends('layouts.dash')
@inject('getInfo', 'App\Http\Controllers\AdminsCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

@section('meta')
<meta name="title" content="{{ $getInfo->getValue('sitename') }}">
<meta name="description" content="{{ $getInfo->getValue('description') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
<meta name="author" content="{{ $getInfo->getValue('powered_by') }}">

@stop

@section('content')
  <div class="panel-header panel-header-lg">
                <div id="DashboardChart"></div>

                  <script>
                    var chart = new Highcharts.Chart({
                      chart: {
                          renderTo: 'DashboardChart',
                          type: 'column',
                          backgroundColor: "rgba(255, 255, 255, 0)",
                          options3d: {
                              enabled: true,
                              alpha: 15,
                              beta: 15,
                              depth: 50,
                              viewDistance: 25
                          }
                      },
                      title: {
                        text: 'Rest Calls',
                        style: {
                              color: '#ffffff',
                              font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                          }
                      },
                      
                      plotOptions: {
                          column: {
                              depth: 25
                          },
                        style: {
                              color: '#ffffff',
                              font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                          }
                      },
                      credits: {
                            text: 'RealLexi.com',
                            style: {
                              color: '#ffffff',
                              font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                          }
                        },
                      series: [{
                          name: 'Requests',
                          data: {{ json_encode($bigChart) }},
                        style: {
                              color: '#ffffff',
                              font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                          }
                      }]
                  });

                  function showValues() {
                      $('#alpha-value').html(chart.options.chart.options3d.alpha);
                      $('#beta-value').html(chart.options.chart.options3d.beta);
                      $('#depth-value').html(chart.options.chart.options3d.depth);
                  }

                  // Activate the sliders
                  $('#sliders input').on('input change', function () {
                      chart.options.chart.options3d[this.id] = parseFloat(this.value);
                      showValues();
                      chart.redraw(false);
                  });

                  showValues();
                  </script>
                  {{ print_r($bigChart) }}
            </div>
            <div class="content">

                <div class="row">
                  <div class="well message">
                      @include('partials._messages')
                  </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4 class="card-category">Total Requests</h4>
                                <!-- <div class="dropdown">
                                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                        <i class="now-ui-icons loader_gear"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <a class="dropdown-item text-danger" href="#">Remove Data</a>
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <div id="newadds"></div>
                                    <script>
                                    Highcharts.chart('newadds', {
                                    chart: {
                                        type: 'bar',
                                        backgroundColor: "rgba(255, 255, 255, 0)",
                                         style: {
                                            color: '#000000',
                                            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                                        }
                                    },
                                    title: {
                                        text: 'Total Requests'
                                    },
                                    xAxis: {
                                        categories: ['Requests']
                                    },
                                    credits: {
                                            text: 'RealLexi.com'
                                        },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Total Requests by method'
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    series: [{
                                        name: 'GET',
                                        data: {{ json_encode($reqGet) }}
                                    }, {
                                        name: 'POST',
                                        data: {{ json_encode($reqPost) }}
                                    },{
                                        name: 'UPDATE',
                                        data: {{ json_encode($reqPut) }}
                                    }, {
                                        name: 'DELETE',
                                        data: <?php echo json_encode($reqDel); ?>
                                    }]
                                });
                  </script>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="stats well">
                                    <!-- <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">Users</h5>
                                <h4 class="card-title">{{ $users->count() }}</h4>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                        <i class="now-ui-icons loader_gear"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="/users/create">Add a User</a>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                  <table class="table"><tbody>
                                    @if($users)
                                    @foreach($users->paginate(5) as $key)
                                      <tr><td>{{ $key->firstname }} {{ $key->lastname }}</td></tr> 
                                    @endforeach
                                    @else
                                      <tr><td>No users yet</td></tr>
                                    @endif
                                    </tbody></table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">Statistics</h5>
                                <h4 class="card-title">Tables Performance</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <div id="tablePerformance"></div>
                                    <script>
                                      Highcharts.chart('tablePerformance', {
                                      chart: {
                                          plotBackgroundColor: null,
                                          plotBorderWidth: null,
                                          plotShadow: false,
                                          type: 'pie'
                                      },
                                      title: {
                                          text: 'Top 10 Tables Performance'
                                      },
                                      tooltip: {
                                          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                      },
                                      credits: {
                                            text: 'RealLexi.com'
                                        },
                                      plotOptions: {
                                          pie: {
                                              allowPointSelect: true,
                                              cursor: 'pointer',
                                              dataLabels: {
                                                  enabled: true,
                                                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                  style: {
                                                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                  }
                                              }
                                          }
                                      },
                                      series: [{
                                          name: 'Brands',
                                          colorByPoint: true,
                                          data: [<?php echo $tablesPer; ?>]
                                      }]
                                  });
                                    </script>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="now-ui-icons ui-2_time-alarm"></i> Last 7 days
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card card-tasks">
                      <div class="card-header">
                        <h5 class="card-category">Tables</h5>
                        <h4 class="card-title">by {{ Auth::user()->firstname }}</h4>
                      </div>
                      <div class="card-body">
                        <div class="table-full-width table-responsive">
                          <table class="table">
                            <tbody>
                            @if($tables)
                              @foreach($tables->paginate(5) as $key)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" checked="" disabled>
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>

                                    <td >{{ $key->table }}</td>
                                    <td >{{ $key->body }}</td>
                                    <td class="td-actions text-right">
                                        <a href="/admin-rest/{{ $key->table }}" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
                                            <i class="now-ui-icons ui-2_settings-90"></i>
                                        </a>
                                       
                                    </td>
                                    <td class="td-actions text-right">
                                      
                                        {{ Form::open(['route' => ['admin-rest.destroy', $key->id], 'method'=>'delete']) }}
                                            {{ Form::submit('X', ['class'=>'btn btn-danger btn-round now-ui-icons ui-1_simple-remove delete'])}}
                                            {{ Form::close() }}
                                       
                                    </td>
                                </tr>

                                @endforeach

                                @else
                                  <tr>
                                    <td>
                                      No tables yet
                                    </td>
                                  </tr>
                                @endif
                            </tbody>
                          </table>
                          <div class="well"> {{ $tables->paginate(5)->links() }}</div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <hr>
                        <div class="stats">
                          <!-- <i class="now-ui-icons loader_refresh spin"></i> Updated Now -->
                        </div>
                      </div>
                  </div>
                  </div>
                 
                </div>
              </div>
@endsection