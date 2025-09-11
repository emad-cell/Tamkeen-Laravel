<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'About_Footer' => $this->about_footer,
            'Phone1' => $this->phone1,
            'Email1' => $this->email1,
            'Facebook' => $this->facebook,
            'Linkedin' => $this->linkedin,
            'Instagram' => $this->instagram,
            'Youtube' => $this->youtube,
        ];
    }
}
