@extends('backend.layouts.app')

@section('title', $title = '菜单管理')

@section('breadcrumb')
    <a href="">系统设置</a>
    <a href="">用户管理</a>
    <a href="">{{$title}}</a>
@endsection

@section('content')
<div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>{{$title}}</legend>
    </fieldset>

    <a href="/admin/menu/create_info" class="layui-btn">添加一级菜单</a>
    <div class="layui-form">
        @if($total)
			<table class="layui-table">
				<colgroup>	
				</colgroup>
				<thead  align="center">
				<tr>
					<th style="text-align:center;">菜单名称</th>
					<th style="text-align:center;">菜单级别</th>
					<th style="text-align:center;">父菜单</th>
					<th style="text-align:center;">链接</th>
					<th style="text-align:center;">创建时间</th>
					<th style="text-align:center;">创建人</th>
					<th style="text-align:center;">操作</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($menuTreeList as $index => $menu)
					<tr>
						<td>{{ $menu['name'] }}</td>
						<td align="center">{{ $menu['level'] }}</td>
						<td align="center">{{ $menu['parent_name'] }}</td>			
						<td align="center">{{ $menu['link'] }}</td>
						<td align="center">{{ $menu['create_time'] }}</td>
						<td align="center">{{ $menu['user_name'] }}</td>
						<td align="center">				
							<a href="/admin/menu/create_sub_info?menu_id={{ $menu['id'] }}" class="layui-btn layui-btn-sm">添加子菜单</a>
							<a href="/admin/menu/update_info?menu_id={{ $menu['id'] }}" class="layui-btn layui-btn-sm layui-btn-normal">编辑</a>
							<a href="" data-url="//" class="layui-btn layui-btn-sm layui-btn-danger form-delete">删除</a>
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
@endsection