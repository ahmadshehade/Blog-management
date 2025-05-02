<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'body',
        'is_published',
        'is_featured',
        'is_scheduled',
        'status',
        'publish_date',
        'meta_description',
        'keywords',
        'tags',
        'canonical_url',
        'editor_notes',
    ];

    protected  $guarded=['user_id','admin_id'];

    protected $table="posts";


    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }




    /**
     * Get the admin that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
}