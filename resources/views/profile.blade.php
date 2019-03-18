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
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content" id="con">
        <div class="row">
            <div class="col-md-12">
            <div class="card card-user">
            <div class="image">
            </div>
            <div class="card-body">
            <div class="author">
                <img src="{{ asset(Auth::user()->avatar) }}" class="layui-circle">

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                    <legend>个人信息</legend>
                </fieldset>

                <table class="layui-table" lay-even="" lay-skin="nob">
                    <tr>
                        <td>邮箱</td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tbody>
                    <tr>
                        <td>用户名 </td>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>年龄</td>
                        <td>
                            @php
                        $birthday = Auth::user()->birthday;
                        $birthday = new DateTime($birthday);
                        $now = new DateTime();
                        $interval = $birthday->diff($now);
                        echo intval($interval->format('%Y'));
                            @endphp
                            岁</td>
                    </tr>
                    <tr>
                        <td>性别</td>
                        <td>{{ Auth::user()->sex }}</td>
                    </tr>
                    <tr>
                        <td>身高</td>
                        <td>{{ Auth::user()->height }}KG</td>
                    </tr>
                    <tr>
                        <td>体重</td>
                        <td>{{ Auth::user()->weight }}KG</td>
                    </tr>
                    <tr>
                        <td>家庭</td>
                        <td>@if( Auth::user()->family_id) {{ \App\Family::find(Auth::user()->family_id)->name }}
                            @else
                                未加入家庭
                            @endif</td>
                    </tr>
                    </tbody>
                </table>
                </p>
                <a href="/user/change" class="btn btn-round btn-primary">修改</a>
            </div>
            <hr>
            </div>
            </div>
        </div>

    </div>
@endsection