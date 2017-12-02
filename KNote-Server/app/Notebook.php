<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'notebooks';

    protected $fillable = [
        'user_id', 'notebook_name', 'notes_count', 'is_valid', 'permission'
    ];
}
