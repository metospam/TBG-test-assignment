<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfUploadRequest;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{

    /**
     * Constructs a new instance of the UploadHandler.
     *
     * @param UploadService $uploadService The service responsible for handling file uploads.
     */
    public function __construct(
        protected UploadService $uploadService,
    )
    {
    }

    /**
     * Handles the upload of a PDF file.
     *
     * @param PdfUploadRequest $request The HTTP request containing the uploaded file.
     * @return JsonResponse A JSON response containing the path to the uploaded file.
     */
    public function handleUploadFile(PdfUploadRequest $request)
    {
        $data = $request->validated();
        $filePath = $this->uploadService->uploadFile($data['file']);

        return response()->json([
            'src' => $filePath,
        ]);
    }

}
