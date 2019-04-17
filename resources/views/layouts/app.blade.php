<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>健康随身册</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
 {{--   <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('layui-v2.4.5/layui/css/layui.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    <link  href="{{ asset('cropper/cropper.css') }}" rel="stylesheet">


    <script src="{{asset('js/core/jquery.min.js') }}"></script>
    <script src="{{asset('js/vue/dist/vue.js')}}"></script>
    <script src="{{asset('js/vue-resource/dist/vue-resource.js')}}"></script>
    <script src="{{asset('js/vue-router.js')}}"></script>
    <script src="{{ asset('layui-v2.4.5/layui/layui.js')}}"></script>
    <script type="text/javascript" src="https://www.echartsjs.com/gallery/vendors/echarts/echarts.min.js"></script>
    <style>
        .layui-upload-file{
            display: none;
        }
        .likeA{
            background:none;
            border: none;
            color: #1E9FFF;
            cursor: pointer;
        }
        body .demo-class .layui-layer-title{background:#f96332; color:#fff; border: none;}
        body .demo-class .layui-layer-btn0{border-radius: 7px;background-color: #1E9FFF;color: #fff}
    </style>
</head>
<body>

<div class="wrapper ">
    <div class="sidebar" data-color="orange">
        <div class="logo">
            <p class="simple-text logo-normal">
                {{ Auth::user()->name }}
            </p>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <a href="/home">
                        <i class="now-ui-icons design_app"></i>
                        <p>首页</p>
                    </a>
                </li>
                <li>
                    <a href="/indicator/record/{{ Auth::id() }}">
                        <i class="now-ui-icons education_agenda-bookmark"></i>
                        <p>
                            病例记录
                        </p>
                    </a>
                </li>
                <li>
                    <a href="/analyze">
                        <i class="now-ui-icons  ui-1_bell-53""></i>
                        <p>
                            健康状况
                        </p>
                    </a>
                </li>
                <li>
                    @if (Auth::user()->family_id )
                        <a href="/family/info/{{ Auth::user()->family_id }}">
                    @else
                        <a href="/family/add">
                    @endif
                        <i class="now-ui-icons education_atom "></i>
                        <p>我的家人</p>
                    </a>
                </li>
                <li>
                    <a href="/user/info">
                        <i class="now-ui-icons users_single-02"></i>
                        <p>个人中心</p>
                    </a>
                </li>
                <li id="date" class="active-pro" style="margin-bottom: 25px;padding:0 15px;width: 100%;text-align: center">
                        <p>距离上次检查已经<span style="font-size: 23px;">@{{date}}</span>天了<br>请及时检查</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        @yield('content')
    </div>
</div>
</body>
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.js')}}"></script>
<script src="{{ asset('js/now-ui-dashboard.js') }}"></script>
<script src="{{ asset('js/demo.js')}}"></script>
<script>
    var vm=new Vue({
        el:'#date',
        data:{
            lastTime: '',
            date:'',
        },
        created: function () {
            this.$http.get('/showdate').then(function (result) {
                this.date=result.body;
            });
        },

    });
</script>
</html>
