<?php

namespace App\Helpers;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageHelpers
{

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param object $model
     * @param object $request
     * @param string $collectionName
     *
     * @return void
     */
    public static function storeImages(object $model, object $request, string $collectionName): void
    {
        if (!$request->file($collectionName)) {
            return;
        }

        if (is_array($request->file($collectionName))) { // Store multiple images
            foreach ($request->file($collectionName) as $file) {
                if ($file->isValid()) {
                    $model->addMedia($file)->toMediaCollection($collectionName);
                }
            }
        } else { // Store single image
            $file = $request->file($collectionName);
            if ($file->isValid()) {
                $model->addMedia($file)->toMediaCollection($collectionName);
            }
        }
    }

    /**
     * Delete photos from the Spatie Media Library
     *
     * @param object $model
     * @param object $request
     * @param string $collectionName
     *
     * @return void
     */
    public static function deleteImages(object $model, object $request, string $collectionName): void
    {
        if ($request->introimage_delete == 'true') {
            $mediaItems = $model->getMedia($collectionName);
            if (!is_null($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
        }
    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param object $model
     * @param string $collectionName
     *
     * @return array
     */
    public static function getThumbsUrls(object $model, string $collectionName): array
    {
        $thumbUrls = [];

        //$model = $this->getById($modelId);
        foreach ($model->getMedia($collectionName) as $photo) {
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

    /**
     * Store an image using Spatie Media Library
     * The $photo parameter is an image in Base64 string format.
     *
     * @param object $model
     * @param string|null $photo
     * @param string $collectionName
     */
    public static function storeImageFromLivewireComponent(object $model, ?string $photo, string $collectionName): void
    {
        if (!$photo) {
            return;
        }

        $file = self::convertBase64ImageToUploadedFile($photo);
        $model->addMedia($file)->toMediaCollection($collectionName);
    }

    /**
     * Convert a base64 image to UploadedFile Laravel
     *
     * @param string $base64File
     *
     * @return \Illuminate\Http\UploadedFile
     */
    public static function convertBase64ImageToUploadedFile(string $base64File): UploadedFile
    {
        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        return $file;
    }

}
