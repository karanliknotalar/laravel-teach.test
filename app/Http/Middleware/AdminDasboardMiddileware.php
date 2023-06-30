<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDasboardMiddileware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $asset = asset("admin-assets") . "/";
        $sliderCount = Slider::select("id")->count("id");
        $productCount = Product::select("id")->count("id");
        $serviceCount = Service::select("id")->count("id");
        $categoryCount = Category::select("id")->count("id");
        $contactCount = Contact::where("status", "=", 0)->select("id")->count("id");

        view()->share(compact("asset", "sliderCount", "productCount", "serviceCount", "categoryCount", "contactCount"));
        return $next($request);
    }
}
