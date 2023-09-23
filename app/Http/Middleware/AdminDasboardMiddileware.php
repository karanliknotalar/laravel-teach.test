<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Service;
use App\Models\ShippingCompany;
use App\Models\Slider;
use App\Models\Vat;
use Carbon;
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
        $sliderCount = Slider::where("status", 1)->count();
        $productCount = Product::where("status", 1)->count();
        $serviceCount = Service::where("status", 1)->count();
        $categoryCount = Category::where("status", 1)->count();
        $contactCount = Contact::where("status", 0)->count();
        $orderIncompleteCount = Invoice::where("order_status", 0)->count();
        $couponCount = Coupon::where('status', 1)
            ->where('expired_at', '>', Carbon::now())
            ->count();
        $vatCount = Vat::count();
        $shippingCompanyCount = ShippingCompany::where("status", 1)->count();

        view()->share(compact("asset", "sliderCount", "productCount",
            "serviceCount", "categoryCount", "contactCount", "orderIncompleteCount",
            "couponCount", "vatCount","shippingCompanyCount"));
        return $next($request);
    }
}
