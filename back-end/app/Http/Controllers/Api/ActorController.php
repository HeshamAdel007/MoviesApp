<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ActorResource;
use App\Http\Requests\ActorRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Actor;
use App\Post;

class ActorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_actor'])->only('index', 'show');
        $this->middleware(['permission:create_actor'])->only('store');
        $this->middleware(['permission:update_actor'])->only('update', 'edit');
        $this->middleware(['permission:delete_actor'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ActorResource::collection(Actor::without('post')->latest()->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        $actor = new Actor;

        // Actor Photo
        if ($request->photo) {
             if ($request->photo != 'act_img.jpg') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/actor/' . $request->photo);

            }

            $image = $request->photo;
            $fakeName = Str::random(15) . '-' . time();
            $name = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/actor/') . $name);


            $actor->photo = $name;

        }

        $actor->name        = $request->name;
        $actor->description = $request->description;
        $actor->save();

        return response()->json([
            "success" => true,
            "message" => "Created Actor IS Successfully"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        $actors = new ActorResource($actor);
        return response()->json([
            'actor' => $actors
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
        $actor = Actor::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, $id)
    {
        $actor = Actor::findOrFail($id);

        // Actor Photo
        if ($request->photo) {
             if ($request->photo != 'act_img.jpg') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/actor/' . $request->photo);

            }

            $image = $request->photo;
            $fakeName = Str::random(15) . '-' . time();
            $name = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/actor/') . $name);


            $actor->photo = $name;

        }

        $actor->name        = $request->name;
        $actor->description = $request->description;
        $actor->save();

        return response()->json([
            'success' => true,
            'message' => "Update Actor IS Successfully"
        ],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);

        $actor->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Actor IS Successfully"
        ],200);
    }
}
