<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    public function users(){
    //Un rol tiene muchos usuarios a través de la tabla pivot role_user
    return $this->belongsToMany(User::class);
}
}
