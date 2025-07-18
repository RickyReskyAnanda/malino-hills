<?php

namespace App\Models;

use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = "app_venue";
    protected $primaryKey = "id_venue";

    protected $guarded = [];

    public function slideImages(){
        return $this->hasMany(Image::class, 'parent_id')->where('type',ImageType::VENUE);
    }
}
