<?php
namespace App\Traits;

use Mail;
use App\Models\EmailTemplate;

trait EmailService
{	
	public function sendEmail($to, $templateName, $data = [])
	{
		$template = $this->getTemplate($templateName);
		if(empty($template) === true){
			return true;
		}

		$default = [
			'##SITENAME##' => config('settings.site_name'),
			'##LOGO##' => url(config('settings.logo')),
			'##SITEURL##' => url('/')
		];
		$data = array_merge($data, $default);
		$emailTemplate = strtr($template->template, $data);
		$subject = strtr($template->subject, $data);

		return Mail::send([], [], function($message) use ($subject, $to, $emailTemplate) {
            $message->to($to);
            $message->subject($subject);
            $message->setBody($emailTemplate, 'text/html');
        });
	}

	protected function getTemplate($templateName)
	{
		$template = EmailTemplate::where('slug', '=', $templateName)
						->first();

		return empty($template->id) === false ? $template : null; 
	}
}