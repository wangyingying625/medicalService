@extends('layouts.app')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <form>
                    <div class="input-group no-border">
                        <input  id="datepicker"  type="text" placeholder="按日期搜索" class="form-control">
                        <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </span>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" title="退出" href="#">
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
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">图片管理</h5>
                    </div>
                    <div class="card-body all-icons">
                        <div class="row" id="picBox">
                            <div class="font-icon-list col-lg-2 col-md-3 col-sm-4 col-xs-6 col-xs-6">
                                <div class="font-icon-detail" style="padding: 0">
                                    <a href="{{asset('img/thumbnails/22998930.jpeg')}}"><img src="{{asset('img/thumbnails/22998930.jpeg')}}"  height="160px"></a>
                                </div>
                                <p>2018-11-11</p>
                            </div>
                            <div class="font-icon-list col-lg-2 col-md-3 col-sm-4 col-xs-6 col-xs-6">
                                <div class="font-icon-detail" style="padding: 0">
                                    <a href="{{asset('img/thumbnails/create.png')}}"> <img   src="{{asset('img/thumbnails/create.png')}}"></a>
                                </div>
                                <p>2018-11-11</p>
                            </div>
                            <div class="font-icon-list col-lg-2 col-md-3 col-sm-4 col-xs-6 col-xs-6">
                                <div class="font-icon-detail" style="padding: 0">
                                    <a href="{{asset('img/thumbnails/22998930.jpeg')}}"><img  src="{{asset('img/thumbnails/22998930.jpeg')}}"></a>
                                </div>
                                <p>2018-11-11</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection