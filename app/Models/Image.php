<?php

namespace App\Models;
use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'app_images';
    protected $primaryKey = 'id_image';

    protected $casts = [
        'type' => ImageType::class,
    ];

    protected $guarded = [];
}
