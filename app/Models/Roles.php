<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function userRole(){
        return $this->hasMany('App\Models\UserRoles');
    }
}
