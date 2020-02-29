<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Cate;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo encrypt(123456);die;

        $title = request()->title??'';
        $where = [];
        if($title){
            $where[] = ['title','like',"%$title%"];
        }
        $pageSize = config('app.pageSize');

        $data = News::leftjoin('cate','news.cate_id','=','cate.cate_id')
                     ->where($where)
                      ->orderby('n_id','desc')
                      ->paginate($pageSize);
//-dd($data);
        return view('news.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Cate::get();
        return view('news.create',['cate'=>$cate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        //文件上传
        if ($request->hasFile('img')) { 
            $data['img'] = uploads('img');
        }

        $data['add_time'] = time();
        $res = News::create($data);
        if($res){
            return redirect('/news');
        }
    }


    //ajax 唯一性验证
    public function checkOnly(){
        $title = request()->title;
        $where = [];
        if($title){
            $where[] = ['title','=',$title];
        }
        //排除自身
        $n_id = request()->n_id;
        if($n_id){
            $where[] = ['n_id','!=',$n_id];
        }
        //\DB::connection()->enableQueryLog();
        $count = News::where($where)->count();
        // $logs = \DB::getQueryLog();
        // dd($logs);
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Cate::get();
        $data = News::find($id);
        return view('news.edit',['cate'=>$cate,'data'=>$data]);
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
       
        $res = News::destroy($id);

        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']); 
        }
        
    }
}
