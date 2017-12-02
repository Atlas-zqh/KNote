<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'user_id', 'tag_content', 'is_valid'
    ];

    public $timestamps = false;
}
