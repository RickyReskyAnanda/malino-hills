<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaFacility extends Model
{
    use HasFactory;


    protected $table = "app_villas_facilities";
    protected $primaryKey = "id_villa_facility";

    protected $guarded = [];

    public function icon(){
        return $this->belongsTo(Icon::class,'icon_id');
    }

}
