@extends('backend.layouts.app')

@section('title', $title = '角色列表')

@section('breadcrumb')
    <a href="">系统设置</a>
    <a href="">角色管理</a>
    <a href="">{{$title}}</a>
@endsection

@section('content')
<div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>{{$title}}</legend>
    </fieldset>

    <a href="/admin/role/create_info" class="layui-btn">添加</a>

    <div class="layui-form">
        @if($total)
        <table class="layui-table">
            <colgroup>
                <col width="40">
                <col width="120">
                <col width="300">
                <col width="200">
                <col width="200">
            </colgroup>
            <thead>
            <tr>
                <th style="text-align:center;">#</th>
                <th style="text-align:center;">角色名称</th>
                <th style="text-align:center;">角色描述</th>
				<th style="text-align:center;">创建时间</th>
                <th style="text-align:center;">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $index => $role)
            <tr align="center">
                <td><?php echo $index+1;?></td>
                <td>{{ $role['role_name']  }}</td>
                <td>{{ $role['description']  }}</td>
                <td>{{ $role['create_time']  }}</td>
                <td>
                    <a href="/admin/role_menu/update_info?role_id={{ $role['id'] }}" class="layui-btn layui-btn-sm layui-btn-normal">编辑权限</a>
                    <a href="javascript:;" data-url="/admin/role/delete?role_id={{ $role['id'] }}" class="layui-btn layui-btn-sm layui-btn-danger form-delete">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <form id="delete-form" action="" method="POST" style="display:none;">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
        </form>
        <div id="paginate-render"></div>
        @else
            <br />
            <blockquote class="layui-elem-quote">暂无数据!</blockquote>
        @endif

    </div>
</div>
@endsection
@section('scripts')
@include('backend.layouts._paginate',[ 'limit' => $per_page,'count' => $total ])
@endsection