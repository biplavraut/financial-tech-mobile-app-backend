<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function getImage($imageName, $imageSize = null)
    {
        if ($imageName == 'watermarked') {
            return response()->download(storage_path("app/public/images/watermarked/{$imageSize}"), null, [], null);
        }

        if (!$imageSize) {
            return response()->download(storage_path("app/public/images/{$imageName}"), null, [], null);
        }

        return response()->download(storage_path("app/public/images/modified/{$imageName}/{$imageSize}"), null, [], null);
    }
}
