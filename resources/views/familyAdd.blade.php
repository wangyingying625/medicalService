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
                @if(Auth::user()->status == 'inviting' )
                <button class="layui-btn layui-btn-warm" onclick="invited()">家庭邀请<span class="layui-badge layui-bg-gray">1</span></button>
                @endif
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content" id="con">
        <div class="row">
            <div class="col-md-8" style="margin: 0 auto">
                <div class="card">
                    <div class="card-body">
                        <div class="typography-line" style="width: 100%;margin:0;padding:0;text-align: center">
                            <h5>
                                您还未加入任何家庭 </h5>


                        </div>
                        <div class="row" style="width: 100%;align-items: center;justify-content: center">
                            <div class="col-md-4">
                                <router-link to="/createF" class="btn btn-primary btn-block" {{--href='/family/createFamily'--}}>创建家庭</router-link>
                            </div>
                            <div class="col-md-4">
                                <router-link to="/findF" class="btn btn-primary btn-block">加入家庭</router-link>
                            </div>

                        </div>
                        <router-view></router-view>
                    </div>
                </div>
                @if(Auth::user()->status == 'joining')
                <div class="card">
                    <div class="card-body">
                        <div class="typography-line" style="width: 100%;margin:0;padding:0;text-align: center">
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                <legend> 正在申请加入<font color="#dc143c">{{ \App\Family::find(Auth::user()->family_id)->name  }}</font></legend>
                            </fieldset>
                            <button class="layui-btn layui-btn-danger layui-btn-radius">取消</button>

                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                <legend> 等待管理员同意</legend>
                            </fieldset>
                            <div class="layui-progress">
                                <div class="layui-progress-bar layui-bg-green" lay-percent="50%" style="width: 50%;"></div>                            </div>

                        </div>
                        <div class="row" style="width: 100%;align-items: center;justify-content: center">


                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        var findF={
            template:'<div ><input id="familyId" type="text" class="form-control" placeholder="请输入想要加入的家庭名"><input  type="button"  onclick="addF()" class="btn btn-round btn-primary" style="float: right" value="确定"></div>'
        };
        var createF={
            template:'<div ><form action="/family/createFamily" method="post">{{ csrf_field() }} <input name="name" id="familyName" type="text" class="form-control" placeholder="请输入新建的家庭名"><input type="submit" class="btn btn-round btn-primary" style="float: right" value="创建"></form></div>'
        };
        var routerObj=new VueRouter({
            routes:[
                {path:'/findF',component:findF},
                {path:'/createF',component:createF},
            ]
        });
        function addF() {
            var id=document.getElementById("familyId").value;
            var xhr=new XMLHttpRequest();
            xhr.open('get','/family/apply/'+id);
            xhr.onreadystatechange = function(){
                //若响应完成且请求成功
                if(xhr.readyState === 4 && xhr.status === 200){
                    //do something, e.g. request.responseText
                    layui.use('layer', function() {
                        var layer = layui.layer;
                        layer.msg(xhr.response);
                        setTimeout("javascript:location.reload()", 1000);


                    });
                }
            };
            xhr.send(null);
        }
        var vm=new Vue({
            el:'#con',
            data:{
            },
            methods:{
            },
            router:routerObj
        });
        @if(Auth::user()->status == 'inviting' )
        function invited() {
            layui.use('layer', function(){
                var layer = layui.layer;

                layer.open({
                    title: false,
                    content: '您有一条来自<font size="3" color="red">{{ App\Family::where('id',Auth::user()->family_id)->get()[0]->name }}</font>家庭的邀请，是否确认加入？',
                    btn: ['加入', '取消'],
                    success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                        btn.find('.layui-layer-btn0').attr({
                            href: '/family/accept'
                        });
                    }

                });
            })
        }
        @endif
    </script>
@endsection