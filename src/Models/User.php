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
            ? url(FOLDER_AVATARS . '/' . $this->avatar)
            : get_gravatar($this->email);
    }

    public function getTypeLabelAttribute()
    {
        return [
            self::ADMIN => 'Administrador',
            self::NORMAL => 'Normal'
        ][$this->type];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
}
