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
    <form action="{{url('/category/store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <table class="table">
            <tr>
                <th style="text-align:right;">分类名称:</th>
                <td>
                  <input type="text" name="cate_name">
                  <b style="color:red">{{$errors->first('sname')}}</b>
               </td>
            </tr>
            <tr>
                <th style="text-align:right;">父级分类:</th>
                <td>
                    <select name="parent_id">
                            <option value='0'>--请选择--</option>
                            @foreach($cate as $v)
                            <option value="{{$v->cate_id}}">{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</option>
                             @endforeach
                        </select>
                </td>
            </tr>
            <tr>
                <th style="text-align:right;">描述:</th>
                <td>
                    <textarea  name="desc" ></textarea>
                     
                </td>
            </tr>
           <tr>
               
                <td colspan="2">
                  <input type="submit" value="添加">
                
               </td>
            </tr>
          
        </table>
    </form>


 </body>
</html>
