<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\PostResource;
use App\Http\Resources\ActorResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Post;
use App\Category;
use App\Actor;
use App\Tag;

class FrontEndController extends Controller
{

    // Get Papular & Last Post
    public function index()
    {
        // Get New Post Add When Post Status is Published
        $new = PostResource::collection(Post::where('post_status', '=', 'publish')
            ->orderBy('created_at', 'desc')->take(8)->get());

        // Get Popular Post Ordering By Post Like When Post Status is Published
        $popular = PostResource::collection(Post::where('post_status', '=', 'publish')
            ->orderBy('post_like', 'desc')->take(8)->get());

        return response()->json([
            "new"      => $new,
            "popular"  => $popular
        ],200);
    }

    // Get Popular Post Ordering By Post Like When Post Status is Published
    public function popularPost()
    {
        $popular = PostResource::collection(Post::where('post_status', '=', 'publish')
            ->orderBy('post_like', 'desc')->take(10)->get());

        return response()->json([
            "popular"  => $popular
        ],200);
    }


    // Get New Post Add When Post Status is Published
    public function lastPost()
    {
        $last = PostResource::collection(Post::where('post_status', '=', 'publish')->latest()->take(10)->get());

        return response()->json([
            "lastpost"  => $last,
        ],200);
    }
// ==================== Actors  ==================== //

    // Get ALl Actors
    public function actors()
    {
        return ActorResource::collection(Actor::orderBy('created_at', 'desc')->paginate(15));
    }

    // Get Actor Info Page & Show All Post Partake This Actor
    public function actorPage($id)
    {
        $act_id = Actor::findOrFail($id);
        $actor = ActorResource::collection(Actor::with('post:id,title,slug,photo')->where('id' , $id)->get());
        return response()->json([
            "actor" => $actor
        ],200);
    }

// ==================== Category  ==================== //

    // Get All Category
    public function categories()
    {
        return CategoryResource::collection(Category::orderBy('created_at', 'desc')->paginate(15));
    }


    // Get Category Info Page With All Post Use This Category
    public function categoryPage($id)
    {
        $cats_id = Category::findOrFail($id);
        $categories = CategoryResource::collection(Category::with('post:id,title,slug,photo')->where('id' , $id)->get());
        return response()->json([
            "categories" => $categories
        ],200);
    }

// ==================== Tags ==================== //


    // Get Tag With All Post Use This Tag
    public function tagPage($id)
    {
        $tag_id = Tag::findOrFail($id);
        $tag = TagResource::collection(Category::with('post:id,title,slug,photo')->where('id' , $id)->get());
        return response()->json([
            "tag" => $tag
        ],200);
    }

// ==================== Single Page Post ==================== //

    // Get Post Content In Single Page
    public function singlePage($id) {

        $singelpost = PostResource::collection(Post::where('id' , $id)->where('post_status', '=', 'publish')->get());

        return response()->json([
            "singlePost" => $singelpost
        ],200);
    }

// ==================== Search Page ==================== //

    // Get Search Results
    public function search(Request $request)
    {
        $data = $request->get('data');

        $posts = PostResource::collection(Post::where('post_status', '=', 'publish')
                        ->where('title', 'like', "%{$data}%")
                        ->orWhere('slug', 'like', "%{$data}%")
                        ->latest()->paginate(10));

        return response()->json([
            "posts" => $posts
        ],200);

    }

// ==================== Post Like Count ==================== //

    public function postlike($id)
    {
        $post = Post::where('id' , $id)->first();
        $post->increment('post_like');
        $post->save();
        return response()->json([
            "like" => $post->post_like
        ],200);

    }

}
