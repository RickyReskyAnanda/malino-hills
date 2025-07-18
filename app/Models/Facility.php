<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;


    protected $table = "app_facilities";
    protected $primaryKey = "id_facility";

    protected $guarded = [];

    public function thumbnail(){
        return $this->belongsTo(Image::class,'image_id');
    }

}
