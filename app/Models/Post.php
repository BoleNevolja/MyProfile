<?php

namespace App\Models;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

public function user(){
    return $this->belongsTo(User::class);
    }

public function Comments(){
    return $this->hasMany(Comment::class);
}

public function likes(){
    return $this->belongsToMany(User::class,'likes')->withTimestamps();
}

public function likedBy(){
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
}
}
