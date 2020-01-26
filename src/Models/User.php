<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const NORMAL = 'normal';
    const ADMIN = 'admin';

    protected $fillable = ['name', 'password', 'email', 'type', 'avatar'];

    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? /* TODO: Add storage link */ null
            : get_gravatar($this->email);
    }

    public function getTypeLabelAttribute()
    {
        return [
            self::ADMIN => 'Administrador',
            self::NORMAL => 'Normal'
        ][$this->type];
    }
}
