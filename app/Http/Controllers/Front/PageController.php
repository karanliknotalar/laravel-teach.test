<?php

namespace App\Http\Controllers\Front;

use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{


    public function about(Request $request)
    {
        $about = About::all()->first();
        $services = Service::where("status", "=", 1)->get();
        return view("front.pages.about", compact("about", "services"));
    }

    public function contact(Request $request)
    {
        return view("front.pages.contact");
    }

}
