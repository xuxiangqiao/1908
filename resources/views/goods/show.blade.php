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
<h1>{{$goods->shop_name}}</h1><hr/>
<p>当前访问量：{{$count}}</p>

<p>商品价格：{{$goods->shop_price}}</p>

<p>商品库存：{{$goods->shop_num}}</p>

</body>

</body>
</html>