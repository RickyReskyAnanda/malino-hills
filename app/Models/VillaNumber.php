<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaNumber extends Model
{
    use HasFactory;

    protected $table = "app_villas_number";
    protected $primaryKey = "id_villa_number";

    protected $guarded = [];
}
