<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResources extends JsonResource
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
            "id"                 => $this->id,
            "name"               => $this->name,
            "email"              => $this->email,
            "body"               => $this->body,
            "parent_id"          => $this->parent_id,
            "commentable_id"     => $this->commentable_id,
            "commentable_type"   => $this->commentable_type,
        ];
    }
}
