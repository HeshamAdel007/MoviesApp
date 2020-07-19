<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id"             => $this->id,
            "title"          => $this->title,
            "slug"           => $this->slug,
            "content"        => $this->content,
            "post_status"    => $this->post_status,
            "comment_status" => $this->comment_status,
            "view_count"     => $this->view_count,
            "post_like"      => $this->post_like,
            "trailer"        => $this->trailer,
            "categories"     => $this->category,
            //"date"           => $this->created_at->format('F, d, Y'),
            "user_id"        => new UserResource($this->user),
            "actors"         => ActorResource::collection($this->actor),
            "tags"           => TagResource::collection($this->tag),
            "photo"          => config('frontend.img_app_link').Storage::url('images/post/' . $this->photo),
        ];
    }
}
