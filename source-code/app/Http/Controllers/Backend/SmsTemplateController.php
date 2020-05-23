<?php
namespace App\Http\Controllers\Backend;

use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\SmsTemplateUpdate;

class SmsTemplateController extends AdminBaseController
{
	public function getTemplates(Request $request, SmsTemplate $templateModel)
	{	
       $templates = $templateModel->paginate(20);
       
       return view('backend.sms-templates.index', ['templates' => $templates]);
    }

    public function getTemplate($slug, SmsTemplate $templateModel)
    {
    	$template = $templateModel->where('slug', '=', $slug)
    						->firstOrFail();

    	return view('backend.sms-templates.edit', ['template' => $template]);
    }

    public function updateTemplate(
    	$slug, SmsTemplateUpdate $request, SmsTemplate $templateModel
    )
    {
    	$template = $templateModel->where('slug', '=', $slug)
    						->firstOrFail();

    	$template->template = $request->get('template');
    	if($template->save()){
    		return redirect()->back()->with('success', __('message_template_update_success'));
    	}

    	return redirect()->back()->with('error', __('message_template_update_error'));
    }
}