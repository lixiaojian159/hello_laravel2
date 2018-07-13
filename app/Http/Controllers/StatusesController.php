<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
	//权限判断(中间件)
	public function __construct(){
		$this->middleware('auth');
	}
	//发布微博的逻辑
    public function store(Request $request){
    	$content = $this->validate( $request, [ 'content' => 'required|max:250' ] ); //自动验证,返回是验证的内容(一维数组)
    	$user = Auth::user()->statuses()->create($content); //挂链知识点： 关联模型
    	session()->flash('success','微博发布成功');
    	//return redirect()->route('users.show',Auth::user()->id);  //这个也可以
    	return redirect()->back();
    }

    //删除微博的逻辑
    public function destroy(Status $status){
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success','博已被成功删除！');
        return redirect()->back();
    }
}
