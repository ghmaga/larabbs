<?php

namespace App\Models;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    // 模型关联
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 模型关联
    public function isAuthorOf($model)
    {
         return $this->id == $model->user_id;
    }


     // 模型关联

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function markAsRead()
    {
        // 将所有通知状态设定为已读，并清空未读消息数。
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
