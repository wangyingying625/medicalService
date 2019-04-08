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
            </div>
            <div class="navbar-wrapper">

            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navigation">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" title="退出" href="{{ route('logout') }}">
                            <i class="now-ui-icons users_single-02"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown"  style="margin-top: -12px" id="down">
                <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                    <i class="now-ui-icons loader_gear"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">设为主图</a>
                    <a class="dropdown-item text-danger" href="#" id="href0">移除</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div id="welcome" style="display:none;height: 500px;text-align: center;padding-top: 200px;background-color:#85c2b0">
        <h3 style="color: #fff">感谢使用个人病历本,您还没有设置主图</h3>
    </div>
    <div class="panel-header panel-header-lg" style="background: #85c2b0"   id="zhuTu1" >
        <div class="container"  id="container0" style="height: 100%"></div>
    </div>

    <div class="content" id="content">

        <div class="row">

            <div class="col-lg-4"  v-for="(item,i) in data1" :id="'card' + i">
                <div class="card card-chart">
                    <div class="card-header">
                        <div class="dropdown"  style="margin-top: -12px">
                            <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                <i class="now-ui-icons loader_gear"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{--<a class="dropdown-item" href="#">设为主图</a>--}}
                                <a class="dropdown-item text-danger" href="#" :id="'href'+ (i+1)">移除</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="container"  :id="gernerateId(i+1)" style="height: 100%"></div>
                            {{--<canvas id="lineChartExample"></canvas>--}}
                        </div>
                    </div>
                    {{--<div class="card-footer">--}}
                        {{--<div class="stats">--}}
                            {{--<i class="now-ui-icons arrows-1_refresh-69"></i> 2018.11.2更新--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
    <script>
        var vm=new Vue({
            el:'#content',
            data:{
                data1:{!! $data !!}
            },
            methods:{
                gernerateId: function (i){
                    return "container" + i;

                },

            },
            created:function () {
                //alert(this.data1)
                if(this.data1=='')
                {
                    document.getElementById("welcome").style.display="block";
                    document.getElementById("content").style.display='none';
                    document.getElementById("zhuTu1").style.display='none';
                    document.getElementById("down").style.display='none'
                }
                else {
                    document.getElementById("welcome").style.display="none";
                    document.getElementById("content").style.display='block';
                    document.getElementById("zhuTu1").style.display='block';
                    document.getElementById("down").style.display='block'
                }
            }
        })
        data = {!! $data !!};
        var name;
        function msg() {
            for (i in data){
                name=data[i]['name_ch']+'&';
            }

        };
        msg();
        function show() {
            var times = 0;


            var i;
            var indicators = "";
            for (i  in data) {
                indicators = indicators + data[i]['name_ch'] + "&";
            }
                if (window.XMLHttpRequest) {
                    test = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    test = new window.ActiveXObject();
                } else {
                    alert("请升级至最新版本的浏览器");
                }
                console.log(i);
                if (test != null) {
                    indicator = data[i]['name_ch'];
                    console.log(indicator);
                    test.open("GET", "/indicator/show/" + indicators, true);
                    test.send(null);
                    test.onreadystatechange = function () {
                        if (test.readyState == 4 && test.status == 200) {
                            var IndicatorsData = JSON.parse(test.responseText);
                            console.log(IndicatorsData);
                            for (i in IndicatorsData){
//                                console.log(IndicatorsData[i]);
                                if (IndicatorsData[i].length != 0){
                                    console.log(IndicatorsData[i]);
                                    var id = "container" + times;
                                    var hrefId = "href" + times;
                                    var hrefEl = document.getElementById(hrefId);
                                    hrefEl.href = "/indicator/unimportant/" + IndicatorsData[i][0]['name_ch'];
                                    picture(IndicatorsData[i], id);
                                    times++;
                                }

                            }
                            console.log("次数"+times);
                            var rashId = times -1 ;
                            var rash = document.getElementById('card'+rashId);
                            rash.remove();

                        }
                    };
                }


        }
        show();
        function picture(OneIndicator, id) {
            var dom = document.getElementById(id);
            var myChart = echarts.init(dom);
            var indictorsData = new Array();
            var timeArray = new Array();

            var app = {};
            for (i in OneIndicator)
            {
                indictorsData.push(OneIndicator[i]['value']);
                timeArray.push(OneIndicator[i]['created_at']);
            }
            option = null;
            option = {
                title: {
                    text: OneIndicator[i]['name_ch'],
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: [OneIndicator[i]['name_ch']]
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
                series: {
                    name: OneIndicator[i]['name_ch'],
                    type: 'line',
                    data: indictorsData,
                }
            };

            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }
    </script>
@endsection