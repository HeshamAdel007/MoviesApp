<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
      return $this->belongsToMany(Category::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function actor()
    {
      return $this->belongsToMany(Actor::class);
    }

    public function comments()
    {
        //return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->orderBy('created_at', 'desc');
        return $this->morphMany(Comment::class, 'commentable')->orderBy('created_at', 'desc');
    }

}
