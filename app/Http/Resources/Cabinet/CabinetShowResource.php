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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            //'author' => new AuthorShowResource($this->author),
            'promo_url' => route('cabinets.show', ['cabinet' => $this->id]),
            //'comments' => CommentIndexResource::collection($this->whenLoaded('comments')),
        ];    }
}
