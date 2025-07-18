<?php

namespace App\Models;

use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = "app_experiences";
    protected $primaryKey = "id_experience";

    protected $guarded = [];

    public function thumbnail(){
        return $this->belongsTo(Image::class,'image_id')->where('type',ImageType::EXPERIENCE_THUMBNAIL);
    }
    public function slideImages(){
        return $this->hasMany(Image::class, 'parent_id')->where('type',ImageType::EXPERIENCE_CAROUSEL);
    }
}
