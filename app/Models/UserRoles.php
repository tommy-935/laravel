<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $fillable = [
        'user_id',
        'role_id'
    ];
    protected $table = 'user_roles';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }
}
