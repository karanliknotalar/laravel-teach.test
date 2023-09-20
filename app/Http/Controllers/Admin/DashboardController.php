<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $subWeek = Carbon::now()->subWeek();
        $current = Carbon::now();

        $startOfLasMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLasMonth = Carbon::now()->subMonth()->endOfMonth();

        $customerCount = User::where("is_admin", 0)->count("id");
        $orderCount = Order::sum("quantity");
        $revenue = Invoice::select(
            [
                DB::raw("SUM(amount_paid) as total_revenue"),
                DB::raw("SUM(CASE WHEN created_at >= '{$subWeek->startOfWeek()}' AND created_at <= '{$subWeek->endOfWeek()}' THEN amount_paid ELSE 0 END) as last_week_revenue"),
                DB::raw("SUM(CASE WHEN created_at >= '{$current->startOfWeek()}' AND created_at <= '{$current->endOfWeek()}' THEN amount_paid ELSE 0 END) as current_week_revenue"),
                DB::raw("SUM(CASE WHEN DATE(created_at) = CURDATE() THEN amount_paid ELSE 0 END) as today_revenue")
            ]
        )->first();

        $topProducts = Order::select(
            DB::raw('product_id, COUNT(*) as order_count,
                SUM(price * (1 + VAT / 100) * quantity) as total_amount,
                SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('order_count')
            ->limit(5)
            ->with(["product:id,name,created_at", "productQuantity:product_id,price"])
            ->get();

        $chartData = $this->getChartStats();

        $rate = [
          "customer" => $this->getCustomerChangeRate(),
          "order" => $this->getOrderChangeRate(),
          "revenue" => $this->getRevenueChangeRate(),
        ];

        return view("admin.pages.index", compact("customerCount", "orderCount", "revenue", "topProducts", "chartData", "rate",));
    }

    private function formatNumber($number)
    {
        return number_format($number / 1000, 1);
    }

    private function getChartStats()
    {
        // use this code if ajax request for chart data
//        $data = [
//            [
//                "name" => "Bu Hafta",
//                "data" => array_values(array_map(function ($val) {
//                    return $this->formatNumber($val);
//                }, $subWeekData)),
//            ],
//            [
//                "name" => "Geçen Hafta",
//                "data" => array_values(array_map(function ($val) {
//                    return $this->formatNumber($val);
//                }, $currentWeekData)),
//            ],
//        ];
//
//        if ($request->ajax()) {
//            return response(["data" => $data]);
//        }
        // use this code if ajax request for chart data end

        $subWeekData = Invoice::select(
            [
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 2 THEN amount_paid ELSE 0 END) as monday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 3 THEN amount_paid ELSE 0 END) as tuesday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 4 THEN amount_paid ELSE 0 END) as wednesday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 5 THEN amount_paid ELSE 0 END) as thursday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 6 THEN amount_paid ELSE 0 END) as friday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 7 THEN amount_paid ELSE 0 END) as saturday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 1 THEN amount_paid ELSE 0 END) as sunday"),
            ]
        )->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->first()->toArray();

        $currentWeekData = Invoice::select(
            [
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 2 THEN amount_paid ELSE 0 END) as monday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 3 THEN amount_paid ELSE 0 END) as tuesday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 4 THEN amount_paid ELSE 0 END) as wednesday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 5 THEN amount_paid ELSE 0 END) as thursday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 6 THEN amount_paid ELSE 0 END) as friday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 7 THEN amount_paid ELSE 0 END) as saturday"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(created_at) = 1 THEN amount_paid ELSE 0 END) as sunday"),
            ]
        )->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->first()->toArray();

        $chartData = [
            "subWeek" => implode(",", array_map(function ($val) {
                return $this->formatNumber($val);
            }, $subWeekData)),
            "currentWeek" => implode(",", array_map(function ($val) {
                return $this->formatNumber($val);
            }, $currentWeekData))
        ];

        return $chartData;
    }

    private function calculatePercentageChange($last, $current){

        if ($last != 0) {
            $percentageChange = (($current - $last) / $last) * 100;
        } else {
            $percentageChange = (($current - 0) / 1) * 100;
        }
        return $percentageChange;
    }


    private function getCustomerChangeRate()
    {
        $last = User::where("is_admin", 0)
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->count();
        $current = User::where("is_admin", 0)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        return $this->calculatePercentageChange($last, $current);
    }

    private function getOrderChangeRate(){
        $last = Order::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum("quantity");
        $current = Order::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum("quantity");

        return $this->calculatePercentageChange($last, $current);
    }

    private function getRevenueChangeRate(){
        $last = Invoice::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum("amount_paid");
        $current = Invoice::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum("amount_paid");

        return $this->calculatePercentageChange($last, $current);
    }
}
