<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Global Sayfa verilerini Db sen çekiyoruz.
         */
        $categories = null;
        $site_contact_setting = null;

        if (Schema::hasTable('categories'))
            $categories = Category::where("status", "=", 1)->withCount("items")->with("sub_categories")->get();

        if (Schema::hasTable('site_settings'))
            $site_contact_setting = SiteSetting::all()->pluck("content", "name")->toArray();

        view()->share(compact("categories", "site_contact_setting"));
        /**
         *
         */


        Blade::directive("auresMethod", function ($value = null) {
            $value = str_replace('"', '', $value);
            $value = str_replace("'", '', $value);
            $value = strtoupper($value);

            $methods = ["UPDATE", "PUT", "PATCH"];

            if (!in_array($value, $methods)) {
                return "";
            }

            $element = "<input type='hidden' name='_method' value='{$value}'>";
            return $element;
        });
    }
}
