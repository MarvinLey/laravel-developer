<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GolferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * Gibt nur relevante Felder zurück und Fügt den String 'km' hinzu
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'debitor_account' => $this->debitor_account,
            'name' => $this->name,
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'distance' => round($this->distance, 2) . ' km',
            ];
    }
}
