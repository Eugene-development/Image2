<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {

        $token = $request->bearerToken();



        if($token == '1' || $token == '4'){
            $path = $request->file('image')->store('images', 's3');

//            dd(basename($path));

            //        Или ткут паблик делать, или в конфигах s3 добавить 'visibility' => 'public', или на самом aws
            Storage::disk('s3')->setVisibility($path, 'public');

            $image = Image::create([
                'project_id' => $request->bearerToken(),
                'filename' => basename($path),
                'url' => Storage::disk('s3')->url($path),
                'tagable_id' => $request->file('image')->getClientOriginalName()
            ]);

            return $image;
        }

        if($token == '2'){
//            dd($request->file('image'));

            $path = $request->file('image')->store('luba-mebel/products', 's3');
//            dd(basename($path));
            //        Или ткут паблик делать, или в конфигах s3 добавить 'visibility' => 'public', или на самом aws
            Storage::disk('s3')->setVisibility($path, 'public');

            $image = Image::create([
                'project_id' => $request->bearerToken(),
                'filename' => basename($path),
                'url' => Storage::disk('s3')->url($path),
                'tagable_id' => $request->file('image')->getClientOriginalName()
            ]);

            return $image;
        }

        if($token == '3'){
            $path = $request->file('image')->store('mebel-mobile/products', 's3');

            //        Или ткут паблик делать, или в конфигах s3 добавить 'visibility' => 'public', или на самом aws
            Storage::disk('s3')->setVisibility($path, 'public');

            $image = Image::create([
                'project_id' => $request->bearerToken(),
                'filename' => basename($path),
                'url' => Storage::disk('s3')->url($path),
                'tagable_id' => $request->file('image')->getClientOriginalName()
            ]);

            return $image;
        }
    }

    public function show(Request $request, Image $image) //TODO этот метод вообще нужен?
    {
        $token = $request->bearerToken();

        if($token == '1') {
            return Storage::disk('s3')->response('images/' . $image->filename);
        }

        if($token == '2') {
            return Storage::disk('s3')->response('luba-mebel/products' . $image->filename);
        }

        if($token == '3') {
            return Storage::disk('s3')->response('mebel-mobile/products' . $image->filename);
        }

    }

    public function delete(Request $request, $param)
    {
        Image::where('project_id', $request->bearerToken())
            ->where('tagable_id', $param)
            ->delete();
    }
}
