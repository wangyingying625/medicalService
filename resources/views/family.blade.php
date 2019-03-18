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
                {{--<a class="navbar-brand" href="/familyAdd">邀请成员</a>--}}
                <button class="layui-btn layui-btn-primary layui-btn-radius" onclick="invite()"  >邀请成员</button>
                <button class="layui-btn layui-btn-danger layui-btn-radius" onclick="disband()">解散家庭</button>
                {{--<a class="navbar-brand" href="/pictures">退出家庭</a>--}}

            </div>

            <div class="navbar-wrapper">
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
                            @{{ item.height }}KG
                            <br> @{{ item.weight }}CM<br>
                            <a href="#" class="btn btn-round btn-primary">查看病历</a>
                            <a href="family/del"  class="btn btn-round btn-default">删除家人</a>
                        </p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    {!! $members  !!}
    {!! $family !!}
    <script>
        var vm=new Vue({
            el:'#con',
            data:{
                familyList: {!! $members  !!}
            }
        });
        function invite() {
            layui.use('layer', function(){
                var layer = layui.layer;

                layer.open({
                    type: 1,
                    area: ['400px', '160px'],
                    closeBtn: 2,
                    title: ['邀请用户', 'font-size:18px;'],
                    content: '<form class="layui-form" action="/family/invite" method="post">\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">用户名</label>\n' +
                    '    <div class="layui-input-block">\n' +
                    '@csrf' +
                    '      <input type="text" name="name" required  lay-verify="required" placeholder="请输入受邀请用户用户名" autocomplete="off" class="layui-input">\n' +
                    '<input type="hidden" name="familyId" value="{{ $family{'id'} }}">' +
                    '    </div>\n' +
                    '  </div>' +
                    '  <div class="layui-form-item">\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <button class="layui-btn" lay-submit lay-filter="formDemo">邀请</button>\n' +
                    '    </div>\n' +
                    '  </div>' +
                    '</form>' //这里content是一个普通的String
                });
            });
        }
        
        function disband() {
            layui.use('layer', function(){
                var layer = layui.layer;

                layer.open({
                    title: false,
                    content: '确认解散该家庭吗？',
                    btn: ['确认', '取消'],
                    success: function(layero){
                    var btn = layero.find('.layui-layer-btn');
                    btn.find('.layui-layer-btn0').attr({
                        href: '/'
                        ,target: '_blank'
                    });
                }

                });
            })
                }


    </script>
@endsection