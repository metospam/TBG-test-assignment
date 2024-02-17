<?php

namespace App\Services\Impl;

use App\Services\UploadService;
use Illuminate\Http\UploadedFile;

class UploadServiceImpl implements UploadService
{

    /**
     * Uploads a file to the server.
     *
     * @param UploadedFile $file The file to be uploaded.
     * @return string The path to the uploaded file.
     */
    public function uploadFile(UploadedFile $file): string
    {
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $imageName);

        return 'uploads/' . $imageName;
    }

    /**
     * Deletes the specified file if it exists.
     *
     * This method checks if the file exists at the given path, and if it does,
     * it attempts to delete it. If the file does not exist, no action is taken.
     *
     * @param string $filePath The path to the file to be deleted.
     * @return void
     */
    public function unlink(string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

}
