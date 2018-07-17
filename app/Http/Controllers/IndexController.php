<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class IndexController extends Controller
{
    //测试compact函数
    public function compact_test($user_ids){
    	if(!is_array($user_ids)){
    		$user_ids = compact('user_ids');
    	}
    	echo '<pre>';
    	print_r($user_ids);
    }


    //测试User模型中的判断是否是粉丝的方法
    public function user_test(){
    	$user = new User();
    	$user_id = $user->isFollowing(2);
    	echo '<pre>';
    	var_dump($user_id);
    }

    //测试Auth_test
    public function auth_test(){
    	$user = new User();
    	$auth_test = $user->feed();
    	echo '<pre>';
    	var_dump($auth_test);
    }
}
