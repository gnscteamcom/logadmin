<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
			<li class="layui-nav-item layui-nav-itemed">
				<a class="">系统设置</a>
				<dl class="layui-nav-child">
					<dd _class="layui-this" id="">
						<a href="/admin/user/index">用户管理</a>
					</dd>                           
				</dl>
				<dl class="layui-nav-child">
					<dd _class="layui-this" id="">
						<a href="/admin/role/index">角色管理</a>
					</dd>                           
				</dl>
				<dl class="layui-nav-child">
					<dd _class="layui-this" id="">
						<a href="/admin/menu/index">菜单管理</a>
					</dd>                           
				</dl>
			</li>
			<li class="layui-nav-item layui-nav-itemed">
				<a class="">日志内容</a>
				<dl class="layui-nav-child">
					<dd _class="layui-this" id="">
						<a href="/log_detail/list">日志报表</a>
					</dd>
				</dl>
			</li>
            {{--@foreach(config('administrator.menu') as $key1 => $menu)--}}
                {{--@if(call_user_func($menu['permission']))--}}
                <li class="layui-nav-item layui-nav-itemed">
                    {{--<a class="" href="">{{ $menu['text'] }}</a>--}}
                    <dl class="layui-nav-child">
                        {{--@foreach($menu['children'] as $key2 => $item)--}}
                            {{--@if(call_user_func($item['permission']))--}}
                            {{--<dd _class="layui-this" id="nav_{{$key1}}_{{$key2}}"><a href="@if(!empty($item['link'])){{$item['link']}}@elseif(!empty($item['route'])){{route($item['route'], $item['params'])}}@if(!empty($item['query']))?{{implode('&',$item['query'])}}@endif @else javascript:;@endif">{{ $item['text'] }}</a></dd>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    </dl>
                </li>
                {{--@endif--}}
            {{--@endforeach--}}
        </ul>
    </div>
</div>
