<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use ZanySoft\Zip\Zip;

/**
 * check a file is image or not
 */
function isImage($url) {
    return in_array(strtolower(pathinfo($url, PATHINFO_EXTENSION))
            , getImageExternsions());
}

/**
 * Get array of image extensions
 * @return type
 */
function getImageExternsions() {
    return ['jpeg', 'png', 'bmp', 'gif', 'svg', 'jpg'];
}

/**
 * Get array of word documents
 * @return type
 */
function getMSExtensions() {
    return ['doc', 'docx', 'xlsx', 'pptx', 'ppt'];
}

/**
 * Get video extensions
 * @return type
 */
function getVideoExtensions() {
    return ['mp4', 'mov', 'wmv', 'flv', 'webm'];
}

/**
 * Check file is pdf or not
 * @param type $url
 * @return type
 */
function isPdf($url) {
    return strtolower(pathinfo($url, PATHINFO_EXTENSION)) == 'pdf';
}

/**
 * Check microsoft file or not
 * @param type $url
 * @return type
 */
function isMsFile($url) {
    return in_array(strtolower(pathinfo($url, PATHINFO_EXTENSION)), getMSExtensions());
}

/**
 * Check file is video or not
 * @param type $url
 * @return type
 */
function isVideo($url) {
    return in_array(strtolower(pathinfo($url, PATHINFO_EXTENSION)), getVideoExtensions());
}

/**
 * 
 * @param type $path
 * @param type $ext
 * @param type $height
 * @param type $width
 * @return type
 */
function getImagePreview($path, $width = null, $height = null) {
    if ($height && $width) {
        $img = Image::make($path)->resize($width, $height);
        return $img->response();
    } else {
        return response()->file($path);
    }
}

/**
 * Function to save file to storage
 * @param type $path
 * @param type $url
 * @param type $thumbnailUrl
 */
function saveFile($path, $url, $thumbnailUrl) {
    //move original brochure
    Storage::copy("temp/$url", "$path/original/$url");
    //move pdf preview if ms type
    if (isMsFile($url)) {
        $fileName = pathinfo($url, PATHINFO_FILENAME);
        Storage::copy("temp/preview/{$fileName}.pdf", "$path/preview/{$fileName}.pdf");
    }
    //move thumbnail preview if pdf file
    if (isPdf($url) || isMsFile($url) || isVideo($url)) {
        Storage::copy("temp/thumbnail/{$thumbnailUrl}", "$path/thumbnail/{$thumbnailUrl}");
    }
}

/**
 * Get file thumbnail preview
 * @param type $url
 * @param type $path
 * @param type $thumbnailUrl
 * @return type
 */
function fileThumbnailPreview($url, $path, $thumbnailUrl, $width = null, $height = null) {
    if (isImage($url)) {
        return getImagePreview(storage_path("$path/original/$url"), $width, $height);
    } elseif (isPdf($url) || isMsFile($url) || isVideo($url)) {
        return getImagePreview(storage_path("$path/thumbnail/$thumbnailUrl"), $width, $height);
    } else {
        return getImagePreview(public_path("images\default-file-thumbnail.png"), $width, $height);
    }
}

/**
 * Function to set logo details to laravel elequent object
 * @param type $obj
 * @param type $request
 * @param type $isNull
 */
function setImageDetailsInObject(&$obj, $request, $isNull = false) {
    $obj->image_url = $isNull ? NULL : $request->image['url'];
    $obj->image_token = $isNull ? NULL : encrypt($request->image['url']);
    $obj->image_title = $isNull ? NULL : $request->image['name'];
    $obj->image_size = $isNull ? NULL : $request->image['size'];
    $obj->image_ext = $isNull ? NULL : $request->image['ext'];
}

/**
 *  Set & get document laravel object from request
 * @param type $obj
 * @param type $requestDocument
 * @return type laravel elequent object
 */
function getDocumentObject($obj, $requestDocument) {
    $obj->title = $requestDocument['name'];
    $obj->size = $requestDocument['size'];
    $obj->url = $requestDocument['url'];
    $obj->ext = $requestDocument['ext'];
    $obj->thumbnail_url = $requestDocument['thumbnail_url'];
    $obj->token = encrypt($requestDocument['thumbnail_url']);
    $obj->created_by = 1;//getCurrentUserId();
    return $obj;
}

/**
 * Create temp file in zip folder
 * @param type $fileName :- name of zip file
 * @param type $files - files object with id and URL
 * @param type $path - storage root path where those files located
 */
function createTempZipFile($fileName, $files, $path) {
    $zip = Zip::create(storage_path("app/temp/zip/$fileName"));
    foreach ($files as $file) {
        $zip->add(storage_path($path . "/$file->id/original/$file->url"));
    }
    $zip->close();
}


/**
 * Get file preview
 * @param type $file
 * @param type $path
 * @return type - file
 */
function getFilePreview($file, $path) {
    if (isMsFile($file->url)) {
        return response()->file(storage_path($path . "/preview/" . getPreviewExt($file->url, 'pdf')));
    } elseif (isImage($file->url) || isPdf($file->url) || isVideo($file->url)) {
        return response()->file(storage_path($path . "/original/{$file->url}"));
    }
}
/**
 * Replace file extension with .pdf
 * @param type $filename
 * @param type $newExt
 * @return type string (new file name)
 */
function getPreviewExt($filename, $newExt) {
    return pathinfo($filename)['filename'] . '.' . $newExt;
}