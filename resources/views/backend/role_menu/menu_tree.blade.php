@extends('backend.layouts.app')
@section('title', $title = '添加角色')
@section('breadcrumb')
    <a href="">系统设置</a>
    <a href="">用户管理</a>
@endsection

@section('content')



<div class="layui-form">
	<form class="layui-form layui-form-pane" method="POST" action="/admin/role_menu/update" >
		<input name='role_id' value='{{$role_id}}' hidden='hidden' >
		<table class="layui-table">
			<thead>
				<tr>
					<th style="width:10px">
						<input type="checkbox" name="menuTreeCheckbox" lay-skin="primary" lay-filter="allChoose">
						<div class="layui-unselect layui-form-checkbox" lay-skin="primary">
							<i class="layui-icon layui-icon-ok"></i>
						</div>
					</th>
					<th class="value_col">菜单名称</th>
				</tr>
			</thead>
			<tbody>		
			@foreach($menuTreeData as $index => $menu)
				<tr class="layui-anim layui-anim-fadein" id="2">
					<td>
					<input type="checkbox" name="menuTreeCheckbox[]" lay-skin="primary" lay-filter="*" value="{{$menu['id']}}" {{$menu['is_checked']}}>
					<div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
						<i class="layui-icon layui-icon-ok"></i>
					</div>
					</td>
					<td class="value_col" style="">
						<li data-spread="true">
							<i class="layui-icon layui-tree-spread"></i>
							<i class="layui-icon layui-tree-branch folder"></i>
							<cite>{{$menu['name']}}</cite>
						</li>
					</td>
				</tr>			
			@endforeach	
			</tbody>
		</table>

		<button class="layui-btn">提交</button>
	</form>
</div>






















@endsection
@section('scripts')
@endsection



