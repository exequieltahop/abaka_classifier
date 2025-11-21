<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InferencedImage extends Model
{
    /**
     * status
     *  1 - for unvalidate
     *  2 - for accurate
     *  3 - for lest accurate
     *  4 - not accurate
     */
    protected $fillable = [
        'image_path',
        'img_file_name',
        'status',
        'system_predicted_class',
        'class_probability',
        'expert_validation',
    ];
}
