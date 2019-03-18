@extends('layouts.app')
@section('content')
<script>
    layui.use('layer', function(){
        var layer = layui.layer;

        layer.open({
            title: '{{ $title }}',
            content: '{{ $message }}',
            success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.find('.layui-layer-btn0').attr({
                    href: '{{ $url }}'
                });
            }

        });

        setTimeout("javascript:location.href='{{ $url }}'", 5000);
    });

</script>
@endsection