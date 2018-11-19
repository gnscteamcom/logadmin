@extends('backend.layouts.app')

@section('title', $title = '添加用户' )

@section('breadcrumb')
    <a href="">系统设置</a>
    <a href="">用户管理</a>
	<a href="">{{ $title }}</a>
@endsection

@section('content')
    <div class="layui-main">

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>{{ $title }}</legend>
        </fieldset>

		<form class="layui-form layui-form-pane" method="POST" action="/admin/user/create">
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input type="text" name="user_name" lay-verify="required" autocomplete="off" placeholder="请输入标题" class="layui-input" value="" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input type="text" name="password" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value="" >
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-block">
                    <input type="email" name="email" lay-verify="required|email" placeholder="请输入" autocomplete="off" class="layui-input" value="" >
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="telephone" placeholder="请输入" autocomplete="off" class="layui-input" value="" >
                </div>
            </div>	
            <div class="layui-form-item">
                <label class="layui-form-label">角色</label>
                <div class="layui-input-block">
					<select name='role_id'>
					@foreach ($role_list as $index => $value)
						<option value ="{{$index}}" > {{$value}} </option>
					@endforeach
					</select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">个人简介</label>
                <div class="layui-input-block">
					<textarea placeholder="请输入内容" name="description" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </form>
    </div>
	
@endsection
@section('scripts')
@endsection