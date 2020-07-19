<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Http\Resources\SettingResource;
use App\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_sitting'])->only('show');
        $this->middleware(['permission:update_sitting'])->only('update', 'edit');
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);
        $settings = new SettingResource($setting);
        return response()->json([
            'setting' => $settings
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
        $setting = Setting::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        if ($request->logo) {
             if ($setting->logo != 'websile-logo.png') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/logo/' . $setting->logo);

            }

            $image = $request->logo;
            $fakeName = Str::random(15) . '-' . time();
            $imgname = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/logo/') . $imgname);

            $setting->logo = $imgname;

        }

        $setting->name        = $request->name;
        $setting->email       = $request->email;
        $setting->adress      = $request->adress;
        $setting->description = $request->description;
        $setting->facebook    = $request->facebook;
        $setting->twitter     = $request->twitter;
        $setting->instagram   = $request->instagram;
        $setting->youtube     = $request->youtube;
        $setting->save();
        return response()->json([
            "success" => true,
            "message" => "Edit Settings IS Successfully"
        ],201);
    }

}
