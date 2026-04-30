<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageUploadHelper
{
    private static string $liveBasePath = '/home/getdemo/public_html/SKE/';

    public static function upload($file, string $folder): string
    {
        $destination = self::$liveBasePath . $folder;

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $file->move($destination, $fileName);

        return $folder . '/' . $fileName;
    }

    public static function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = self::$liveBasePath . $path;

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}