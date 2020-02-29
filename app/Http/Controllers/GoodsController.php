<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Goods;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //  // 全局辅助函数 设置
       // // session(['name'=>'zhangsan']);
       // // request()->session()->save();

       //  // 全局辅助函数 删除
       // session(['name'=>null]);
       // request()->session()->save();
       // //全局辅助函数 获取
       // echo session('name');

        // //request实例 设置
        // request()->session()->put('age',18);
        // request()->session()->save();

        // //request实例 获取
        // echo request()->session()->get('age');
        // //request实例 删除
        // request()->session()->forget('age');

        // dd(request()->session()->get('age'));
        // die;
       //清除缓存 
       // Cache::flush();

       $shop_name = request()->shop_name??'';    
       $where = []; 
       if( $shop_name ){
            $where[] = ['shop_name','like',"%$shop_name%"];
       }

        //接受当前页页码
        $page = request()->page??1;

        //echo 'goods_'.$page.'_'.$shop_name;
        //获取缓存的值
        //$goods = Cache::get('goods_'.$page.'_'.$shop_name');
        //$goods = cache('goods_'.$page.'_'.$shop_name);

        $goods = Redis::get('goods_'.$page.'_'.$shop_name);

        //dd($goods);
         if(!$goods){
            echo "走DB==";
            $pageSize = config('app.pageSize');
            $goods = Goods::leftjoin('brand','goods.b_id','=','brand.brand_id')
                            ->leftjoin('category','goods.cate_id','=','category.cate_id')
                            ->where($where)
                            ->orderby('shop_id','desc')
                            ->paginate($pageSize);
            //存入缓存
            //Cache::put('goods_'.$page.'_'.$shop_name, $goods, 60*60*24*30);     
            // cache(['goods_'.$page.'_'.$shop_name=>$goods],60*60*24*30);    
            //序列化结果集 将object转换为字符串
            $goods = serialize($goods);
             Redis::setex('goods_'.$page.'_'.$shop_name,20,$goods);          
        }
        //反序列话结果集 将字符串转换为object对象
        $goods = unserialize($goods);

        return view('goods.index',['goods'=>$goods,'query'=>request()->all()]);               
    }

    /**
     * Show the form for creating a new resource.
     *  展示添加界面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         echo session('name');die;
        //品牌
        $brand = Brand::all();
     //   dd($brand);
        //分类
        $cate = Category::all();
        $cate = CreateTree($cate);

        return view('goods.create',['brand'=>$brand,'cate'=>$cate]);
    }

    /**
     * Store a newly created resource in storage.
     * 执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
//dump($data);
        //商品货号
        $data['shop_sn'] = $this->CreateGoodsSn();

        //单文件上传
        if($request->hasFile('shop_img')){
            $data['shop_img'] = uploads('shop_img');
        }
        //多文件上传
        if(isset($data['shop_file'])){
            $photos = Moreuploads('shop_file'); 
            $data['shop_file'] = implode('|', $photos);
        }

       $res =  Goods::create($data);
       if(  $res ){
            return redirect('/goods');
       }
    }
    //产生货号
    public function CreateGoodsSn(){
        return 'shop'.date('YmdHis').rand(1000,9999);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //访问量
        $count = Redis::setnx('num_'.$id,1);
        if(!$count){
            $count = Redis::incr('num_'.$id);
        }

        $goods = Goods::find($id);

        return view('goods.show',['goods'=>$goods,'count'=>$count]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
