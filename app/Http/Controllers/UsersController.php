<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct(){
        $this->middleware('auth',  [ 'except'=>['create','show','store','index'] ]);
        $this->middleware('guest', [ 'only'  =>['create'] ]);
    }

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
		$data['name']     = $request->get('name');
		$data['email']    = $request->get('email');
		$data['password'] = bcrypt($request->get('password'));
		$user = User::create($data);
		Auth::login($user);
		session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
		return redirect()->route('users.show',[$user]);
    }

    //用户资料编辑页面
    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    //用户资料修改验证逻辑
    public function update(Request $request,$id){
        $this->authorize('update', $user);
        $this->validate($request,['name'=>'required|min:4|max:50','password'=>'confirmed']);
        $user = User::find($id);
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','个人资料更新成功！');
        return redirect()->route('users.show',$id);
    }
    
	//用户列表
    public function index(){
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }
	
	//删除用户
	public function destroy(User $user){
		$user->delete();
		session()->flash('success','成功删除用户！');
		return redirect()->back();
	}
	
}
