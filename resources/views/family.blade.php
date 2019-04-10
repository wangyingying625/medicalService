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
                    <legend style="width: 200px">{{ $family['name'] }}</legend>
                @if(Auth::user()->status=='admin')
                <button class="layui-btn layui-btn-primary layui-btn-radius" onclick="invite()"  >邀请成员</button>
                <button class="layui-btn layui-btn-danger layui-btn-radius" onclick="disband()">解散家庭</button>
                @if(\App\User::where('family_id',$family['id'])->where('status','joining')->count())
                <button class="layui-btn layui-btn-warm layui-btn-radius" onclick="showApply()">成员申请 <span class="layui-badge layui-bg-gray">{{ \App\User::where('family_id',$family['id'])->where('status','joining')->count() }}</span></button>
                @endif
                @elseif(Auth::user()->status=='member')
                    <button class="layui-btn layui-btn-danger layui-btn-radius" onclick="quit()">退出家庭</button>

                @endif

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
                            <div>
                            <span class="layui-badge layui-bg-orange"  v-if="isSelf(item.id)">自己</span>
                            <span class="layui-badge layui-bg-red"  v-if="isAdmin(item.status)">管理员</span>
                            <span class="layui-badge layui-bg-gray"  v-if="!isMember(item.status)&!isAdmin(item.status)">待加入</span>
                            <span class="layui-badge layui-bg-green"  v-if="isMember(item.status)&!isSelf(item.id)">已加入</span>
                            </div>
                            <img :src="item.avatar" class="layui-circle" width="150px" height="150px">

                            <h5 class="title" style="color:#f96332">@{{ item.email }}</h5>
                                <h5 class="title"  style="color:#f96332">@{{ item.name }}</h5>
                            <p class="description">
                            <p class="title">@{{ item.age }}岁</p>
                            </p>
                        </div>
                        <p class="description text-center">
                            @{{ item.height }}KG
                            <br> @{{ item.weight }}CM<br>
                            <a :href="'/indicator/record/' + item.id" class="btn btn-round btn-primary">查看病历</a>
                            @if(Auth::user()->status=='admin')
                            <a :href="'/family/del/' + item.id"  class="btn btn-round btn-default" v-if="!isSelf(item.id)">删除家人</a>
                            @endif
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
                familyList: {!! $members  !!}
            },
            methods: {
                isSelf: function (id) {
                    if (id == {{ Auth::id() }}){
                        return 1;
                    }else {
                        return 0;
                    }
                },
                isMember: function (status,id) {
                    if (status=='member'){
                        return 1;
                    }else {
                        return 0;
                    }

                },
                isAdmin: function (status) {
                    if (status=='admin'){
                        return 1;
                    }else {
                        return 0;
                    }
                }
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
        function showApply() {
            layui.use('layer', function(){
                var layer = layui.layer;

                layer.open({
                    title: false,
                    type: 2,
                    area: ['600px', '300px'],
                    content: '/family/newMember',
                    cancel: function(index, layero){
                        layer.close(index);
                        location.reload();

                    }

                });
            })
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
                        href: '/family/dissolve'
                        ,target: '_blank'
                    });
                }

                });
            })
                }
        function quit() {
            layui.use('layer', function(){
                var layer = layui.layer;

                layer.open({
                    title: false,
                    content: '确认退出该家庭吗？',
                    btn: ['确认', '取消'],
                    success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                        btn.find('.layui-layer-btn0').attr({
                            href: '/family/quit'
                        });
                    }

                });
            })
        }


    </script>
@endsection