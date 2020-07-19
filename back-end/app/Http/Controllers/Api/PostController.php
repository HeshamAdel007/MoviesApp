<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\User;
use App\Tag;
use App\Actor;
use Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_post'])->only('index', 'show');
        $this->middleware(['permission:create_post'])->only('store');
        $this->middleware(['permission:update_post'])->only('update', 'edit');
        $this->middleware(['permission:delete_post'])->only('destroy', 'postTrash','harddelete', 'restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Posts
        return PostResource::collection(Post::with('category', 'user')->latest()->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;

        // Post Photo
        if ($request->photo) {
             if ($request->photo != 'post_imag_default.jpg') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/post/' . $request->photo);

            }

            $image = $request->photo;
            $fakeName = Str::random(15) . '-' . time();
            $name = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/post/') . $name);


            $post->photo = $name;

        }


        $post->user_id        = Auth::id();
        $post->title          = $request->title;
        $post->slug           = Str::slug($request->title, '-');
        $post->content        = $request->content;
        $post->trailer        = $request->trailer;
        $post->post_status    = $request->post_status;
        $post->comment_status = $request->comment_status;
        $post->save();

        // Add Multi Actors & Category & Tags
        $post->actor()->sync($request->actors);
        $post->category()->sync($request->categories);
        $post->tag()->sync($request->tags);

        return response()->json([
            "success" => true,
            "message" => "Created Post IS Successfully"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = new PostResource($post);
        return response()->json([
            'post' => $post
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
        $post = Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        // Post Photo
        if ($request->photo) {
             if ($request->photo != 'post_imag_default.jpg') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
                Storage::disk('public')->delete('/images/post/' . $request->photo);

            }

            $image = $request->photo;
            $fakeName = Str::random(15) . '-' . time();
            $name = $fakeName . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)
                ->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/images/post/') . $name);


            $post->photo = $name;

        }

        $post->title          = $request->title;
        $post->slug           = Str::slug($request->title, '-');
        $post->content        = $request->content;
        $post->trailer        = $request->trailer;
        $post->post_status    = $request->post_status;
        $post->comment_status = $request->comment_status;
        $post->save();

        // Add Multi Actors & Category & Tags
        $post->actor()->sync($request->actors);
        $post->category()->sync($request->categories);
        $post->tag()->sync($request->tags);

        return response()->json([
            "success" => true,
            "message" => "Update Post IS Successfully"
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
        // used soft delete
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Post IS Successfully"
        ],200);

    }

    /**
     * Show All Posts In Trash.
    */
    public function postTrash()
    {
        // function move post soft delete to trashed

        return PostResource::collection(Post::onlyTrashed()->get());
    }

    /**
     * Return Post From Trash To Posts.
    */
    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        $post->restore();
        return response()->json([
            "success" => true,
            "message" => "Restore Post IS Successfully"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function harddelete($id)
    {
        // function hared delete (normal delete)
        $post = Post::withTrashed()->where('id', $id)->first();
        if ($post->photo != 'post_imag_default.jpg') {
                //Check if have a default image dont remove the image
                //if not have a default image
                    //1:remove old image
                    //2: add a new image
            Storage::disk('public')->delete('/images/post/' . $request->photo);
        }

        $post->forceDelete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Post IS Successfully"
        ],200);
    }

}
