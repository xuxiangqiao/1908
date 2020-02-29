<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; 

class IndexController extends Controller
{
	//前台首页
    public function index(){
    	
    	return view('index.index');
    }

  

}
