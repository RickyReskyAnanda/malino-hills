<?php
 
namespace App\Http\Resources\Backoffice;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class VillaFacilityCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_villa_facility,
            'name' => $this->name,
            'icon' => isset($this->icon) ? asset($this->icon->path ?? '') : null,
        ];
    }
}
