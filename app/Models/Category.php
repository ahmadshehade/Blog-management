<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable=[

         'name',
         'slug',
         'description',
         'parent_id',
         'is_active',

     ];




    /**
     * Get the children categories associated with the current category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


     public function children(){
        return $this->hasMany(Category::class,'parent_id','id');
     }


     /**
     * Get the posts associated with the current category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

     public function posts(){
        return $this->hasMany(Post::class,foreignKey: 'category_id');
     }



}