<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    public function user(){
    //Un producto pertenece a un usuario
    return $this->belongsTo(User::class);
}
}
