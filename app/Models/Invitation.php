<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'token',
        'expires_at',
        'used_at'
    ];

    public function proyect()
    {
        return  $this->belongsTo(Proyect::class);
    }
}
