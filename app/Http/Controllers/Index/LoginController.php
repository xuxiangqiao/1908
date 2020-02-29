<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

use App\Member;

//发送邮件
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    public function reg(){
    	return view('index.reg');
    }

    //发送邮件
    public function sendEmail(){
    	$email = '1309755315@qq.com';
    	Mail::to($email)->send(new SendCode());
    }

    //发生短信
    public function ajaxsend(){

    	//接受注册页面的手机号
    	//$moblie = '13661157166';
    	$mobile = request()->mobile;

    	$code = rand(1000,9999);

    	$res = $this->sendSms($mobile,$code);
    	//dd($res);

    	if( $res['Code']=='OK'){
    		session(['code'=>$code]);
    		request()->session()->save();

    		echo json_encode(['code'=>'00000','msg'=>'ok']);die;	
    	}
    	echo json_encode(['code'=>'00001','msg'=>'短信发送失败']);die;

    }

    public function sendSms($mobile,$code){

		AlibabaCloud::accessKeyClient('LTAI4Feys3XfGUZfqzcu1kg4', 'Rp6ChiyL6fw666LjAeE4zYaEfC6bk8')
		                        ->regionId('cn-hangzhou')
		                        ->asDefaultClient();

		try {
		    $result = AlibabaCloud::rpc()
		                          ->product('Dysmsapi')
		                          // ->scheme('https') // https | http
		                          ->version('2017-05-25')
		                          ->action('SendSms')
		                          ->method('POST')
		                          ->host('dysmsapi.aliyuncs.com')
		                          ->options([
		                                        'query' => [
		                                          'RegionId' => "cn-hangzhou",
		                                          'PhoneNumbers' => $mobile,
		                                          'SignName' => "一品学堂",
		                                          'TemplateCode' => "SMS_184105081",
		                                          'TemplateParam' => "{code:$code}",
		                                        ],
		                                    ])
		                          ->request();
		    return $result->toArray();
		} catch (ClientException $e) {
		    return $e->getErrorMessage();
		} catch (ServerException $e) {
		    return $e->getErrorMessage();
		}	
    }


    public function regdo(){

   	  $post = request()->except('_token');

   	  //判断验证码
   	  $code = session('code');
   	  if( $code!=$post['code']){
   	  	return redirect('/reg')->with('msg','您输入的验证码不对');
   	  }

   	  //密码和确认密码是否一致
   	  if($post['pwd']!=$post['repwd']){
   	  	return redirect('/reg')->with('msg','两次密码不一致');
   	  }

   	  //入库
   	  $user = [
   	  	'mobile'=>$post['mobile'],
   	  	'pwd'=>encrypt($post['pwd']),
   	  	'add_time'=>time(),
   	  ];
	  $res = Member::create($user);

	  if( $res ){
	  	return redirect('/login');
	  }

    }

}
