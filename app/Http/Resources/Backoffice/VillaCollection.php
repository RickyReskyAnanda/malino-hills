<?php
 
namespace App\Http\Resources\Backoffice;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class VillaCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_villa,
            'name' => $this->name,
            'status' => $this->status,
            'short_description' => $this->short_description,
            'price' => 'Rp '.number_format($this->price),
            'villa_count' => number_format($this->villa_count),
            'thumbnail' => $this?->images?->path_original ? url($this->images?->path_original): null,
        ];
    }
}
