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

                <a class="layui-btn layui-btn-normal layui-btn-radius" href="/indicator/record/{{ Auth::id() }}">病历图表</a>
                <a class="layui-btn layui-btn-normal layui-btn-radius" href="/indicator/upload">上传病历</a>
                <a class="layui-btn layui-btn-normal layui-btn-radius" href="/indicator/one">单项指标查询</a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" title="退出" href="{{ route('login') }}">
                            <i class="now-ui-icons users_single-02"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('record')


@endsection