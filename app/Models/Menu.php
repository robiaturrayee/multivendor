<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
   protected $fillable = ['title', 'route'];

public function roles()
{
    return $this->hasMany(MenuRole::class);
}
}
