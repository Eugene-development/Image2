<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->file('image')->getClientOriginalName());
        $path = $request->file('image')->store('images', 's3');

        //        Или ткут паблик делать, или в конфигах s3 добавить 'visibility' => 'public', или на самом aws
        Storage::disk('s3')->setVisibility($path, 'public');

        $image = Image::create([
            'filename' => basename($path),
            'url' => Storage::disk('s3')->url($path),
            'product_id' => $request->file('image')->getClientOriginalName()
        ]);

        return $image;
    }

    public function show(Image $image)
    {
        return Storage::disk('s3')->response('images/' . $image->filename);
    }
}
