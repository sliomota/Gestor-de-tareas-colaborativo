<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "status",
        "title",
        "description"
    ];

    public function proyect()
    {
        return $this->belongsTo(User::class);
    }

    public function commentary()
    {
        return $this->hasMany(Commentary::class);
    }
}
