@extends('layouts.app')

@section('title')登录@endsection

@section('content')

    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />

    <div class="layui-row">
        <div class="layui-col-md4 layui-col-md-offset4">
            <div class="login-title">58日志系统</div>
        </div>
    </div>

    <div class="layui-row">
        <div class="layui-col-md4 layui-col-md-offset4">
            <div class="grid-login">
                <div class="login-form">
                    <form class="layui-form layui-form-pane"  method="POST" action="/auth/login">
                        <div class="layui-form-item">
                            <input id="user_name" type="user_name" name="user_name"  autocomplete="off" placeholder="user_name" value="" autofocus class="layui-input">
                        </div>
                        <div class="layui-form-item">
                            <input type="password" name="password"  autocomplete="off" placeholder="password" class="layui-input">
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <input type="verify" name="captcha" autocomplete="off" placeholder="VerifyCode"  class="layui-input">
                            </div>
							<img id='captcha_img' src="/auth/captcha" onclick="this.src='/auth/captcha?'+Math.random()" />
                          </div>
                        </div>
                        <div class="layui-form-item">
                            <button type="submit" class="layui-btn  layui-btn-fluid" lay-submit="" lay-filter="login">登录</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection