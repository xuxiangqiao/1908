<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 边框表格</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<form>
<input type="text" name="title" />
<button>搜索</button>
</form>

<table class="table table-bordered">
	<caption>边框表格布局</caption>
	<thead>
		<tr>
		    <th>文章ID</th>
			<th>文章标题</th>
			<th>文章分类</th>
			<th>是否显示</th>
			<th>文章作者</th>
			<th>作者email</th>
			<th>图片</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	@foreach($data as $v)
		<tr>
		    <td>{{$v->n_id}}</td>
			<td>{{$v->title}}</td>
			<td>{{$v->cate_name}}</td>
			<td>{{$v->is_show?'√':'×'}}</td>
			<td>{{$v->author}}</td>
			<td>{{$v->email}}</td>
			<td>@if($v->img)<img src="{{env('UPLOAD_URL')}}{{$v->img}}" width="50">@endif</td>
			<td><a href="{{url('news/edit/'.$v->n_id)}}">编辑</a>|
			<a href="javascript:void(0)" onclick="del({{$v->n_id}})" >删除</a></td>
		</tr>
	@endforeach	
		<tr>
		<td colspan="8">{{$data->links()}}</td>	
		</tr>
	</tbody>
</table>
<script>
//ajax 删除
function del(id){
	if(!id){
		return;
	}
	if(confirm('是否要删除此条记录')){	
		//ajax 删除
		$.get('/news/destroy/'+id,function(result){
			if(result.code=='00000'){
				location.reload();
			}
		},'json')
	}
}

</script>
</body>
</html>