<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\InferencedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogInferencedImageController extends Controller
{
    public function logImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'mimes:png,jpg,jpeg'],
            'class' => ['required'],
            'probabilities' => ['required', 'decimal:2']
        ]);

        $img_filename = $request->file('image')->getClientOriginalName();
        $img_size = $request->file('image')->getSize();


        $img_filepath = Storage::disk('local')->putFile('inferenced-images', $request->file('image'));

        $create = InferencedImage::create([
            'image_path' => $img_filepath,
            'img_file_name' => $img_filename,
            'system_predicted_class' => $request->class,
            'class_probability' => (float) $request->probabilities,
        ]);

        if (!$create) return response()->json([], 500);

        return response()->json([], 200);
    }
}
