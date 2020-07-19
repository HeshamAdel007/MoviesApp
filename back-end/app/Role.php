<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
     public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }
}
