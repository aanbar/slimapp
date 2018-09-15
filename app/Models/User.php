<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];


    public function getFullnameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}