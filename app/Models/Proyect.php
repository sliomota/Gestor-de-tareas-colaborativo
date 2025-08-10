<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyect extends Model
{
    use SoftDeletes;

    protected $fillable = ["name", "description"];

    public function users()
    {
        return $this->belongsToMany(User::class, "proyect_user");
    }
}
