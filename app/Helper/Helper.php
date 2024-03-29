<?php

namespace App\Helper;

use App\Models\Invoice;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Helper
{
    public static function fileDelete($fileFullPath, $deleteEmptyParentFolders = false): void
    {
        if (!empty($fileFullPath) && File::isFile($fileFullPath)){
            $file_info = pathinfo($fileFullPath);
            File::delete($fileFullPath);

            if ($deleteEmptyParentFolders){
                // Delete All Empty Parent Folders
                $dirname = $file_info['dirname'];
                while ($dirname !== '.' && File::exists($dirname) && File::isEmptyDirectory($dirname) && count(File::allFiles($dirname)) === 0) {
                    File::deleteDirectory($dirname);
                    $file_info = pathinfo($dirname);
                    $dirname = $file_info['dirname'];
                }
            }
        }
    }

    public static function fileSave($file, $fileFullPath): void
    {
        if (!empty($fileFullPath)) {

            $dirName = File::dirname($fileFullPath);

            if (!File::exists($dirName)) File::makeDirectory($dirName, recursive: true);

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

    public static function renameExistSlug(Model $model, $column, $value): array|string|null
    {
        $slug = Str::slug($value);

        if ($model->where($column, $slug)->exists()) {

            $result = $model->where($column, 'LIKE', '%' . $slug . '%')->latest('id')->value($column);

            if (isset($result[-1]) && is_numeric($result[-1])) {

                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return end($matches) + 1;
                }, $result);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public static function timeToSecond($expired_at): float|int
    {
        $dateNow = Carbon::parse(date('Y-m-d H:i:s'));
        $expired_at = Carbon::parse($expired_at);
        return $dateNow->diffInSeconds($expired_at, absolute: false);
    }

    public static function generateUniqOrderNo(int $len = 7): int
    {
        $min = "1";
        $max = "9";
        for ($i = 0; $i < $len - 1; $i++) {
            $min .= "0";
            $max .= "9";
        }
        $uniq_id = rand((int)$min, (int)$max);
        if (Invoice::where("order_no", $uniq_id)->exists()) {
            self::generateUniqOrderNo();
        }
        return $uniq_id;
    }

    public static function getVatIncluded(float $price, int $vat): float
    {
        return (($price * $vat) / 100) + $price;
    }

    public static function getVat(float $price, int $vat): float
    {
        return ($price * $vat) / 100;
    }

    public static function createBreadCrumb($mainUrl, $replace_str): array
    {
        $currentUrl = URL::current();
        $currentUrl = str_replace($mainUrl . "/", "", $currentUrl);
        $urlParts = explode('/', $currentUrl);

        $breadcrumbs = [];
        $breadcrumbUrl = $mainUrl;

        foreach ($urlParts as $part) {

            $breadcrumbUrl .= '/' . $part;

            if (!is_numeric($part)) {
                $breadcrumbs[] = [
                    'name' => ucwords(str_replace($replace_str, " ", $part)),
                    'url' => $breadcrumbUrl,
                ];
            }
        }
        return $breadcrumbs;
    }
}
