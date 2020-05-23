<?php
namespace App\Http\Controllers\Backend;

use File;
use Cache;
use Storage;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;

class SubCategoryController extends AdminBaseController
{
	public function getCategories(Request $request, ServiceSubCategory $subCategoryModel){	
       $categories = $subCategoryModel->orderBy('created_at', 'desc')->paginate(20);
       return view('backend.sub-categories.index', ['categories' => $categories]);
    }

    public function addCategory(Request $request, ServiceCategory $categoryModel)
    {
        $categories = $categoryModel->where('is_active', '=', true)
                                    ->pluck('name', 'id')
                                    ->toArray();
        return view('backend.sub-categories.add', ['categories' => $categories]);
    }

    public function add(Request $request, ServiceSubCategory $categoryModel)
    {
        $this->validate($request, [
            'cover' => 'required|mimes:jpeg,jpg,png|max:250|dimensions:width=270,height=140',
            'name' => 'required',
            'service_category_id' => 'required|exists:service_categories,id'
        ]);


        $category = $categoryModel->create([
            'name' => $request->get('name'),
            'service_category_id' => $request->get('service_category_id')
        ]);
        if(empty($category->id) === false){
            if($request->hasFile('cover')) {
                $file = $request->file('cover');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                if(Storage::disk('uploads')->put('subcategories/'.$filename,  File::get($file))){
                    $category->cover = 'uploads/subcategories/'.$filename;
                    $category->save();
                }
            }

            return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_add_success'));
        }

        return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_add_failed'));
    }

    public function getCategory($id, ServiceSubCategory $categoryModel, ServiceCategory $serviceCategoryModel)
    {
        $category = $categoryModel->findOrFail($id);
        $categories = $serviceCategoryModel->where('is_active', '=', true)
                                    ->pluck('name', 'id')
                                    ->toArray();

        return view('backend.sub-categories.edit', [
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function updateCategory(
        $id, Request $request, ServiceSubCategory $categoryModel
    )
    {
        $this->validate($request, [
            'name' => 'required',
            'service_category_id' => 'required|exists:service_categories,id'
        ]);

        if($request->hasFile('cover')) {
            $this->validate($request, [
                'cover' => 'required|mimes:jpeg,jpg,png|max:250|dimensions:width=270,height=140'
            ]);
        }


        $category = $categoryModel->findOrFail($id);
        $category->name = $request->get('name');
        $category->service_category_id = $request->get('service_category_id');
        if($request->hasFile('cover')) {
            $file = $request->file('cover');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName().'.'.$extension;
            $filename = md5($filename . microtime()).'.'.$extension;
            if(Storage::disk('uploads')->put('subcategories/'.$filename,  File::get($file))){
                $category->cover = 'uploads/subcategories/'.$filename;
            }
        }
        if($category->save()){
            return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_update_success'));
        }

        return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_update_error'));
    }

    public function delete($id, Request $request, ServiceSubCategory $categoryModel)
    {
        $category = $categoryModel->findOrFail($id);
        if($category->delete()){
            return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_delete_success'));
        }

        return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_delete_failed'));
    }

    public function enableCategory($id, ServiceSubCategory $categoryModel)
    {
        $category = $categoryModel->where('is_active', '=', false)
                                ->find($id);
        if(empty($category->id) === true){
            return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_already_active'));
        }

        $category->is_active = true;
        if($category->save()){
            return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_activate_success'));
        }

        return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_activate_failed'));
    }

    public function disableCategory($id, ServiceSubCategory $categoryModel)
    {
        $category = $categoryModel->where('is_active', '=', true)
                                ->find($id);
        if(empty($category->id) === true){
            return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_already_inactive'));
        }

        $category->is_active = false;
        if($category->save()){
            return redirect()->route('admin.subcategories.list')->with('success', __('message_subcategory_inactive_success'));
        }

        return redirect()->route('admin.subcategories.list')->with('error', __('message_subcategory_inactive_failed'));
    }
}