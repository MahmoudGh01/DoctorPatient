<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\Cabinet\CabinetShowResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'status' => $this->status,
            'datetime' => $this->datetime,
            'patient' => new UserResource($this->whenLoaded('patient')),
            'cabinet' => new CabinetShowResource($this->whenLoaded('cabinet')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
