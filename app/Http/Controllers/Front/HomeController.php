<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $sliders = Slider::where("status", "=", 1)->orderBy("created_at", "desc")->get();
        $services = Service::where("status", "=", 1)->get();

        return view("front.pages.index", compact("sliders", "services"));
    }
}
