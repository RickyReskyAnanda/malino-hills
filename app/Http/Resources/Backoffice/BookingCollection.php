<?php
 
namespace App\Http\Resources\Backoffice;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class BookingCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_booking,
            'd_1' => $this->d_1,
            'd_2' => $this->d_2,
            'd_3' => $this->d_3,
            'd_4' => $this->d_4,
            'd_5' => $this->d_5,
            'd_6' => $this->d_6,
            'd_7' => $this->d_7,
            'd_8' => $this->d_8,
            'd_9' => $this->d_9,
            'd_10' => $this->d_10,
            'd_11' => $this->d_11,
            'd_12' => $this->d_12,
            'd_13' => $this->d_13,
            'd_14' => $this->d_14,
            'd_15' => $this->d_15,
            'd_16' => $this->d_16,
            'd_17' => $this->d_17,
            'd_18' => $this->d_18,
            'd_19' => $this->d_19,
            'd_20' => $this->d_20,
            'd_21' => $this->d_21,
            'd_22' => $this->d_22,
            'd_23' => $this->d_23,
            'd_24' => $this->d_24,
            'd_25' => $this->d_25,
            'd_26' => $this->d_26,
            'd_27' => $this->d_27,
            'd_28' => $this->d_28,
            'd_29' => $this->d_29,
            'd_30' => $this->d_30,
            'd_31' => $this->d_31,
            'number' => $this->number,
            'villa' => $this->villa?->name ?? '-'

        ];
    }
}
