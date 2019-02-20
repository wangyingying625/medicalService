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
                                        <input type="text" class="form-control" disabled="" placeholder="Company" v-bind:value="msg.email">
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" placeholder="Username" v-bind:value="msg.name">
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label>年龄</label>
                                        <input  class="form-control"  v-bind:value="msg.age">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>体重</label>
                                        <input type="text" class="form-control"  v-bind:value="msg.weight">
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="form-group">
                                        <label>身高</label>
                                        <input type="text" class="form-control"   v-bind:value="msg.height">
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label>性别</label>
                                        <input type="text" class="form-control"   v-bind:value="msg.gender">
                                    </div>
                                </div>
                            </div>
                            <input id="change" type="submit" class="btn btn-round btn-primary" value="确定">
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
                                <h5 class="title">@{{msg.email}}</h5>
                                <h5 class="title">@{{msg.name}}</h5>
                            </a>
                            <p class="description"  style="color: #000">
                                @{{msg.age}}岁
                            </p>
                        </div>
                        <p class="description text-center" style="color: #000">
                            @{{msg.height}}
                            <br> @{{msg.weight}}<br><br>
                        所属家庭账号@{{msg.familyID}}
                        </p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <script>
        var vm=new Vue({
            el:'#con',
            data:{
                msg: {id:1,email:'123@qq.com',familyID:1,name:'mldwyy',age:18,gender:'女',height:'170cm',weight:'40kg'}
            }
        });
    </script>
@endsection