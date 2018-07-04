<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    //用户登录页面
	public function create(){
		return view('sessions.create');
	}
	
	//用户登录验证
	public function store(Request $request){
		$credentials = $this->validate($request,['email'=>'required|email|max:255','password'=>'required']);
		print_r($credentials);
		if(Auth::attempt($credentials,$request->has('remember'))){
			session()->flash('success','欢迎登录');
			return redirect()->route('users.show',[Auth::user()]);
		}else{
			session()->flash('danger','登录失败');
			return redirect()->route('login');
		}
		exit;
	}
	
	//用户退出
	public function destroy(){
		Auth::logout();
		session()->flash('success','退出成功');
		return redirect('login');
	}
}
