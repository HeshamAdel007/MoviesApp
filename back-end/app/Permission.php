<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
     public function user() {
        return $this->belongsToMany(User::class);
    }

    public function roles() {
        return $this->belongsToMany('App\Role');
    }
}
