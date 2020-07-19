<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use App\Category;
use App\Post;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_category'])->only('index', 'show');
        $this->middleware(['permission:create_category'])->only('store');
        $this->middleware(['permission:update_category'])->only('update', 'edit');
        $this->middleware(['permission:delete_category'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Category
        return CategoryResource::collection(Category::without('post')->latest()->where('parent_id',NULL)->paginate(25));
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

        $category = new Category;
        $category->name      = $request->name;
        $category->slug      = Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->save();
        return response()->json([
            "success" => true,
            "message" => "Created Category IS Successfully"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $categories = new CategoryResource($category);
        return response()->json([
            'categories' => $categories
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
        $category = Category::findOrFail($id);
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
            'name'  => 'required|max:255',
        ]);
        $category = Category::findOrFail($id);
        $category->name       = $request->name;
        $category->slug       = Str::slug($request->name);
        $category->parent_id  = $request->parent_id;
        $category->save();
        return response()->json([
            "success" => true,
            "message" => "Update Category IS Successfully"
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
        $category = Category::findOrFail($id);
        $category->subcategory()->delete();
        $category->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Category IS Successfully"
        ],200);
    }
}
