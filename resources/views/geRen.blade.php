@extends('layouts.app')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
            <div class="navbar-wrapper">
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">

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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">修改资料</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input type="text" class="form-control" disabled="" placeholder="Company" value="12356@qq.com">
                                    </div>
                                </div>
                                <div class="col-md-3 px-1">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" placeholder="Username" value="michael23">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label>年龄</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label>性别</label>
                                        <input type="text" class="form-control" placeholder="Company" value="女">
                                    </div>
                                </div>
                                <div class="col-md-6 pl-1">
                                    <div class="form-group">
                                        <label>体重</label>
                                        <input type="text" class="form-control" placeholder="Last Name" value="45kg">
                                    </div>
                                </div>
                                <input id="change" type="submit" class="btn btn-round btn-primary" value="确定">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image">
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <a href="#">
                                <h5 class="title">mldwyy</h5>
                            </a>
                            <p class="description">
                                20岁
                            </p>
                        </div>
                        <p class="description text-center">
                            160cm
                            <br> 45kg<br>
                            <br>身体状况良好
                        </p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection