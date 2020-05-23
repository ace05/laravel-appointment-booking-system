<?php
namespace App\Traits;

use App\Models\Country;
use App\Models\SmsTemplate;
use Twilio\Rest\Client as TwilioClient;

trait SMSService
{	
	public function sendSMS($to, $template, $data = [])
	{
		if(!in_array(env('APP_ENV'), ['local', 'testing'])){
			$template = $this->getSmsTemplate($template);
			if(empty($template) === true){
				return false;
			}

			$from = config('settings.twilio_from');
			$sid = config('settings.twilio_account_sid');
			$token = config('settings.twilio_auth_token');
			$default = [
				'##SITENAME##' => config('settings.site_name')
			];
			$data = array_merge($data, $default);
			$smsTemplate = strtr($template->template, $data);
			$country = Country::find(config('settings.site_country'));
			$phone = '+'.$country->phone_prefix.$to;
			try{
				$client = new TwilioClient($sid, $token);
		        $message = $client->messages->create($phone,
		          	[
			            'from' => $from,
			            'body' => $smsTemplate
			        ]
		        );

		        if(empty($message->sid) === false){
		        	return true;
		        }
		    }
		   	catch(\Exception $e){
		   		\Log::info('SMS exception:'.$e->getMessage());
		   		return false;
		   	}
		}

        return true;
	}

	protected function getSmsTemplate($template)
	{
		$template = SmsTemplate::where('slug', '=', $template)
						->first();

		return empty($template->id) === false ? $template : null; 
	}
}