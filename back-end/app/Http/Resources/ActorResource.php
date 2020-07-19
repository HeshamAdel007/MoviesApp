<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostResource;
use App\Post;


class ActorResource extends JsonResource
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
            "id"           => $this->id,
            "name"         => $this->name,
            "description"  => $this->description,
            "post"         => PostResource::collection($this->whenLoaded('post')),
            "photo"        => config('frontend.img_app_link').Storage::url('images/actor/' . $this->photo),
        ];
    }
}
