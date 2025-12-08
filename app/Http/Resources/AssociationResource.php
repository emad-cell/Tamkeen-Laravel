<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name'=>$this->full_name,
            'email'=>$this->email,
            'mobile_numper'=>$this->mobile_number,
            'user_id'=>$this->user_id,
            'id'=>$this->id,
            'lisence'=>$this->lisence,
            'image'         => $this->image
                ? asset('storage/' . $this->image)  // يرجع URL كامل
                : null,
        ];
    }
}
