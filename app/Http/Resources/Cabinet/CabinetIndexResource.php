<?php

namespace App\Http\Resources\Cabinet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CabinetIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'Speciality' => $this->name,
            'location' => Str::limit($this->location,20),
            //'doctor' => new DoctorShowResource($this->whenLoaded('doctor')),
            'image_url' => $this->doctor->getImageUrl('preview'),
            'link' => route('api.cabinets.show', ['id' => $this->id]),
            'promo_url' => route('cabinets.show', ['cabinet' => $this->id]),
        ];
    }
}
