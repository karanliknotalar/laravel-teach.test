<?php

namespace App\Http\Controllers\Front;

use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{


    public function about(Request $request)
    {
        $about = About::all()->first();
        return view("front.pages.about", compact("about"));
    }

    public function contact(Request $request)
    {
        return view("front.pages.contact");
    }

}
