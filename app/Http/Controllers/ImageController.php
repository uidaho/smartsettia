<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

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
        $storagePath = storage_path('app/images/devices/');
        $imagePath = glob($storagePath . $device_id . "*" . ".jpg");
        
        if (!empty($imagePath))
            $image = Image::make($imagePath[0]);
        else
        {
            $imagePath = public_path() . '/img/video_not_found.jpg';
            $image = Image::make($imagePath);
        }
        
        return $image->response();
    }
    
    /**
     * Save an image's binary as a jpg to private storage
     *
     * @param int $device_id
     * @param string $binaryData
     * @return \Illuminate\Http\Response
     */
    public function store($device_id, $binaryData)
    {
        $storagePath = storage_path('app/images/devices/') . $device_id . '.jpg';
        $image = Image::make($binaryData);
        $image->save($storagePath, 75);
    }
}
