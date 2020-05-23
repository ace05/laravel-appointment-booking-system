<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use  SoftDeletes;

    protected $fillable = [
    	'filename', 'type', 'foreign_id', 'path'
    ];

    protected $dates = ['deleted_at'];

}
