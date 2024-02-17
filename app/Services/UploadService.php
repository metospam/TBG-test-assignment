<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface UploadService
{
    public function uploadFile(UploadedFile $file): string;
    public function unlink(string $filePath): void;
}
