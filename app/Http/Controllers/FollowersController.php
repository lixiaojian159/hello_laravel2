<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    //构造函数(中间件)
    public function __construct(){
    	$this->middleware('auth');
    }
    
    //关注逻辑
    public function store(User $user){
    	if(Auth::user()->id === $user->id){
    		return redirect('/');
    	}

    	if(!Auth::user()->isFollowing($user->id)){
    		Auth::user()->follow($user->id);
    	}
    	return redirect()->route('users.show',$user->id);
    }

    //取消关注逻辑
    public function destroy(User $user){
    	if(Auth::user()->id === $user->id){
    		return redirect('/');
    	}
    	if(Auth::user()->isFollowing($user->id)){
    		Auth::user()->unfollow($user->id);
    	}
    	return redirect()->route('users.show',$user->id);
    }
}
