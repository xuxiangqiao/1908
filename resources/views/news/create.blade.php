<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
  <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
 </head>
 <body>
    <form action="{{url('/news/store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <table class="table">
            <tr>
                <th style="text-align:right;">文章标题:</th>
                <td>
                  <input type="text" name="title">
                  <b style="color:red">{{$errors->first('sname')}}</b>
               </td>
            </tr>
            <tr>
                <th style="text-align:right;">文章分类:</th>
                <td>
                    <select name="cate_id">
                            <option value='0'>--请选择--</option>
                            @foreach($cate as $v)
                            <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                             @endforeach
                        </select>
                </td>
            </tr>
            <tr>
                <th style="text-align:right;">文章重要性:</th>
                <td>
                    <input type="radio" name="is_import" value="1" checked>普通
                     <input type="radio" name="is_import" value="2">置顶
                </td>
            </tr>
            <tr>
                <th style="text-align:right;">是否显示:</th>
                <td>
                    <input type="radio" name="is_show" value="1" checked>显示
                    <input type="radio" name="is_show" value="2">不显示
                </td>
            </tr>
            <tr>
                <th style="text-align:right;">文章作者:</th>
                <td>
                  <input type="text" name="author">
                  <b style="color:red">{{$errors->first('szz')}}</b>
                </td>
            </tr>
            <tr>
                <th style="text-align:right;">作者email:</th>
                <td><input type="text" name="email">
                <b style="color:red">
                     {{$errors->first('semail')}} 
                 </b></td>
            </tr>
           
            <tr>
                <th style="text-align:right;">上传文件:</th>
                <td><input type="file" name="img"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><input type="button" value="添加"></td>
               
            </tr>
        </table>
    </form>

<script>

 $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

$('input[type="button"]').click(function(){
    var titleflag = true;
    $('input[name="title"]').next().html('');
    //标题验证
    var title = $('input[name="title"]').val();
    var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
   if(!reg.test(title)){
      $('input[name="title"]').next().html('文章标题由中文字母数字组成切不能为空');
      return;
   }
   
    //验证唯一性
   $.ajax({
    type:'post',
    url:"/news/checkOnly",
    data:{title:title},
    async:false,
    dataType:'json',
    success:function(result){
       if(result.count>0){
          $('input[name="title"]').next().html('标题已存在');
          titleflag = false;
       }
    }});
   if(!titleflag){
      return;
   }

   //作者验证
   var author = $('input[name="author"]').val();
   var reg = /^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
   if(!reg.test(author)){
      $('input[name="author"]').next().html('文章作者由中文字母数字组成切不能为空长度为2-8位');
      return;
    }
    //form 提交
    $('form').submit();
});


$('input[name="author"]').blur(function(){
    $(this).next().html('');
    var author = $(this).val();
    var reg = /^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
    if(!reg.test(author)){
      $(this).next().html('文章作者由中文字母数字组成切不能为空长度为2-8位');
      return;
    }

})


$('input[name="title"]').blur(function(){
   $(this).next().html('');
   var title = $(this).val();
   var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
   if(!reg.test(title)){
      $(this).next().html('文章标题由中文字母数字组成切不能为空');
      return;
   }

   //验证唯一性
   $.ajax({
    type:'post',
    url:"/news/checkOnly",
    data:{title:title},
    //async:true,
    dataType:'json',
    success:function(result){
       if(result.count>0){
          $('input[name="title"]').next().html('标题已存在');
       }
    }});

})

</script>

 </body>
</html>
