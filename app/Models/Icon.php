<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon  extends Model
{
    use HasFactory;

    protected $table = "app_icons";
    protected $primaryKey = "id_icon";

    protected $guarded = [];

}
