<?php
namespace App\Http\Controllers\Backend;

use File;
use Cache;
use Storage;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;

class CategoryController extends AdminBaseController
{
	public function getCategories(Request $request, ServiceCategory $categoryModel){	
       $categories = $categoryModel->orderBy('created_at', 'desc')->paginate(20);
       return view('backend.categories.index', ['categories' => $categories]);
    }

    public function addCategory(Request $request)
    {
        return view('backend.categories.add');
    }

    public function add(Request $request, ServiceCategory $categoryModel)
    {
        $this->validate($request, [
            'cover' => 'required|mimes:jpeg,jpg,png|max:250|dimensions:width=270,height=140',
            'name' => 'required'
        ]);


        $category = $categoryModel->create([
            'name' => $request->get('name')
        ]);
        if(empty($category->id) === false){
            if($request->hasFile('cover')) {
                $file = $request->file('cover');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                if(Storage::disk('uploads')->put('categories/'.$filename,  File::get($file))){
                    $category->cover = 'uploads/categories/'.$filename;
                    $category->save();
                }
            }

            return redirect()->route('admin.categories.list')->with('success', __('message_category_add_success'));
        }

        return redirect()->route('admin.categories.list')->with('error', __('message_category_add_failed'));
    }

    public function getCategory($id, ServiceCategory $categoryModel)
    {
        $category = $categoryModel->findOrFail($id);

        return view('backend.categories.edit', [
            'category' => $category
        ]);
    }

    public function updateCategory(
        $id, Request $request, ServiceCategory $categoryModel
    )
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if($request->hasFile('cover')) {
            $this->validate($request, [
                'cover' => 'required|mimes:jpeg,jpg,png|max:250|dimensions:width=270,height=140'
            ]);
        }


        $category = $categoryModel->findOrFail($id);
        $category->name = $request->get('name');
        if($request->hasFile('cover')) {
            $file = $request->file('cover');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName().'.'.$extension;
            $filename = md5($filename . microtime()).'.'.$extension;
            if(Storage::disk('uploads')->put('categories/'.$filename,  File::get($file))){
                $category->cover = 'uploads/categories/'.$filename;
            }
        }
        if($category->save()){
            return redirect()->route('admin.categories.list')->with('success', __('message_category_update_success'));
        }

        return redirect()->route('admin.categories.list')->with('error', __('message_category_update_error'));
    }

    public function delete($id, Request $request, ServiceCategory $categoryModel)
    {
        $category = $categoryModel->findOrFail($id);
        if($category->delete()){
            return redirect()->route('admin.categories.list')->with('success', __('message_category_delete_success'));
        }

        return redirect()->route('admin.categories.list')->with('success', __('message_category_delete_failed'));
    }

    public function enableCategory($id, ServiceCategory $categoryModel)
    {
        $category = $categoryModel->where('is_active', '=', false)
                                ->find($id);
        if(empty($category->id) === true){
            return redirect()->route('admin.categories.list')->with('error', __('message_category_already_active'));
        }

        $category->is_active = true;
        if($category->save()){
            return redirect()->route('admin.categories.list')->with('success', __('message_category_activate_success'));
        }

        return redirect()->route('admin.categories.list')->with('error', __('message_category_activate_failed'));
    }

    public function disableCategory($id, ServiceCategory $categoryModel)
    {
        $category = $categoryModel->where('is_active', '=', true)
                                ->find($id);
        if(empty($category->id) === true){
            return redirect()->route('admin.categories.list')->with('error', __('message_category_already_inactive'));
        }

        $category->is_active = false;
        if($category->save()){
            return redirect()->route('admin.categories.list')->with('success', __('message_category_inactive_success'));
        }

        return redirect()->route('admin.categories.list')->with('error', __('message_category_inactive_failed'));
    }
}