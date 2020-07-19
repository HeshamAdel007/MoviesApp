<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;
use App\Profile;
use App\User;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_profile'])->only('show');
        $this->middleware(['permission:update_profile'])->only('update', 'edit');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        $profiles = new ProfileResource($profile);
        return response()->json([
            'profile' => $profiles
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
        $profile = Profile::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $profile = Profile::find($id);
        // User Avater
        if ($request->avatar) {
             if ($profile->avatar != 'avatar_default.png') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/avatar/' . $profile->avatar);

            }

            $image = $request->avatar;
            $fakeName = Str::random(15) . '-' . time();
            $name = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(350, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/avatar/') . $name);

            $profile->avatar = $name;

        }

        $profile->nickname    = $request->nickname;
        $profile->description = $request->description;
        $profile->about       = $request->about;
        $profile->phone       = $request->phone;
        $profile->facebook    = $request->facebook;
        $profile->twitter     = $request->twitter;
        $profile->instagram   = $request->instagram;
        $profile->youtube     = $request->youtube;
        $profile->save();
        return response()->json([
            "success" => true,
            "message" => "Add Your Info IS Successfully"
        ],201);
    }
}
