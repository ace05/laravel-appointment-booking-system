<?php
namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Requests\AddPage;

class PageController extends AdminBaseController
{
	public function getPages(Request $request, Page $pageModel)
    {
       	$pages = $pageModel->orderBy('created_at', 'desc')
       						->paginate(20);
       
        return view('backend.pages.index', ['pages' => $pages]);
    }

    public function getPageAddForm(Request $request)
    {
        return view('backend.pages.add');
    }

    public function addPage(AddPage $request, Page $pageModel)
    {
        $page = $pageModel->create($request->except(['_token']));
        if(empty($page->id) === false){
            return redirect()->route('admin.site.pages')->with('success', __('message_page_add_success'));
        }

        return redirect()->route('admin.site.pages')->with('error', __('message_page_add_failed'));
    }

    public function getEditPage($id, Request $request, Page $pageModel)
    {
        $page = $pageModel->findOrFail($id);
        return view('backend.pages.edit', ['page' => $page]);
    }

    public function updatePage($id, Request $request, Page $pageModel)
    {
        $page = $pageModel->findOrFail($id);

        $page->title = $request->get('title');
        $page->details = $request->get('details');
        if($page->save()){
            return redirect()->route('admin.site.pages')->with('success', __('message_page_add_success'));
        }

        return redirect()->route('admin.site.pages')->with('error', __('message_page_add_failed'));
    }

    public function deletePage($id, Request $request, Page $pageModel)
    {
        $page = $pageModel->findOrFail($id);
        if($page->delete()){
            return redirect()->route('admin.site.pages')->with('success', __('message_page_delete_success'));
        }

        return redirect()->route('admin.site.pages')->with('error', __('message_page_delete_failed'));
    }
}