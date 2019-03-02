<!DOCTYPE HTML>

<html>
<head>
    <title>个人病历本</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet" />
    <noscript><link rel="stylesheet" href="{{ asset('css/noscript.css') }}" /></noscript>
</head>
<body >

<!-- Wrapper -->
<div id="wrapper" class="fade-in">

    <!-- Intro -->
    <div id="intro" style="margin-top: 0;padding-top: 0">
        <h1 >Personal medical history</h1>
        <p style="color: #153254;font-weight: 500">您的私人病历管家</p>
        <ul class="actions" style="color: #000;">
            <li><a href="/home" class="button icon solo fa-arrow-right scrolly">Continue</a></li>
        </ul>
    </div>

    <!-- Header -->

    <!-- Nav -->
    <nav id="nav">
        <ul class="links">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/home">主页</a></li>
            <li><a href="/record">病历记录</a></li>
            <li> <a href="/family/info">我的家人</a></li>
            <li><a href="/geRen">个人中心</a></li>
        </ul>
    </nav>

</div>

<!-- Scripts -->
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.scrollex.min.js') }}"></script>
<script src="{{ asset('js/jquery.scrolly.min.js') }}"></script>
<script src="{{ asset('js/skel.min.js') }}"></script>
<script src="{{ asset('js/util.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>