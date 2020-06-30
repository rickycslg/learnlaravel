<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['nickname', 'email', 'website', 'content', 'article_id'];


    /**
     * 获取此评论所属的文章
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article', 'article_id', 'id');
    }
}
