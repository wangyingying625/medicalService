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
            <a href="#">
            <h5 class="title">邮箱： {{ Auth::user()->email }}</h5>
            <h5 class="title">用户名： {{ Auth::user()->name }}</h5>
            </a>
            <p class="description"  style="color: #000">
{{--            {{ date('Y') }}岁--}}
{{--                {{ Auth::user()->birthday->format('Y') }}--}}
            </p>
            </div>
            <p class="description text-center" style="color: #000">

            身高{{ Auth::user()->height }}KG


            <br> 体重{{ Auth::user()->weight }}KG<br><br>
                {{--家庭这里我来改，后端传入数据--}}
            所属家庭账号@{{msg.familyID}}
            </p>
                <a href="/user/change" class="btn btn-round btn-primary">修改</a>
            </div>
            <hr>
            </div>
            </div>
        </div>

    </div>
@endsection