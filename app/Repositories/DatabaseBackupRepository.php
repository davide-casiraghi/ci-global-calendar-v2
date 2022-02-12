<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseBackupRepository
{

    /**
     * Get all backup files from /storage/app/Laravel.
     *
     * @return array
     */
    public function getAll(): array
    {
        $fileNames = Storage::files(env('APP_NAME'));
        $ret = [];
        foreach($fileNames as $fileName){
            if (str_ends_with($fileName, '.zip')) {
                $ret[] = [
                    'fileName' => substr($fileName, strrpos($fileName, '/' )+1),
                    'size' => '123423',
                ];
            }
        }

        return $ret;
    }

    /**
     * Download db backup file
     *
     * @param  string  $file_name
     * @return StreamedResponse
     */
    function downloadFile(string $file_name): StreamedResponse
    {
        return Storage::download(env('APP_NAME').'/'.$file_name);
    }

    /**
     * Delete db backup file
     *
     * @param  string  $file_name
     * @return void
     */
    public function delete(string $file_name): void
    {
        Storage::delete(env('APP_NAME').'/'.$file_name);
    }
}
