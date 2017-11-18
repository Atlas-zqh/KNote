<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $primaryKey = 'note_id';

    protected $fillable = [
        'user_id', 'notebook_id', 'title', 'content', 'is_valid', 'permission'
    ];
}
