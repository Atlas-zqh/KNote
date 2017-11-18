<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';

    protected $fillable = [
        'follow_user_id', 'followed_user_id'
    ];

    public $timestamps = false;
}
