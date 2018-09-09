<?php

namespace App\Observers;

use App\Models\User;
use App\Jobs\CreateUserAvatar;

use Illuminate\Support\Facades\Log;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function created(User $user)
    {
    	Log::info('执行了用户：' . $user->name . '创建事件 --- ' . $user->id);
    }

    public function updating(User $user)
    {
        //Log::info('执行了 updating 事件');
        //dd('执行了 saving 事件');
    }

    public function saving(User $user) 
    {
    	//dd('执行了 saving 事件');
    	
    }

    public function saved(User $user)
    {
    	// 必须在保存完成后再进行操作，否则拿不到$user->id;
    	// 如果没有设置头像，为用户创建一个默认头像
    	if( ! $user->avatar) {
    		dispatch(new CreateUserAvatar($user));
    	}
    }
}