<?php
namespace App\Http\Controllers\Backend;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\EmailTemplateUpdate;

class EmailTemplateController extends AdminBaseController
{
	public function getTemplates(Request $request, EmailTemplate $templateModel)
	{	
       $templates = $templateModel->paginate(20);
       
       return view('backend.templates.index', ['templates' => $templates]);
    }

    public function getTemplate($slug, EmailTemplate $templateModel)
    {
    	$template = $templateModel->where('slug', '=', $slug)
    						->firstOrFail();

    	return view('backend.templates.edit', ['template' => $template]);
    }

    public function updateTemplate(
    	$slug, EmailTemplateUpdate $request, EmailTemplate $templateModel
    )
    {
    	$template = $templateModel->where('slug', '=', $slug)
    						->firstOrFail();

    	$template->template = $request->get('template');
    	$template->subject = $request->get('subject');
    	if($template->save()){
    		return redirect()->back()->with('success', __('message_template_update_success'));
    	}

    	return redirect()->back()->with('error', __('message_template_update_error'));
    }
}