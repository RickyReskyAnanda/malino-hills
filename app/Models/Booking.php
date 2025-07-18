<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "app_booking";
    protected $primaryKey = "id_booking";

    protected $guarded = [];

    public function villa(){
        return $this->belongsTo(Villa::class, 'villa_id');
    }
}