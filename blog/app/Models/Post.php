<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'content',
    ];

    public function comments() {
        return $this->hasMany( \App\Models\Comment::class );
    }

    public function categories() {
        return $this->belongsToMany( \App\Models\Category::class );
    }

    public function user() {
        return $this->belongsTo( \App\Models\User::class );
    }
}
