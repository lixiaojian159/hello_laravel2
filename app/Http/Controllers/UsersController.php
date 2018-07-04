<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //注册页
    public function create(){
    	return view('users.create');
    }

    //显示个人信息页面
    public function show(User $user){
    	return view('users.show',compact('user'));
    }

    //用户注册动作
    public function store(Request $request){
		$this->validate($request,[ 'name' => 'required|max:50' , 'email' => 'required|email|unique:users|max:255' , 'password' => 'required|confirmed|min:6' ]);
		$data['name']      = $request->get('name');
		$data['email']    = $request->get('email');
		$data['password'] = bcrypt($request->get('password'));
		$user = User::create($data);
		Auth::login($user);
		session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
		return redirect()->route('users.show',[$user]);
    }
}
