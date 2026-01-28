<?php

namespace App\Http\Resources\Cabinet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CabinetShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
