<?php

namespace App\Helper;

use File;
use Illuminate\Support\Str;

class Helper
{
    public static function fileDelete($fileFullPath): void
    {
        if (!empty($fileFullPath) && File::isFile($fileFullPath))
            File::delete($fileFullPath);
    }

    public static function fileSave($file, $fileFullPath): void
    {
        if (!empty($fileFullPath)) {

            $dirName = File::dirname($fileFullPath);

            if (!File::exists($dirName)) File::makeDirectory($dirName);

            $file->move($dirName, File::basename($fileFullPath));
        }
    }

    public static function getFileFullPath($dirname, $name, $file): string
    {
        return $dirname . Str::slug($name) . "_" . time() . "." . $file->extension();
    }

    public static function getFileName($name, $file, $path = "images/"): ?string
    {
        return isset($file) ? Helper::getFileFullPath($path, $name, $file) : null;
    }
}
