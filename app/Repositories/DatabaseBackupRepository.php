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
        $storageFilePaths = Storage::files('laravel-backup');
        $ret = [];
        foreach($storageFilePaths as $storageFilePath){
            if (str_ends_with($storageFilePath, '.zip')) {
                $backupFileName = substr($storageFilePath, strrpos($storageFilePath, '/' )+1);
                $backupFileSizeInBytes = Storage::size('laravel-backup/'.$backupFileName);
                $backupFileSizeInMB = round($backupFileSizeInBytes/1048576, 2);

                $ret[] = [
                    'fileName' => $backupFileName,
                    'size' => $backupFileSizeInMB,
                    //'size' => Storage::size('public/databaseBackups/file.jpg'),

                    //https://ci_global_calendar_v2.local/databaseBackups/2022-02-12-11-58-35.zip

                   // Storage::size('public/settings/file.jpg');;
                   // File::size(public_path('image/house2.jpeg'));

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
