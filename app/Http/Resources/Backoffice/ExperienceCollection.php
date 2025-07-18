<?php
 
namespace App\Http\Resources\Backoffice;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class ExperienceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_experience,
            'no' => $this->no,
            'title' => $this->title,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail?->path_portrait ? url($this->thumbnail?->path_portrait) : null,
        ];
    }
}
