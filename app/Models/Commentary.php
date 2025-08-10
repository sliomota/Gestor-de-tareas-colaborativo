<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentary extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "commentary"
    ];

    public function task()
    {
       return $this->belongsTo(Task::class);
    }
}
