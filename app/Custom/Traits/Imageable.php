<?php

namespace App\Custom\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait Imageable
{
	private $imagesNotToDelete = ['avatar.png', 'camera.png', 'loading.gif', 'no-image.jpg'];

	/**
	 * Delete image
	 *
	 * @param string $column
	 */
	public function deleteImage(string $column = 'image'): void
	{
		$originalName = $this->attributes[$column];

		if ($originalName && !in_array($originalName, $this->imagesNotToDelete)) {
			$this->deleteRelatedImages($column);
			Storage::delete($this->imagePath($column));
		}
	}

	/**
	 * Set upload folder name after public/storage/
	 *
	 * @param string $column
	 *
	 * @return string
	 */
	public function imageUploadFolder(string $column = 'image'): string
	{
		$className = Str::kebab(class_basename($this));
		$column    = Str::plural($column);

		return "images/{$className}/{$column}";
	}

	/**
	 * Get image url
	 *
	 * @param string $column
	 *
	 * @return string
	 */
	public function imageUrl(string $column = 'image'): string
	{
		try {
			$originalName = $this->attributes[$column];

			if (in_array($originalName, $this->imagesNotToDelete)) {
				return myAsset("storage/images/{$originalName}");
			}

			return myAsset('storage/' . $this->imagePath($column));
		} catch (\Throwable $th) {
			return '';
		}
	}

	/**
	 * Get modified image
	 *
	 * @param int $x
	 * @param int $y
	 * @param string $column
	 *
	 * @param string $modificationType
	 *
	 * @return string
	 */
	private function modifyImage($x = 100, $y = 100, string $column = 'image', string $modificationType = 'crop'): string
	{
		$imageName = $this->attributes[$column];


		$imagePath = $this->imagePath($column);


		if (!$imageName) {
			// return no-image.jpg url
			return $this->imageUrl($column);
		}

		$img = Image::make(public_path("storage/{$imagePath}"));

		$fileNameWithoutExt     = $img->filename;
		$imageDestinationName   = $x . "x" . ($y ?? "auto") . "." . $img->extension;
		$imageDestinationFolder = $this->imageUploadFolder($column) . '/modified/' . $fileNameWithoutExt . '/' . $modificationType;
		$imageDestinationPath   = $imageDestinationFolder . '/' . $imageDestinationName;



		if (!Storage::exists('public/' . $imageDestinationFolder)) {
			Storage::makeDirectory('public/' . $imageDestinationFolder);
		}


		if (!Storage::exists('public/' . $imageDestinationPath)) {
			switch ($modificationType) {
				case 'resize':
					$img->resize($x, $y, function ($constraint) {
						$constraint->aspectRatio();
						$constraint->upsize();
					});
					break;
				default:
					$img->fit($x, $y);
					break;
			}

			$img->save(public_path("storage/{$imageDestinationPath}"));
		}

		return myAsset("storage/{$imageDestinationPath}");
	}

	/**
	 * Get cropped image
	 *
	 * @param int $x
	 * @param int $y
	 * @param string $column
	 *
	 * @return string
	 */
	public function cropImage(int $x = 100, int $y = 100, string $column = 'image'): string
	{
		return $this->modifyImage($x, $y, $column);
	}

	/**
	 * Get resized image
	 *
	 * @param int $x
	 * @param int $y
	 * @param string $column
	 *
	 * @return string
	 */
	public function resizeImage($x = 100, $y = 100, string $column = 'image'): string
	{
		return $this->modifyImage($x, $y, $column, 'resize');
	}

	// deletes images starting with the same name as current image name
	private function deleteRelatedImages(string $column = 'image'): void
	{
		$imageName = $this->attributes[$column];
		// if we don't have previous image then no need to delete it.
		if ($imageName && Storage::exists($this->imagePath($column))) {
			$modifiedImageDirectory = $this->imageUploadFolder($column) . '/modified/' . explode('.', $imageName)[0];

			Storage::deleteDirectory($modifiedImageDirectory);
		}
	}

	public function imagePath(string $column = 'image'): string
	{
		$originalName = $this->attributes[$column];
		if (!$originalName) {
			return 'images/no-image.jpg';
		}

		$uploadFolder = $this->imageUploadFolder($column);

		return "{$uploadFolder}/{$originalName}";
	}

	public function getImageAttribute($value): string
	{
		return $this->imageUrl();
	}

	public function getOriginalImage(string $column = 'image'): string
	{
		$imageName = $this->attributes[$column];

		return !is_null($imageName)
			? route('get-image', [$imageName])
			: route('get-image', ['no-image.jpg']);
	}

	public function addWatermark($watermarkImage, $column = 'image'): string
	{
		$imageName = $this->attributes[$column];

		if ($imageName && Storage::exists("images/{$imageName}")) {
			$imagePath = config('defaults.image_path') . '/';

			if (!Storage::exists("images/watermark.png")) {
				$watermarkImg = Image::make($imagePath . $watermarkImage);
				$watermarkImg->fit(50, 50, function ($constraint) {
					$constraint->upsize();
				});
				$watermarkImg->save($imagePath . "watermark.png");
			}

			$image = Image::make($imagePath . $imageName);
			$image->insert($imagePath . 'watermark.png', 'bottom-right', 10, 10);
			$image->save($imagePath . "watermarked/{$imageName}");
		}

		return route('get-image', [$imageName]);
	}
}
