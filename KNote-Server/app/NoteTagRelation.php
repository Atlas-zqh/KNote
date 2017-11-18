<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteTagRelation extends Model
{
    protected $table = 'note_tag_relations';

    protected $fillable = [
        'note_id', 'tag_id'
    ];

    public $timestamps = false;
}
