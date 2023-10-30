<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait NamespaceFixer
{
    protected function getBaseDirectory($className)
    {
        return File::dirname($this->basePath . '\\' . $className);
    }

    protected function getBaseFileName($className)
    {
        return class_basename(Str::ucfirst($className));
    }

    protected function getNameSpacePath($factoryName)
    {
        $chunks = explode("\\", $factoryName);
        $fileName = collect($chunks)->last();

        return Str::ucfirst(str_replace('\\' . $fileName, '', $factoryName));
    }

    protected function getNameSpace($factoryName)
    {
        return str_replace('/', '\\', $factoryName);
    }
}
