@extends('backend.layouts.app')

@section('title', $title = '日志报表')

@section('breadcrumb')
    <a href="">日志内容</a>
    <a href="">日志报表</a>
    <a href="">{{$title}}</a>
@endsection

@section('content')

<script src="{{asset('js/laydate/laydate.js')}}"></script>
<script src="{{asset('js/layui/layui.js')}}"></script>


<div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>{{$title}}</legend>
    </fieldset>
	
	<form action="" method="get">
		操作日期：
		<input type="text" value="{{$operate_start_date}}" name='operate_start_date' id='operate_start_date'  size="8" readonly >
		--
		<input type="text" value="{{$operate_end_date}}" name='operate_end_date' id='operate_end_date'  size="8" readonly >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--
		时间范围：
		<input type="text" value="{{$operate_start_time}}" name='operate_start_time' id='operate_start_time'  size="4" readonly >
		--
		<input type="text" value="{{$operate_end_time}}" name='operate_end_time' id='operate_end_time'  size="4" readonly >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
		-->
		日志类型：
		<select name="log_type">
			<option value ="-1"  selected >全部</ption>
			@foreach ($log_type_list as $index => $value)
				<option value ="{{ $index }}" @if($index==$log_type) selected @endif >{{ $value }} </option>
			@endforeach
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		日志级别：
		<select name="log_level">
			<option value ="-1"  selected >全部</ption>
			@foreach ($log_level_list as $index => $value)
				<option value ="{{ $index }}" @if($index==$log_level) selected @endif >{{ $value }} </option>
			@endforeach
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<br><br>
		日志来源：
		<input type="text" value="{{$source_name}}" name='source_name' id='source_name'  size="12" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		bu：
		<input type="text" value="{{$bu_name}}" name='bu_name' id='bu_name'  size="12" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		日志来源ip：
		<input type="text" value="{{$source_ip}}" name='source_ip' id='source_ip'  size="12" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		日志详细内容：
		<input type="text" value="{{$contents}}" name='contents' id='contents'  size="20" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input  type="submit" value="查询" class="layui-btn" >
	</form>
	总计{{$totalCount}}条
    <div class="layui-form" >
        @if($totalCount)
			<table class="layui-table" style="overflow:scroll;">
				<colgroup>
					<col width="">
					<col width="">
					<col width="">
					<col width="">
					<col width="">
					<col width="">
					<col width="">
					<col width="">
					<col width="">
				</colgroup>
				<thead  align="center">
				<tr>
					<th style="text-align:center;">#</th>
					<th style="text-align:center;">id</th>
					<th style="text-align:center;">日志来源</th>
					<th style="text-align:center;">bu</th>
					<th style="text-align:center;">日志类型</th>
					<th style="text-align:center;">日志级别</th>
					<th style="text-align:center;">日志详细内容</th>
					<th style="text-align:center;">生成日志时间</th>
					<th style="text-align:center;">日志来源ip</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($list as $index => $user)
					<tr align="center">
						<td><?php echo $index+1;?></td>
						<td>{{ $user['id'] }}</td>
						<td>{{ $user['source'] }}</td>
						<td>{{ $user['bu'] }}</td>
						<td>{{ $user['type'] }}</td>
						<td>{{ $user['level'] }}</td>
						<td>
						
						<a style='cursor:pointer' onclick="openDialogContentDetail({{ $index }});" >
							<u >
								<font color='#0000FF'>{{ $user['contents_short'] }}...</font></u>
						</a>
						<a style="display:none" id='{{ $index }}'>
						{{ $user['contents'] }}
						</a>
						</td>
						<td>{{ $user['addtime'] }}</td>
						<td>{{ $user['ip'] }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div id="paginate-render"></div>
        @else
            <br />
            <blockquote class="layui-elem-quote">暂无数据!</blockquote>
        @endif
    </div>
</div>


<script>
function openDialogContentDetail(id)
{
	layer.open({
		title: '日志内容明细',
		//area: ['800px', '600px'],
		content: $('#'+id).text()
	});   
}

lay('#version').html('-v'+ laydate.v);
laydate.render({
	elem: '#operate_start_date' ,//指定元素
	type: 'date'
});
laydate.render({
	elem: '#operate_end_date' ,//指定元素
	type: 'date'
});
laydate.render({
	elem: '#operate_start_time' ,//指定元素
	type: 'time'
});
laydate.render({
	elem: '#operate_end_time' ,//指定元素
	type: 'time'
});
</script>

@endsection
@section('scripts')
@include('backend.layouts._paginate',[ 'limit' => 10,'count' => $totalCount ])
@endsection