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
                        <h4 class="card-title">模板上传</h4>
                    </div>
                    <form class="layui-form" action="/indicator/temp/ocr" method="post" id="form">
                        {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                        <div class="temp">
                            <div style="width: 60%;display: inline-block;margin-left:10px">
                                <select name="temp" lay-verify="">
                                    <option value="">请选择已有模板</option>
                                    @foreach($templates as $template)
                                    <option value="{{ $template['id'] }}">{{ $template['name'] }}</option>
                                    @endforeach
                                    {{--<option value="02">血常规</option>--}}
                                </select>
                            </div>
                            <div style="width: 30%;display: inline-block">
                                <button type="button" class="btn btn-primary btn-block layui-btn" style="width: 100px;margin-left: 20px" onclick="createT()">新建模板</button>
                            </div>
                        </div>
                        <div class="layui-upload">
                            <button type="button" class="btn btn-primary btn-block layui-btn" style="width: 115px;margin-left: 20px"  id="upload">按列上传图片</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="demo1">
                                <p id="demoText"></p>
                            </div>
                        </div>

                        @csrf

                        <br>
                        <div class="layui-inline">
                            <label class="layui-form-label">日期</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="test5" placeholder="检查的时间" name="date">
                            </div>
                        </div>
                        <input type="submit" style="margin-top: 30px" class="btn btn-primary btn-block"  id='submit'  value="确定" disabled>
                    </form>
                    {{--</form>--}}
                </div>

                <div class="card card-upgrade">
                    <div class="card-header text-center">
                        <h4 class="card-title">上传历史</h4>
                    </div>
                </div>

            </div>
        </div>



    </div>

    <script>
        layui.use('form', function(){
            var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
            form.render();
            form.on('switch(switchTest)', function(data){
//                layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
//                    offset: '6px'
//                });
                layer.tips('如之前提交过相同格式的病例单请勾选此项，否则请勿勾选', data.othis)
            });
        });
        var i=0;
        function addRow() {
            var Tr=document.createElement("tr");
            var Td=document.createElement("td");
            var string='<tr><td><input required name="temp['+i+'][name_ch]" type="text"></td><td><input  name="temp['+i+'][name_en]"  type="text"></td><td><input type="text"  name="temp['+i+'][upper_limit]" ></td><td><input type="text"  name="temp['+i+'][lower_limit]" ></td><td><input type="text"  name="temp['+i+'][unit]" ></td><td><p style="cursor: pointer" onclick="del(this)">删除</p></td></tr>'
            $("#tBody").append(string);
            i++;
        }
        function createT () {
            layer.open({
                type: 1,
                title: "新建模板",
                area: ['1200px','500px'],
                content: '<form id="create" action="/indicator/temp/create" method="post">@csrf<table class="layui-table"><colgroup><col width="150"><col width="200"><col></colgroup><thead><tr><th>中文名</th><th>英文名</th><th>上限</th><th>下限</th><th>单位</th><th><p style="cursor: pointer;color: #FF5722"  onclick="addRow()">添加一行</p></th></tr></thead><tbody id="tBody"></tbody></table>        <input class="form-control"   type="text" placeholder="请输入模板名称" required name="tempName"><button type="submit" class="btn btn-primary btn-block" style="width: 100px;margin-left:990px">确定</button></form>'
            });
        };
        function del(e) {
            /*console.log(e);
            console.log(typeof(e))*/
            var t=$(e).parent().parent("tr").remove();
        }
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
                        var subtn = document.getElementById('submit');
                        subtn.disabled = false;
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