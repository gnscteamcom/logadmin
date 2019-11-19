<div class="layui-header header">
    <div class="layui-logo">日志管理系统</div>
    <ul class="layui-nav layui-layout-left">
        {{--<!-- @foreach(config('administrator.shortcut') as $key => $menu)-->--}}
            {{--<!-- @if(call_user_func($menu['permission']))-->--}}
            <li class="layui-nav-item">
			{{--<!--<a href="@if(!empty($menu['link'])) {{$menu['link']}} @elseif(!empty($menu['route'])) {{route($menu['route'], $menu['params'])}} @else javascript:; @endif">{{ $menu['text'] }}</a>--}}
                {{--<!--@if($menu['children'])-->--}}
                <dl class="layui-nav-child">
                   {{--<!-- @foreach($menu['children'] as $key => $item)-->--}}
                       {{--<!-- @if(call_user_func($item['permission']))-->--}}
                            <dd>{{--<!--<a href="@if(!empty($item['link'])){{$item['link']}}@elseif(!empty($item['route'])){{route($item['route'], $item['params'])}}@else javascript:;@endif">{{ $item['text'] }}</a>-->--}}</dd>
                       {{--<!-- @endif-->--}}
                    {{--<!--@endforeach-->--}}
                </dl>
               {{--<!-- @endif-->--}}
            </li>
           {{--<!-- @endif-->--}}
        {{--<!--@endforeach-->--}}
    </ul>
    <ul class="layui-nav layui-layout-right">

        @guest
        <li class="layui-nav-item"><a href="{{ route('administrator.login') }}">登录</a></li>
        @else
        <li class="layui-nav-item">
            <a href="javascript:;">
                <img src="/58logo.png" class="layui-nav-img" />
                {{ Auth::user()->user_name }}
            </a>
            <dl class="layui-nav-child layui-nav-header">
                <dd><a href="/admin/user/info">基本资料</a></dd>
                <dd><a href="">修改密码</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item">
            <a href="/auth/logout" onclick="">退出</a>
        </li>
        @endguest
    </ul>
</div>
