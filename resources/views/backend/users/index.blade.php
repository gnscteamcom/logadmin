@extends('backend.layouts.app')

@section('title', $title = '用户列表')

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

    <a href="/admin/user/create_info" class="layui-btn">添加</a>
    <div class="layui-form">
        @if($total)
			<table class="layui-table">
				<colgroup>
					<col width="20">
					<col width="50">
					<col width="50">
					<col width="50">
					<col width="100">
					<col width="150">
					<col width="150">
					<col width="50">
					<col width="200">
				</colgroup>
				<thead  align="center">
				<tr>
					<th style="text-align:center;">#</th>
					<th style="text-align:center;">用户名</th>
					<th style="text-align:center;">邮箱</th>
					<th style="text-align:center;">手机</th>
					<th style="text-align:center;">权限</th>
					<th style="text-align:center;">注册时间</th>
					<th style="text-align:center;">最后登录时间</th>
					<th style="text-align:center;">状态</th>
					<th style="text-align:center;">操作</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($data as $index => $user)
					<tr align="center">
						<td><?php echo $index+1;?></td>
						<td>{{ $user['user_name'] }}</td>
						<td>{{ $user['email'] }}</td>
						<td>{{ $user['telephone'] }}</td>
						<td>{{ $user['role_name'] }}</td>
						<td>{{ $user['create_time'] }}</td>
						<td>{{ $user['last_login_time'] }}</td>
						<td><?php echo $stausList[$user['status']];?> </td>
						<td>
							<!--<a href="" class="layui-btn layui-btn-sm">重置密码</a>-->
							<a href="/admin/user/update_info?user_id={{ $user['id'] }}" class="layui-btn layui-btn-sm layui-btn-normal">编辑</a>
							<a href="javascript:;" data-url="/admin/user/delete?user_id={{ $user['id'] }}" class="layui-btn layui-btn-sm layui-btn-danger form-delete">删除</a>
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