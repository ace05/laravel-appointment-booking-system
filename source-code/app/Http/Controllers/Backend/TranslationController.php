<?php
namespace App\Http\Controllers\Backend;

use Cache;
use Storage;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Requests\AddLanguage;

class TranslationController extends AdminBaseController
{
	public function getLanguages(Request $request, Translation $transModel)
	{	
       $translations = $transModel->paginate(20);
       
       return view('backend.translation.index', ['translations' => $translations]);
    }

    public function edit($id, Translation $transModel){

    	$translation = $transModel->findOrFail($id);
    	if(!Storage::disk('lang')->exists($translation->code.'.json')){
    		return redirect()->back()->with('error', __('message_language_doesnot_exists'));
    	}

    	$transKeys = json_decode(Storage::disk('lang')->get($translation->code.'.json'), true);
    	return view('backend.translation.edit', [
    		'translation' => $translation,
    		'transKeys' => $transKeys
    	]);
    }

    public function update($id, Request $request, Translation $transModel)
    {
    	$data = $request->except(['_token']);
    	$translation = $transModel->findOrFail($id);
    	$fileName = $translation->code.'.json';
    	if(!Storage::disk('lang')->exists($fileName)){
    		return redirect()->route('admin.translation.languages')->with('error', __('message_language_doesnot_exists'));
    	}

    	if(Storage::disk('lang')->put($fileName, json_encode($data, JSON_PRETTY_PRINT))){
    		return redirect()->route('admin.translation.languages')->with('success', __('message_language_update_success'));
    	}

    	return redirect()->route('admin.translation.languages')->with('success', __('message_language_update_failed'));
    }

    public function delete($id, Request $request, Translation $transModel)
    {
        $translation = $transModel->findOrFail($id);
        $fileName = $translation->code.'.json';
        if(!Storage::disk('lang')->exists($fileName)){
            return redirect()->route('admin.translation.languages')->with('error', __('message_language_doesnot_exists'));
        }

        if(Storage::disk('lang')->delete($fileName)){
            $translation->delete();
            Cache::forget('languages');
            return redirect()->route('admin.translation.languages')->with('success', __('message_language_delete_success'));
        }

        return redirect()->route('admin.translation.languages')->with('success', __('message_language_delete_failed'));
    }

    public function addLanguage(Request $request)
    {
        $latest = $this->getRecentModifiedFile(storage_path('lang'));
        $fileName = basename($latest);
        $transKeys = json_decode(Storage::disk('lang')->get($fileName), true);
        return view('backend.translation.add', [
            'transKeys' => array_fill_keys(array_keys($transKeys), "")
        ]);
    }

    public function createLanguage(AddLanguage $request, Translation $transModel)
    {
        $languageCode = $request->get('language_code');
        $languageName = $request->get('language_name');
        $data = $request->except(['_token', 'language_code', 'language_name']);
        $translation = $transModel->create([
            'name' => $languageName,
            'code' => strtolower($languageCode)
        ]);
        if(empty($translation->id) === false){
            $fileName = strtolower($languageCode).'.json';
            if(Storage::disk('lang')->put($fileName, json_encode($data, JSON_PRETTY_PRINT))){
                Cache::forget('languages');
                return redirect()->route('admin.translation.languages')->with('success', __('message_language_create_success'));
            }
        }

        return redirect()->route('admin.translation.languages')->with('error', __('message_language_create_failed'));
    }

    public function enableLanguage($id, Translation $transModel)
    {
        $translation = $transModel->where('is_active', '=', false)
                                ->find($id);
        if(empty($translation->id) === true){
            return redirect()->route('admin.translation.languages')->with('error', __('message_language_already_active'));
        }

        $translation->is_active = true;
        if($translation->save()){
            Cache::forget('languages');
            return redirect()->route('admin.translation.languages')->with('success', __('message_language_activate_success'));
        }

        return redirect()->route('admin.translation.languages')->with('error', __('message_language_activate_failed'));
    }

    public function disableLanguage($id, Translation $transModel)
    {
        $translation = $transModel->where('is_active', '=', true)
                                ->find($id);
        if(empty($translation->id) === true){
            return redirect()->route('admin.translation.languages')->with('error', __('message_language_already_inactive'));
        }

        $translation->is_active = false;
        if($translation->save()){
            Cache::forget('languages');
            return redirect()->route('admin.translation.languages')->with('success', __('message_language_inactive_success'));
        }

        return redirect()->route('admin.translation.languages')->with('error', __('message_language_inactive_failed'));
    }

    protected function getRecentModifiedFile($folderPath)
    {
        $iterator = new \RecursiveDirectoryIterator($folderPath);
        $directoryIterator = new \RecursiveIteratorIterator($iterator);
        $lastModifiedFile = "";        

        foreach ($directoryIterator as $name => $object) {
            if (empty($lastModifiedFile)) {
                $lastModifiedFile = $name;
            }
            else {
                $dateModifiedCandidate = filemtime($lastModifiedFile);
                $dateModifiedCurrent = filemtime($name);
                if ($dateModifiedCandidate < $dateModifiedCurrent) {
                    $lastModifiedFile = $name;
                }
            }
        }
        if (empty($lastModifiedFile)) {
            throw new \Exception("No files in the directory");
        }

        return $lastModifiedFile;
    }
}