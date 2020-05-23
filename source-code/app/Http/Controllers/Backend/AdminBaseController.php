<?php

namespace App\Http\Controllers\Backend;

use View;
use App\Models\SettingCategory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(SettingCategory $settingCategoryModel)
	{
		$settingCategories = $settingCategoryModel->pluck('name', 'slug')->toArray();
		View::share('settingCategories', $settingCategories);	    
	}
}
