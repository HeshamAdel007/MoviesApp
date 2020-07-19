<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResources;
use App\Http\Requests\CommentRequest;
use App\Comment;
use App\post;
use App\User;

class CommentController extends Controller
{
    public function show($id) {
        $post = Post::findOrFail($id);
        $comment = CommentResources::collection(Comment::where('commentable_id', '=', $id)->where('parent_id', '=', null)->orderBy('created_at', 'desc')->get());

        //$comment = CommentResources::collection(Comment::where('commentable_id', '=', $id)->orderBy('created_at', 'desc')->get());

        if (count($comment) == 0) {
            return response()->json([
                'comments' => "No Have Any Comment On This Post",
            ]);
        } else {
            $commentCount = count(Comment::where('commentable_id', '=', $id)->get());
            return response()->json([
                "comments" => $comment,
                "count"    => $commentCount
            ]);
        }
    }
    public function showReply($id) {
        $post = Post::findOrFail($id);
        $reply = CommentResources::collection(Comment::where('commentable_id', '=', $id)->where('parent_id', '!=', null)->orderBy('created_at', 'desc')->get());

        return response()->json([
            "replys" => $reply,
        ]);

    }


    public function store(CommentRequest $request)
    {

        $comment        = new Comment;
        $comment->name  = $request->name;
        $comment->email = $request->email;
        $comment->body  = $request->body;

        $comment->user()->associate($request->user());

        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);
        return $comment->toJson();
    }

    public function replyStore(CommentRequest $request)
    {

        $reply        = new Comment();
        $reply->name  = $request->name;
        $reply->email = $request->email;
        $reply->body  = $request->body;

        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

       return $reply->toJson();

    }
}
