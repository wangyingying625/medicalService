<link href="{{ asset('layui-v2.4.5/layui/css/layui.css') }}" rel="stylesheet" />
<script src="{{ asset('layui-v2.4.5/layui/layui.js')}}"></script>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>家庭申请</legend>
</fieldset>

<div class="layui-form">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>用户名</th>
            <th>同意</th>
            <th>拒绝</th>
        </tr>
        </thead>
        <tbody>
        @foreach($members as $member)
            <tr id="invite{{ $member['id'] }}">
                <td>{{ $member['name'] }}</td>
                <td><button class="layui-btn layui-btn-normal layui-btn-radius" onclick="apply({{ $member['id'] }})">同意</button>
                </td>
                <td> <button class="layui-btn layui-btn-danger layui-btn-radius" onclick="apply({{ $member['id'] }})">拒绝</button>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    
    function apply(id) {
        var xhr=new XMLHttpRequest();
        xhr.open('get','/family/accept/'+id);
        xhr.onreadystatechange = function(){
            //若响应完成且请求成功
            if(xhr.readyState === 4 && xhr.status === 200){
                //do something, e.g. request.responseText
                layui.use('layer', function() {
                    var layer = layui.layer;
                    layer.msg(xhr.response);
                    var el=document.getElementById("invite"+id);
                    console.log(el);
                    el.remove()
                });
            }
        };
        xhr.send(null);
    }
</script>