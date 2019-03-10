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
                <a class="navbar-brand" href="/record">病历图表</a>
                <a class="navbar-brand" href="/pictures">图片记录</a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" title="退出" href="{{ route('login') }}">
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
            <div class="col-md-8 ml-auto mr-auto">
                <div class="card card-upgrade">
                    <div class="card-header text-center">
                        <h4 class="card-title">上传图片</h4>
                    </div>
                    {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                        <div class="layui-upload">
                            <button type="button" class="btn btn-primary btn-block layui-btn" style="width: 100px;margin-left: 20px"  id="upload">上传图片</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="demo1">
                                <p id="demoText"></p>
                            </div>
                        </div>
                    <form class="card-body" action="/ocr/" method="post" id="form">
                        @csrf
                        <input class="form-control"  type="text" placeholder="请输入您的检查名称" required name="type">
                        <input type="submit" style="margin-top: 30px" class="btn btn-primary btn-block"  value="确定">
                    </form>

                    {{--</form>--}}
                </div>
            </div>
        </div>



    </div>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload'
                ,field: 'image'
                ,url: '/indicator/upload'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result);
                    });
                }
                ,done: function(res, index, upload){
                    //如果上传失败
                    if(res.id == 0){
                        return layer.msg('上传失败');
                    }
                    if(res.id){
                        layer.msg('上传成功');
                        var form = document.getElementById('form');
                        var imageId = document.createElement("input");
                        imageId.type = "hidden";
                        imageId.name = 'image_id';
                        imageId.value = res.id;
                        form.appendChild(imageId);
                    }
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
    </script>
@endsection