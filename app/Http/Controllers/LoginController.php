<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function logindo(){
    	$post = request()->except('_token');
    	
    	$user = \DB::table('admin')->where(['admin_name'=>$post['admin_name']])->first();
    	
    	if($post['password']!= decrypt($user->password)){
    		return redirect('/login')->with('msg','没有此用户或者密码错误！');
    	}

    	session(['adminuser'=>$user]);
    	request()->session()->save();

    	return redirect('/category');
    }
}
