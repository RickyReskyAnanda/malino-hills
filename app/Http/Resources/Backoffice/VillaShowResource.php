<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VillaShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_villa,  
            'name' => $this->name,  
            'status' => $this->status,  
            'price' => $this->price,  
            'villa_count' => $this->villa_count,  
            'short_description' => $this->short_description,  
            'content' => $this->content,  
            'thumbnail' => $this?->images?->path_original ? asset($this?->images?->path_original) : null,  
        ];
    }
}
