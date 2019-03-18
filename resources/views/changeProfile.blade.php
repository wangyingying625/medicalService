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
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">修改资料</h5>
                    </div>
                    <div class="card-body">
                        <form action="/user/update" method="post">
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input type="email" class="form-control" disabled="" placeholder="Company"  name="email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" placeholder="Username" name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label>生日</label>
                                        <input  class="form-control"  value="{{ Auth::user()->birthday }}" name="birthday" id="birthday">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>体重</label>
                                        <input type="text" class="form-control" name="weight" value="{{ Auth::user()->weight }}" >kg
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="form-group">
                                        <label>身高</label>
                                        <input type="text" class="form-control" name="height" value="{{ Auth::user()->height }}" >cm
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label>性别</label>
                                        {{--<input type="text" class="form-control" name="sex" value="{{ Auth::user()->sex }}"  >--}}
                                        <select name="city" lay-verify="" class="form-control" >
                                            <option value="">保密</option>
                                            <option value="男"
                                                    @if(Auth::user()->sex == "男")
                                                    selected
                                                    @endif >男
                                            </option>
                                            <option value="女"
                                                    @if(Auth::user()->sex == "女")
                                                    selected
                                                    @endif>女</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            {{ csrf_field() }}
                            <input id="change" type="submit" class="btn btn-round btn-primary" value="确定">
                        </form>

                    </div>
                </div>
            </div>

            {{--<div class="col-md-4">--}}
                {{--<div class="card card-user">--}}
                    {{--<div class="image">--}}
                    {{--</div>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="author">--}}
                            {{--<a href="#">--}}
                                {{--<h5 class="title">@{{msg.email}}</h5>--}}
                                {{--<h5 class="title">@{{msg.name}}</h5>--}}
                            {{--</a>--}}
                            {{--<p class="description"  style="color: #000">--}}
                                {{--@{{msg.age}}岁--}}
                            {{--</p>--}}
                        {{--</div>--}}
                        {{--<p class="description text-center" style="color: #000">--}}
                            {{--@{{msg.height}}--}}
                            {{--<br> @{{msg.weight}}<br><br>--}}
                        {{--所属家庭账号@{{msg.familyID}}--}}
                        {{--</p>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#birthday' //指定元素
            });
        });
    </script>
@endsection