@extends('backend.layouts.app')

@section('title', $title = '添加菜单' )

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

		<form class="layui-form layui-form-pane" method="POST" action="/admin/menu/create">
            <div class="layui-form-item">
                <label class="layui-form-label">菜单名称</label>
                <div class="layui-input-block">
                    <input type="text" name="menu_name" lay-verify="required" autocomplete="off" placeholder="请输入菜单名称" class="layui-input" value="" >
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">菜单级别</label>
                <div class="layui-input-block">
                    <input type="text" name="level" autocomplete="off"  class="layui-input" value="{{$level}}" readonly  >
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">父菜单</label>
                <div class="layui-input-block">
                    <input type="hidden" name="parent_id" autocomplete="off"  class="layui-input" value="{{$parent_id}}"  >
                    <input type="text" name="parent_name" autocomplete="off"  class="layui-input" value="{{$parent_name}}" readonly  >
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">链接</label>
                <div class="layui-input-block">
                    <input type="text" name="link"  autocomplete="off" placeholder="请输入链接" class="layui-input" value="" >
                </div>
            </div>						
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">菜单描述</label>
                <div class="layui-input-block">
					<textarea placeholder="请输入内容" name="description" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">添加</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </form>
    </div>
	
@endsection
@section('scripts')
@endsection