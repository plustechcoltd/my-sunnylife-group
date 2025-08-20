<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    public static function store(string $path, $file, string $disk = 'local'): ?string
    {
        $storedPath = Storage::disk($disk)->put($path, $file);

        if (false !== $storedPath) {
            return Str::after($storedPath, 'public/');
        }

        return null;
    }

    public static function path(?string $filePath, string $disk = 'local'): string
    {
        if (!$filePath) {
            return '';
        }

        return Storage::disk($disk)->path($filePath);
    }

    public static function processAvatarUpload($request, $model, string $configPath): void
    {
        if ($request->input('remove_avatar') == '1') {
            // Xóa avatar hiện tại
            if ($model->avatar_image_path) {
                Storage::disk('local')->delete($model->avatar_image_path);
            }
            $model->avatar_image_path = null;
        } elseif ($request->hasFile('avatar')) {
            // Upload avatar mới
            $file = $request->file('avatar');
            $path = config($configPath);
            $storedFilePath = self::store($path, $file);
            
            // Xóa avatar cũ nếu tồn tại
            if ($model->avatar_image_path) {
                Storage::disk('local')->delete($model->avatar_image_path);
            }
            
            $model->avatar_image_path = $storedFilePath;
        }
    }

    public static function processFileUpload($file, string $configPath, string $disk = 'local'): ?string
    {
        if ($file) {
            $path = config($configPath);

            // store the file in public folder, so it can be accessed from the web
            return self::store($path, $file, $disk);
        }

        return null;
    }
}
