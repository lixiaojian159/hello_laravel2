<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Auth;



class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','activation_token','activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //关联模型：一对多(一个用户可以发表多条微博)
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    //生成用户头像
    public function gravatar($size=100){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/{$hash}?s={$size}";
    }
	
	public static function boot(){
		parent::boot();
		static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
	}

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    //获取用户自己的微博
    public function feed(){
        //return $this->statuses()->orderBy('created_at','desc');
        $user_ids = Auth::user()->followings->pluck('id')->toarray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
    }

    //关联模型 多对多
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    public function followings(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    //添加关注
    public function follow($user_ids){

        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }

    //取消关注
    public function unfollow($user_ids){

        if(!is_array($user_ids)){
            $user_id = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    //判断当前用户A是否关注了用户B (只需判断用户B是否在用户A的关注列表)
    public function isFollowing($user_id){
        return $this->followings->contains($user_id);
    }
}
