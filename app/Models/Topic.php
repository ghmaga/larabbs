<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function category() // 文章所属分类
    {
        return $this->belongsTo(Category::class);
    }

    public function user() // 文章所属用户
    {
        return $this->belongsto(User::class);
    }
}
