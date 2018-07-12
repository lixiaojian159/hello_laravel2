<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{

    public function __construct(){
        $this->middleware('auth',  [ 'except'=>['create','show','store','index','confirmEmail'] ]);
        $this->middleware('guest', [ 'only'  =>['create'] ]);
    }

    //注册页
    public function create(){
    	return view('users.create');
    }

    //显示个人信息页面
    public function show(User $user){
        $statuses = $user->statuses()->orderBy('created_at','desc')->paginate(0);
    	return view('users.show',compact('user','statuses'));
    }

    //用户注册动作
    public function store(Request $request){
		$this->validate($request,[ 'name' => 'required|max:50' , 'email' => 'required|email|unique:users|max:255' , 'password' => 'required|confirmed|min:6' ]);
		$data['name']     = $request->get('name');
		$data['email']    = $request->get('email');
		$data['password'] = bcrypt($request->get('password'));
        //$data['activation_token'] = str_random(32);  //自己感觉可以这样写
		$user = User::create($data);
        $this->sendEmailConfirmationTo($user);
		session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
		return redirect('/');
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
	
	//邮箱验证权限
	public function confirmEmail($token){
		$user = User::where('activation_token',$token)->firstOrFail();
		$user->activated = true;
		$user->activation_token = null;
		$user->save();
		Auth::login($user);
		session()->flash('success','恭喜你，激活成功！');
		return redirect()->route('users.show',[$user]);
	}
	
    //用户注册后,发送验证邮件
	protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
	
}
