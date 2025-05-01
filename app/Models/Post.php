<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_published',
        'publish_date',
        'meta_description',
        'tags',
        'keywords'
    ];

    protected  $guarded=['user_id','admin_id'];

    protected $table="posts";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
}
