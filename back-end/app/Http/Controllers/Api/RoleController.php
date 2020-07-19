<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all()->except(1);
        $permissions = Permission::all();
        return response()->json([
            "roles"       => $roles,
            "permissions" => $permissions
        ],200);
    }

}
