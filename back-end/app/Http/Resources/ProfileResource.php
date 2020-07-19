<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
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
            "id"          => $this->id,
            "user_id"     => $this->user_id,
            "avatar"      => config('frontend.img_app_link').Storage::url('images/avatar/' . $this->avatar),
            "nickname"    => $this->nickname,
            "description" => $this->description,
            "about"       => $this->about,
            "phone"       => $this->phone,
            "facebook"    => $this->facebook,
            "twitter"     => $this->twitter,
            "instagram"   => $this->instagram,
            "youtube"     => $this->youtube,
            "user"        => new UserResource($this->user)
        ];
    }

}
