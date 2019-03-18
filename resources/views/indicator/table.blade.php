@extends('layouts.app')
@section('content')
    <form action="/indicator/saveData" method="post">
        @csrf

        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>id</th>
                <th>英文名</th>
                <th>中文名</th>
                <th>下限</th>
                <th>上限</th>
                <th>值</th>
                <th>单位</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach($indicators as $indicator)
                <tr>
                    <td><input type="text" name="{{ $indicator->id }}[id]" value="{{ $indicator->id }}" disabled></td>
                    <td><input type="text" name="{{ $indicator->id }}[name_en]" value="{{ $indicator->name_en }}"></td>
                    <td><input type="text" name="{{ $indicator->id }}[name_ch]" value="{{ $indicator->name_ch }}"></td>
                    <td><input type="text" name="{{ $indicator->id }}[upper_limit]" value="{{ $indicator->upper_limit }}"></td>
                    <td><input type="text" name="{{ $indicator->id }}[lower_limit]" value="{{ $indicator->lower_limit }}"></td>
                    <td><input type="text" name="{{ $indicator->id }}[value]" value="{{ $indicator->value }}"></td>
                    <td><input type="text" name="{{ $indicator->id }}[unit]" value="{{ $indicator->unit }}"></td>
                </tr>

                @endforeach
            </tr>

            </tbody>
        </table>
        <div align="center">
        <button class="layui-btn" lay-submit="" lay-filter="demo1">确认信息</button>
        </div>
    </form>


@endsection