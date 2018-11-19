@extends('backend.layouts.app')
@section('title', $title = '添加角色')
@section('breadcrumb')
    <a href="">系统设置</a>
    <a href="">用户管理</a>
@endsection

@section('content')
    <div class="layui-main">

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>{{ $title }}</legend>
        </fieldset>

		<form class="layui-form layui-form-pane" method="POST" action="/admin/role/create">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-block">
                    <input type="text" name="role_name" lay-verify="required" autocomplete="off" placeholder="请输入" class="layui-input" value="" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">角色级别</label>
                <div class="layui-input-block">
                    <input type="text" name="level"  placeholder="请输入" autocomplete="off" class="layui-input" value="" >
                </div>
            </div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">角色描述</label>
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