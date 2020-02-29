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
		<td colspan="8">{{$data->appends($query)->links()}}</td>	
		</tr>