<?php

use App\LiveClass;
use App\Assignment;
use App\Custom\time_online;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

function myAsset($url)
{
    return asset($url);
}

/**
 * Admin asset path
 *
 * @param string $url
 *
 * @return string
 */
function adminAssetsUrl($url)
{
    return myAsset("dashboard/" . $url);
}

/**
 * Make slug from the provided string
 *
 * @param string $str
 *
 * @return string
 */
function asdhStrSlug($str)
{
    //return str_slug($str) . '-' . date('YmdHis');
    $str_final = str_replace('&', 'and', $str);

    return Str::slug($str_final);
}

/**
 * Returns array from string. Splits the string at white space
 *
 * @param string $string
 *
 * @return array
 */
function stringToArray($string)
{
    // removes all white spaces and return array
    return preg_split('/\s+/', $string);
}

/**
 * Generate random alpha-numeric string
 *
 * @param integer $length
 * @param string $string
 *
 * @return string
 */
function randomAlphaNumericString($length = 6, $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max    = mb_strlen($string, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $string[random_int(0, $max)];
    }

    return implode('', $pieces);
}

/**
 * Generate random numeric string
 *
 * @param integer $length
 * @param string $string
 *
 * @return string
 */
function randomNumericString($length = 6, $string = '0123456789')
{
    return randomAlphaNumericString($length, $string);
}

/**
 * Generate random string
 *
 * @param integer $length
 * @param string $string
 *
 * @return string
 */
function randomString($length = 6, $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    return randomAlphaNumericString($length, $string);
}

/**
 * Return success json response
 *
 * @param mixed $message
 * @param integer $statusCode
 *
 * @return mixed
 */
function successResponse($message, $statusCode = 200, $code = 200)
{
    return response()->json([
        'status'     => true,
        'message'    => $message,
        'statusCode' => $statusCode,
    ], $code);
}

/**
 * Return failure json response
 *
 * @param mixed $message
 * @param integer $statusCode
 * @param int $code
 *
 * @return mixed
 */
function failureResponse($message, $statusCode = 404, $code = 404)
{
    return response()->json([
        'status'     => false,
        'message'    => $message,
        'statusCode' => $statusCode == 0 ? 418 : $statusCode,
    ], $code == 0 ? 418 : $code);
}

/**
 * Modify image as per modification method
 *
 * @param string $imageName
 * @param integer $x
 * @param integer|null $y
 * @param string $modificationMethod
 *
 * @return string
 */
function modifyImage($imageName, $x, $y, $modificationMethod)
{
    $imagePath         = config('defaults.image_path') . '/';
    $modifiedImagePath = config('defaults.image_path_modified') . '/';

    /**
     * is_null($imageName)                   = if image is not uploaded
     * !file_exists($imagePath . $imageName) = if accidentally uploaded image is deleted but..
     * ..the image name is still present in the database
     * */
    if (!$imageName || !Storage::exists("images/{$imageName}")) {
        $imageName = "no-image.jpg";
    }
    $img = Image::make($imagePath . $imageName);

    $fileNameWithoutExt   = $img->filename;
    $imageDestinationName = $x . "x" . $y . "." . $img->extension;
    $imageDestinationPath = $modifiedImagePath . $fileNameWithoutExt . '/' . $imageDestinationName;

    if (!Storage::exists("images/modified/{$fileNameWithoutExt}")) {
        Storage::makeDirectory("images/modified/{$fileNameWithoutExt}");
    }

    if (!Storage::exists("images/modified/{$fileNameWithoutExt}/{$imageDestinationName}")) {
        // resize image instance with changing aspect ratio
        if ($modificationMethod === 'crop') {
            $img->fit($x, $y);
        } // resize the image to a width of 300 and constrain aspect ratio (auto height)
        elseif ($modificationMethod === 'resize') {
            $img->resize($x, $y, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // save image
        $img->save($imageDestinationPath);
    }

    return "/images/{$fileNameWithoutExt}/{$imageDestinationName}";
}

/**
 * Crop image
 *
 * @param string $imageName
 * @param integer $x
 * @param integer $y
 *
 * @return string
 */
function cropImage($imageName, $x = 100, $y = 100)
{
    return modifyImage($imageName, $x, $y, 'crop');
}

/**
 * Resize Image
 *
 * @param string $imageName
 * @param integer $x
 * @param integer|null $y
 *
 * @return string
 */
function resizeImage($imageName, $x = 100, $y = null)
{
    return modifyImage($imageName, $x, $y, 'resize');
}

/**
 * Encrypt file at the given path
 *
 * @param string $fileUrl
 *
 * @return string
 */
function encryptFile($fileUrl)
{
    $fileContents = file_get_contents($fileUrl);

    $encryptedFile = file_put_contents($fileUrl, encrypt($fileContents));

    return $encryptedFile;
}

/**
 * Decrypt file at the given path
 *
 * @param string $fileUrl
 * @param string $contentType
 *
 * @return void
 */
function decryptFile($fileUrl, $contentType = 'image/jpg')
{
    $fileContents = file_get_contents($fileUrl);
    header("Content-Type: {$contentType}");

    echo decrypt($fileContents);
}

/**
 * Converts null values of the array to empty string
 *
 * @param array $array
 * @param array $exceptKeys
 *
 * @return array
 */
function nullToEmptyStringOfArray(array $array, array $exceptKeys = []): array
{
    array_walk_recursive($array, function (&$val, $key) use ($exceptKeys) {
        if (!in_array($key, $exceptKeys)) {
            $val = $val ?? '';
        }
    });

    return $array;
}

/**
 * Change keys of an array to camel case
 *
 * @param array $array
 *
 * @return array
 */
function makeKeyCamelCased(array $array)
{
    $returnData = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = makeKeyCamelCased($value);
        }
        $returnData[Str::camel($key)] =  $value;
    }

    return $returnData;
}



// For add'active' class for activated route nav-item
function active_class($path, $active = 'active')
{
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

// For checking activated route
function is_active_route($path)
{
    return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

// For add 'show' class for activated route collapse
function show_class($path)
{
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}