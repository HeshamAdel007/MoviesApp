<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use Illuminate\Pagination\Paginator;
use App\Tag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_tags'])->only('index', 'show');
        $this->middleware(['permission:create_tags'])->only('store');
        $this->middleware(['permission:update_tags'])->only('update', 'edit');
        $this->middleware(['permission:delete_tags'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Tags
        return TagResource::collection(Tag::without('post')->latest()->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $tag = new Tag;
        $tag->name  = $request->name;
        $tag->save();
        return response()->json([
            "success" => true,
            "message" => "Created Tag IS Successfully"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tags = new TagResource($tag);
        return response()->json([
            'tags' => $tags
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
        $tags = Tag::findOrFail($id);
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
        $this->validate($request,[
            'name'   => 'required|max:255',
        ]);

        $tags = Tag::findOrFail($id);
        $tags->name  = $request->name;
        $tags->save();
        return response()->json([
            "success" => true,
            "message" => "Update Tags IS Successfully"
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
        $tags = Tag::findOrFail($id);
        $tags->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Tag IS Successfully"
        ],200);
    }
}
