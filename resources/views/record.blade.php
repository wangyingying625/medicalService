@extends('layouts.app')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a class="navbar-brand" href="/record">病历图表</a>
                <a class="navbar-brand" href="/pictures">图片记录</a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" title="退出" href="{{route('logout')}}">
                            <i class="now-ui-icons users_single-02"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="panel-header panel-header-lg" style="height: 100px">
        <canvas id="bigDashboardChart"></canvas>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category" style="float: left">促甲状腺激素含量</h5>
                        <div class="dropdown"  style="margin-top: -12px">
                            <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                <i class="now-ui-icons loader_gear"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">设为主图</a>
                                <a class="dropdown-item text-danger" href="#">移除</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <div id="container" style="height: 100%"></div>
                            {{--<canvas id="lineChartExample"></canvas>--}}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="now-ui-icons arrows-1_refresh-69"></i> 2018.11.2更新
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var data;
        function showJson(){
            var test;
            if(window.XMLHttpRequest){
                test = new XMLHttpRequest();
            }else if(window.ActiveXObject){
                test = new window.ActiveXObject();
            }else{
                alert("请升级至最新版本的浏览器");
            }
            if(test !=null){
                test.open("GET","/indicator/showAll",true);
                test.send(null);
                test.onreadystatechange=function(){
                    if(test.readyState==4&&test.status==200){
                       data = JSON.parse(test.responseText);
                        picture('肝功能');
                    }
                };

            }
        }
        showJson();
        {{--var data = {!!  $data !!};--}}
        function picture(key) {
            var dom = document.getElementById("container");
            var myChart = echarts.init(dom);
            var indictors = new Array();
            var indictorsMap= new Map();
            var timeArray = new Array();
//               var images = new Array();
            for (var image in data[key]){
                timeArray.push(data[key][image]['created_at']);
                for (var indictor in data[key][image]['indicators']){
                    indictors.push(data[key][image]['indicators'][indictor]['name_ch']);
                }
            }

            console.log(data[key]);

            indictors = new Set(indictors);
            console.log(indictors);
            for (var indictor of indictors){
                for (var image in data[key]){
                    for (var indic in data[key][image]['indicators']){
                        if (data[key][image]['indicators'][indic]['name_ch']==indictor){
                            if(indictorsMap.has(indictor)){
                                console.log(data[key][image]['indicators'][indic]);
                                indictorsMap.get(indictor).push(data[key][image]['indicators'][indic]['value']);
                            }else {
                                indictorsMap.set(indictor,[]);
                                indictorsMap.get(indictor).push(data[key][image]['indicators'][indic]['value']);
                            }
                        }

                    }
                }
            }
            var seriesObject = mapToObject(indictorsMap);
            console.log(seriesObject);
//               console.log(indictorsMap);
            var app = {};
            option = null;
            option = {
                title: {
                    text: key,
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: Array.from(indictors)
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: timeArray
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: seriesObject
            };

            ;
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }

        function mapToObject(indictors) {
            var series = new Array();
            for (var name of indictors){
                console.log(name);
                series.push({
                    name: name[0],
                    type: 'line',
                    data: name[1],
                });
            }
            return series;
        }
    </script>
@endsection