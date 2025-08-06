<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = ["name"];

    public function user()
    {
        $this->belongsToMany(User::class, "group_user");
    }

    public function tasks(){
        $this->hasMany(Task::class);
    }
}
