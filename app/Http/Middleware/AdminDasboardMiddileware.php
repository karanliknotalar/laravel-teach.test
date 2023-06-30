<?php

namespace App\Http\Middleware;

use App\Models\Slider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDasboardMiddileware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $asset = asset("admin-assets")."/";
        $sliderCount = Slider::query()->count("id");
        view()->share(compact("asset", "sliderCount"));
        return $next($request);
    }
}
