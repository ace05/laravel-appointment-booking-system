<?php

namespace App\Http\Controllers\Frontend;

use Cookie;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request, ServiceCategory $categoryModel)
    {
    	$categories = $categoryModel->where('is_active', '=', true)
    						->limit(10)
    						->get();
        return view('frontend.home.index', ['categories' => $categories]);
    }

    public function changeCity($city, Request $request)
    {
    	Cookie::queue('city', $city, 3600);
    	return redirect()->route('site.home');
    }

    public function getPage($slug, Request $request, Page $pageModel)
    {
        $page = $pageModel->where('slug', '=', $slug)
                        ->firstOrFail();

        return view('frontend.home.page', ['page' => $page]);
    }
}
