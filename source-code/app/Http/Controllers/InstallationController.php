<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\UserLogin;
use App\Utils\UserTypes;
use Illuminate\Http\Request;
use App\Http\Requests\Installation;
use Illuminate\Support\Facades\Hash;

class InstallationController extends Controller
{
    public function getInstallation(Request $request, User $userModel)
    {

        $user = $userModel->first();
        if(empty($user->id) === false){
            return redirect(route('admin.login'))->with('error', 'Already installation has been completed. Please login to use admin panel.');
        }

        $laravelRequirements = [
            'php' => '7.1.3',
            'openssl' => true, 
            'pdo' => true, 
            'mbstring' => true, 
            'tokenizer' => true, 
            'xml' => true, 
            'ctype' => true,
            'json' => true,
            'bcmath' => true
        ];
        $requirements = [];
        $requirements['php_version'] = (version_compare(PHP_VERSION, $laravelRequirements['php'] ,">=") >= 0);
        $requirements['openssl_enabled'] = extension_loaded("openssl");
        $requirements['pdo_enabled'] = defined('PDO::ATTR_DRIVER_NAME');
        $requirements['mbstring_enabled'] = extension_loaded("mbstring");
        $requirements['tokenizer_enabled'] = extension_loaded("tokenizer");
        $requirements['xml_enabled'] = extension_loaded("xml");
        $requirements['ctype_enabled'] = extension_loaded("ctype");
        $requirements['json_enabled'] = extension_loaded("json");
        $requirements['bcmath_enabled'] = extension_loaded("bcmath");

        $requirements['server'] = 'apache';
        if(empty($_SERVER['SERVER_SOFTWARE']) === false){
            $requirements['server'] = explode('/', $_SERVER['SERVER_SOFTWARE'])[0];
        }

        $requirements['mod_rewrite_enabled'] = null;
        if (function_exists('apache_get_modules')){
            $requirements['mod_rewrite_enabled'] = in_array('mod_rewrite',apache_get_modules());
        }

        $requirements['curl_enabled'] = extension_loaded('curl');

        $step = $request->get('step');
        return view('installation.create', [
            'requirements' => $requirements, 'step' => $step
        ]);
    }

    public function updateDetails(Installation $request,  User $userModel, UserLogin $loginModel)
    {
        $data = $request->all();
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile_number'],
            'user_type_id' => UserTypes::ADMIN,
            'password' => Hash::make($data['password']),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip()
        ];

        $user = $userModel->create($userData);
        if(empty($user->id) === false){
            return redirect()->route('admin.login')->with('success', 'Login with admin credential.');
        }

        return redirect()->back()->with('error', 'Unable to create login. Please try later.');
    }
}