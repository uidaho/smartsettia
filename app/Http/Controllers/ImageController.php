<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show an image stored in private storage
     *
     * @param int $device_id
     * @return \Illuminate\Http\Response
     */
    public function show($device_id)
    {
        if (Storage::disk('private')->exists('deviceimage/'.$device_id))
            $image = Image::make(Storage::disk('private')->get('deviceimage/'.$device_id));
        else
            $image = Image::make('/img/video_not_found.jpg');
        
        return $image->response();
    }
    
    /**
     * Save an image to private storage
     *
     * @param int $device_id
     * @param string $binaryData
     * @return \Illuminate\Http\Response
     */
    public function store($device_id, $binaryData)
    {
        $storagePath = storage_path('app/private/deviceimage/').$device_id;
        $image = Image::make($binaryData);
        $image->save($storagePath, 75);
    }
}
