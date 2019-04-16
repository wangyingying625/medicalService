@extends('indicator.head')
@section('record')
    <!-- End Navbar -->
    <div class="panel-header panel-header-lg" style="height: 100px">
        <canvas id="bigDashboardChart"></canvas>
    </div>
    <div class="content" id="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-chart layui-anim layui-anim-up"  v-for="(item,i) in data1" >
                    <div class="card-header">
                        <div class="dropdown"  style="margin-top: -12px">
                            {{--<button type="button" class="btn btn-danger btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" >
                                --}}{{--<i class="now-ui-icons emoticons_satisfied"></i>--}}{{--
                                <i class="now-ui-icons gestures_tap-01"></i>
                            </button>--}}
                            <button title="健康" type="button" class="btn btn-success btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" >
                                <i class="now-ui-icons emoticons_satisfied"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="container"  :id="gernerateId(i)" style="height: 100%"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var data;
        var vm=new Vue({
            el:'#content',
            data:{
                data1: '',
            },
            methods:{

                gernerateId: function (i){
                    return "container" + i;

                }

            },
            created: function () {
                this.$http.get('/indicator/show/user/{{ $user['id'] }}').then(function (result) {
                    var arr2 = Object.keys(result.body);
                    this.data1=arr2;
                });
            },

        });
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
                test.open("GET","/indicator/show/user/{{ $user['id'] }}",true);
                test.send(null);
                test.onreadystatechange=function(){
                    if(test.readyState==4&&test.status==200){
                       data = JSON.parse(test.responseText);
                       var times=0;
                       for(key in data){
                           var id="container"+times;
                           picture(key,id);
                           times++;

                       }
                    }
                };

            }
        }
        showJson();
        function picture(key,id) {
            var dom = document.getElementById(id);
            var myChart = echarts.init(dom);
            var indictors = new Array();
            var indictorsMap= new Map();
            var timeArray = new Array();
            for (var image in data[key]){
                timeArray.push(data[key][image]['created_at']);
                for (var indictor in data[key][image]['indicators']){
                    indictors.push(data[key][image]['indicators'][indictor]['name_ch']);
                }
            }


            indictors = new Set(indictors);
            for (var indictor of indictors){
                for (var image in data[key]){
                    for (var indic in data[key][image]['indicators']){
                        if (data[key][image]['indicators'][indic]['name_ch']==indictor){
                            if(indictorsMap.has(indictor)){
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
                    data: Array.from(indictors),
                    type:'scroll',
                    left: '50px'
                },
                toolbox: {
                    show: false,
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