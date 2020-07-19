<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use App\Tag;

class DashboardController extends Controller
{

    public function index()
    {
        $user     = User::count();
        $post     = Post::count();
        $tag      = Tag::count();
        $category = Category::count();
        return response()->json([
            'user'     => $user,
            'post'     => $post,
            'tag'      => $tag,
            'category' => $category
        ],200);
    }
}
