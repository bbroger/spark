<?php

namespace App\Controllers;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'password', 'email', 'type'];
}