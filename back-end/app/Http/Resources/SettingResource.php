<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            //'id'          => $this->id,
            "name"        => $this->name,
            "email"       => $this->email,
            "adress"      => $this->adress,
            "description" => $this->description,
            "facebook"    => $this->facebook,
            "twitter"     => $this->twitter,
            "instagram"   => $this->instagram,
            "youtube"     => $this->youtube,
            "logo"        => config('frontend.img_app_link').Storage::url('images/logo/' . $this->logo),
        ];
    }
}
