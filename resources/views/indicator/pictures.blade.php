@extends('indicator.head')
@section('record')
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
                        <br>
                        <div class="layui-inline">
                            <label class="layui-form-label">日期</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="test5" placeholder="年-月-日 时-分-秒" name="date">
                            </div>
                        </div>

                        <input type="submit" style="margin-top: 30px" class="btn btn-primary btn-block"  value="确定">
                    </form>



                    {{--</form>--}}
                </div>

                <div class="card card-upgrade">
                    <div class="card-header text-center">
                        <h4 class="card-title">上传历史</h4>
                    </div>
                    {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                    <ul class="layui-timeline">
                        @foreach($images as $image)
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis"></i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">{{ $image['created_at'] }}</h3>
                                    <h2 class="layui-timeline-title">{{ $image['type'] }}</h2>
                                    <a href="{{ asset('storage/'.$image['name']) }}"><img src="{{ asset('storage/'.$image['name']) }}" width="200px"></a>
                                </div>
                            </li>
                            @endforeach
                        {{--<li class="layui-timeline-item">--}}
                            {{--<i class="layui-icon layui-timeline-axis"></i>--}}
                            {{--<div class="layui-timeline-content layui-text">--}}
                                {{--<h3 class="layui-timeline-title">8月18日</h3>--}}
                                {{--<p>--}}
                                    {{--layui 2.0 的一切准备工作似乎都已到位。发布之弦，一触即发。--}}
                                    {{--<br>不枉近百个日日夜夜与之为伴。因小而大，因弱而强。--}}
                                    {{--<br>无论它能走多远，抑或如何支撑？至少我曾倾注全心，无怨无悔 <i class="layui-icon"></i>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="layui-timeline-item">--}}
                            {{--<i class="layui-icon layui-timeline-axis"></i>--}}
                            {{--<div class="layui-timeline-content layui-text">--}}
                                {{--<div class="layui-timeline-title">过去</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    </ul>

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
        layui.use('laydate', function() {
            var laydate = layui.laydate;

            laydate.render({
                elem: '#test5'
                ,type: 'datetime'
            });
        });
    </script>
@endsection