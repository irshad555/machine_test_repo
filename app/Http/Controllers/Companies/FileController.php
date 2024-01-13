<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUploadRequest;

/**
 * FileController
 */
class FileController extends Controller
{
    /**
     * tempFileUpload
     *
     * @param  mixed $request
     * @return void
     */
    public function tempFileUpload(FileUploadRequest $request)
    {
        
        //upload file
        $file = $request->file('file');
        $fileName = (string)Str::orderedUuid();
        $previewFileName = $fileFullName = $fileName . "." . $file->getClientOriginalExtension();
        //upload in temp folder
        Storage::disk('public')->putFileAs('temp', $file, $fileFullName);
        //create thumbnail
        if (isImage($fileFullName)) {
            Storage::disk('public')->putFileAs('temp/thumbnail', $file, $fileFullName);
        }
        return [
            'name' => $file->getClientOriginalName(),
            'ext' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'url' => $fileFullName,
            'thumbnail_url' => $previewFileName,
            'token' => encrypt($previewFileName),
        ];
    }
}
