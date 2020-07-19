<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "id"         => $this->id,
            "name"       => $this->name,
            "slug"       => $this->slug,
            "parent_id"  => $this->subcategory,
            "post"       => PostResource::collection($this->whenLoaded('post'))
        ];
    }
}
