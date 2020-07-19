<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use App\Profile;
use App\Role;
use App\Permission;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index', 'show');
        $this->middleware(['permission:create_users'])->only('store');
        $this->middleware(['permission:update_users'])->only('update', 'edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get User
        return UserResource::collection(User::latest()->paginate(25));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $request_data = $request->except(["password", "password_confirmation", "status", "role", "permissions"]);
        $request_data["password"] = bcrypt($request->password);

        $user = User::create($request_data);
        $user->attachRole($request->role);
        $user->syncPermissions($request->permissions);

        return response()->json([
            "success" => true,
            "message" => "Created User IS Successfully"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Get User With Role
        $users = new UserResource($user);
        $role = Role::all()->except(1);
        $permissions = Permission::all();
        return response()->json([
            'users'       => $users,
            'roles'       => $role,
            'permissions' => $permissions
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::all()->except(1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name  = $request->name;
        $user->email = $request->email;
        if (Hash::check($request['oldPassword'], $user->passsword)) {
            $user->passsword = Hash::make($request['password']);
        }
        $user->save();
        $user->attachRole($request->role);
        $user->syncPermissions($request->permissions);

        return response()->json([
            "success" => true,
            "message" => "Update Admin IS Successfully"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->profile()->delete(); // Delete Profile Whene Delete User
        $user->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Admin IS Successfully"
        ],200);
    }
}
