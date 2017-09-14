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
        $imagePath = glob($storagePath . $device_id . "*" . ".JPG")[0];
        $image = Image::make($imagePath);
        
        return $image->response();
    }
}
