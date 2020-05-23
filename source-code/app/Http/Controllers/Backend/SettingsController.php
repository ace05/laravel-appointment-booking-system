<?php
namespace App\Http\Controllers\Backend;

use File;
use Cache;
use Storage;
use App\Models\Country;
use App\Models\Setting;
use App\Models\SettingCategory;
use Illuminate\Http\Request;

class SettingsController extends AdminBaseController
{
	public function getSettings(
    	$slug, Request $request, SettingCategory $settingCategory
    ){	
       $category = $settingCategory->where('slug', '=', $slug)
                    	->firstOrFail();
       return view('backend.settings.settings', ['settingCategory' => $category]);
    }

    public function updateSettings($slug, Request $request, Setting $settingsModel)
    {
    	$settings = $request->except(['_token']);
    	if(empty($settings) === false){
            foreach ($settings as $key => $setting) {
            	if($request->hasFile($key)) {
            		$file = $request->file($key);
            		$extension = $file->getClientOriginalExtension();
            		$filename = $file->getClientOriginalName().'.'.$extension;
    				if(Storage::disk('uploads')->put($filename,  File::get($file))){
    					$update = $settingsModel->where('trans_key', '=', $key)
                                ->update(['value' => 'uploads/'.$filename]);
    				}
            	}
            	else{
                    if($key == 'site_currency'){
                        $country = Country::find($setting);
                        $setting = $country->symbol;
                        Cache::forget('currency_code');
                        Cache::forever('currency_code', $country->currency_code);
                    }

                	$update = $settingsModel->where('trans_key', '=', $key)
                                ->update(['value' => $setting]);
            	}
            }
        }

        Cache::forget('settings');
		return redirect()->back()->with('success', __('message_setting_updated_successfully'));
    }
}