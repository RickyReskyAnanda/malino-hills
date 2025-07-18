<?php
 
namespace App\Http\Resources\Backoffice;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class FacilityCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_facility,
            'name' => $this->name,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail?->path_original ? url($this->thumbnail?->path_original) : null,
            'description' => $this->description,
        ];
    }
}
