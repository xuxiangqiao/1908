<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Cate;
class NewController extends Controller
{
    //前台列表展示
	public function index(){
		$cate_id = request()->cate_id??'';
		$where = [];
		if( $cate_id ){
			$where[] = ['news.cate_id','=',$cate_id];
		}
		$title = request()->title??'';
		if( $title ){
			$where[] = ['news.title','like',"%$title%"];
		}
		$page = request()->page??1;

		//缓存里面获取分类值
		$cate = cache('cate');
		//dump($cate);
		if(!$cate){
			//获取分类数据
			$cate = Cate::get();
			//存入缓存
			cache(['cate'=>$cate],1*60);
		}
		//缓存里面获取结果值
		$data = cache('new_'.$page.'_'.$cate_id.'_'.$title);
		//dump($data);
		if( !$data ){
			//echo "db==";
			$pageSize = config('app.pageSize');
			
			$data = News::leftjoin('cate','news.cate_id','=','cate.cate_id')->where($where)->paginate($pageSize);
			//存入缓存
			cache(['new_'.$page.'_'.$cate_id.'_'.$title=>$data],1*60);
		}

	    //获取所有搜索条件
		$query = request()->all();		
		//是ajax请求 即要实现ajax分页	
		 if(request()->ajax()){
		 	return view('new.ajaxPage',['data'=>$data,'cate'=>$cate,'query'=>$query]);
		 }	

		return view('new.index',['data'=>$data,'cate'=>$cate,'query'=>$query]);
	}
}
