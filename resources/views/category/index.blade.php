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

<table class="table table-bordered">
	<caption>边框表格布局</caption>
	<thead>
		<tr>
		    <th>分类ID</th>
			<th>分类名称</th>
			<th>分类描述</th>
			
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	@foreach($cate as $v)
		<tr>
		    <td>{{$v->cate_id}}</td>
			<td>{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</td>
			<td>{{$v->desc}}</td>
			
			<td><a href="{{url('news/edit/'.$v->n_id)}}">编辑</a>|
			<a href="javascript:void(0)" onclick="del({{$v->n_id}})" >删除</a></td>
		</tr>
	@endforeach	
		
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