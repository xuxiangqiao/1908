<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
  <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<form>
<input name="shop_name" value="{{$query['shop_name']??''}}" placeholder="请输入商品名称关键字">
<button>搜索</button>
</form>

<table border="1" width="100%">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>商品库存</td>
        <td>商品价格</td>
        <td>商品分类</td>
        <td>商品品牌</td>
        <td>是否热卖</td>
        <td>是否新品</td>
        <td>商品图片</td>
        <td>商品相册</td>
        <td>操作</td>
    </tr>
    @foreach($goods as $v)
    <tr shop_id="{{$v->shop_id}}">
        <td>{{$v->shop_id}}</td>
        <td>{{$v->shop_name}}</td>
        <td>{{$v->shop_num}}</td>
        <td>{{$v->shop_price}}</td>
        <td>{{$v->cate_name}}</td>
        <td>{{$v->brand_name}}</td>
        <td>@if($v->is_cp==1)是 @else 否 @endif</td>
        <td>@if($v->is_new==1)是 @else 否 @endif</td>
       <td>
            <img src="{{env('UPLOAD_URL')}}{{$v->shop_img}}" height="50px" width="50px">
        </td>
        <td>
          @if($v->shop_file)
          @php $photos = explode('|',$v->shop_file); @endphp
          @foreach($photos as $vv)
          <img src="{{env('UPLOAD_URL')}}{{$vv}}" height="50px" width="50px">
          @endforeach
          @endif
        </td>
        <td>
            <a href="{{url('goods/show/'.$v->shop_id)}}">预览详情</a>
            <a href="javascript:void(0)" class="del" shop_id="{{$v->shop_id}}">删除</a>
            <a href="{{url('shop/edit/'.$v->shop_id)}}">修改</a>
        </td>
    </tr>
        @endforeach

       <tr><td colspan="11"> {{$goods->appends($query)->links()}}</td></tr>
</table>

</body>
<script src="/static/js/jquery.min.js"></script>
<script>
//     $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
//     $(document).on('click','.del',function(){
//       var _this=$(this);
//        var shop_id= _this.attr('shop_id');
//         if (confirm('确定删除吗?')) {
//             $.post(
//                     "/shop/destroy/"+shop_id,
//                     function (res) {
// //                    return    console.log(res);
//                         if (res.code==00000){
//                             location.reload();
//                             alert('已删除');
//                         }else{
//                             alert('删除失败');
//                         }
//                     }, 'json'
//             )
//         }
//    })
</script>
</html>