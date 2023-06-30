<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Slider;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $sliders = Slider::where("status", "=", 1)->orderBy("created_at", "desc")->get();

        return view("front.pages.index", compact("sliders",));
    }
}
