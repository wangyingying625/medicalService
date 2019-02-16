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
                <a class="navbar-brand" href="/familyAdd">创建家庭</a>
                <a class="navbar-brand" href="/pictures">退出家庭</a>
            </div>

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
    <div class="content" id="con">
        <div class="row" >
            <div class="col-md-12">
                <div class="card card-user col-md-3"  v-for="(item,i) in familyList">
                    <div class="image">
                    </div>
                    <div class="card-body">
                        <div class="author">
                                <h5 class="title" style="color:#f96332">@{{ item.email }}</h5>
                                <h5 class="title"  style="color:#f96332">@{{ item.name }}</h5>
                            <p class="description">
                            <p class="title">@{{ item.age }}岁</p>
                            </p>
                        </div>
                        <p class="description text-center">
                            @{{ item.height }}
                            <br> @{{ item.weight }}<br>
                            <a href="#" class="btn btn-round btn-primary">查看病历</a>
                            <a href="#"  class="btn btn-round btn-default">删除家人</a>
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
                familyList: [{id:1,email:'123@qq.com',familyId:1,name:'name1',age:18,gender:'女',height:'170cm',weight:'40kg'},
                    {id:1,email:'12223@qq.com',familyId:1,name:'name2',age:19,gender:'女',height:'170cm',weight:'40kg'},
                    {id:1,email:'123333@qq.com',familyId:1,name:'name3',age:20,gender:'女',height:'170cm',weight:'40kg'}]
            }
        });
    </script>
@endsection