<?php

if(!function_exists('getDataFromDatabase')){
	function getDataFromDatabase($input)
	{
		if(empty($input) === true) return [];

		$tables = explode(",", $input);
		if(empty($tables[0]) === true || empty($tables[1]) === true) return [];

		$table = str_replace("table:", "", $tables[0]);
		if(empty($table) === true) return [];

		$columns = explode("|", $tables[1]);
		if(empty($columns[0]) === true || empty($columns[1]) === true) return [];

		return \DB::table($table)->pluck($columns[1], $columns[0])->toArray();
	}
}

if(function_exists('formAdminSelectOption') === false){
	function formAdminSelectOption($inputs) {
		$res = [];
		if(empty($inputs) === false){
			$datas = explode(',', $inputs);
			foreach ($datas as $key => $data) {
				$res[$data] = __('site_'.strtolower($data));
			}
		}

      return $res;
    }
}

if(function_exists('isAdmin') === false){
	function isAdmin() {
      	return \Auth::user()->user_type_id == \App\Utils\UserTypes::ADMIN;
    }
}

if(function_exists('isServiceProvider') === false){
	function isServiceProvider($user = null) {		
		if(empty($user) === false){
			return $user->user_type_id == \App\Utils\UserTypes::SERVICE_PROVIDER;
		}
      	return \Auth::user()->user_type_id == \App\Utils\UserTypes::SERVICE_PROVIDER;
    }
}

if(function_exists('isProfessional') === false){
	function isProfessional($user = null) {
		if(empty($user) === false){
			return $user->user_type_id == \App\Utils\UserTypes::PROFESSIONAL;
		}
		
      	return \Auth::user()->user_type_id == \App\Utils\UserTypes::PROFESSIONAL;
    }
}

if(function_exists('genders') === false){
	function genders() {
      	return [
      		'M' => __('site_male'),
      		'F' => __('site_female'),
      		'O' => __('site_others')
      	];
    }
}

if(function_exists('generateOtp') === false){
	function generateOtp()
	{
		$otp = rand(100000, 999999);
        if(in_array(env('APP_ENV'), ['local', 'testing'])){
            $otp = 123456;
        }

       	return $otp;
	}
}

if(function_exists('getImagePath') === false){
	function getImagePath($attachment)
	{
		if(empty($attachment->path) === false){
			return 'uploads/'.$attachment->path;
		}

		return 'default-image.png';
	}
}

if(function_exists('normalizeText') === false){
	function normalizeText($text){
	    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', nl2br($text));
	}
}

if(function_exists('getBrowser') === false){
	function getBrowser($u_agent) {
	  	$bname = 'Unknown';
	  	$platform = 'Unknown';
	  	$version= "";
	  	if (preg_match('/linux/i', $u_agent)) {
	    	$platform = 'linux';
	  	} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	    	$platform = 'mac';
	  	} elseif (preg_match('/windows|win32/i', $u_agent)) {
	    	$platform = 'windows';
	  	}
	 	
	  	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
	    	$bname = 'Internet Explorer';
	    	$ub = "MSIE";
	  	} elseif(preg_match('/Firefox/i',$u_agent)) {
	    	$bname = 'Mozilla Firefox';
	    	$ub = "Firefox";
	  	} elseif(preg_match('/Chrome/i',$u_agent)) {
	    	$bname = 'Google Chrome';
	    	$ub = "Chrome";
	  	} elseif(preg_match('/Safari/i',$u_agent)) {
	    	$bname = 'Apple Safari';
	    	$ub = "Safari";
	  	} elseif(preg_match('/Opera/i',$u_agent)) {
	    	$bname = 'Opera';
	    	$ub = "Opera";
	  	} elseif(preg_match('/Netscape/i',$u_agent)) {
	    	$bname = 'Netscape';
	    	$ub = "Netscape";
	  	}
	  	
	  	$known = array('Version', $ub, 'other');
	  	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	  	if (!preg_match_all($pattern, $u_agent, $matches)) {
	  	}
	  	$i = count($matches['browser']);
	  	if ($i != 1) {
		    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
		      $version= $matches['version'][0];
		    } else {
		      $version= $matches['version'][1];
		    }
	  	} else {
	    	$version= $matches['version'][0];
	  	}
	  	if ($version==null || $version=="") {$version="?";}
		return $bname.'-'.$version.'-'.$platform;
	}
}

