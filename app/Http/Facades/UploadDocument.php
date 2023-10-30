<?php

namespace App\Http\Facades;

use Illuminate\Support\Str;

class UploadDocument
{
    public static function getFilename($document)
    {
        $filename = $document->getClientOriginalName();
        return time() . "_" . Str::slug($filename);
    }

    public static function save($document, $documentPath, $filename)
    {
        return $document->move(public_path($documentPath), $filename);
    }
}
