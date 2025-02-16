<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $primaryKey = 'image_id';

    protected $fillable = [
        'image_name',
        'product_id',
        'image_name'
    ];
}
