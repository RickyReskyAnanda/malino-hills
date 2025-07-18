<?php

namespace App\Models;

use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    use HasFactory;

    protected $table = "app_villas";
    protected $primaryKey = "id_villa";

    protected $guarded = [];
    public function booking(){
        return $this->hasMany(Booking::class, 'villa_id');
    }
    public function facilities(){
        return $this->hasMany(VillaFacility::class, 'villa_id')->where('status_highlight','REGULER');
    }

    public function highlightFacilities(){
        return $this->hasMany(VillaFacility::class, 'villa_id')->where('status_highlight','HIGHLIGHT');
    }

    public function images(){
        return $this->belongsTo(Image::class, 'thumbnail_image_id')->where('type', ImageType::VILLA_THUMBNAIL);
    }

    public function slideImages(){
        return $this->hasMany(Image::class, 'parent_id')->where('type',ImageType::VILLA_CAROUSEL);
    }

    public function villaNumber(){
        return $this->hasMany(VillaNumber::class, 'villa_id');
    }
}
