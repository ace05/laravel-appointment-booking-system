<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use File;
use Storage;
use App\Models\City;
use App\Models\Order;
use App\Models\User;
use App\Models\Attachment;
use App\Models\UserProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\WithdrawalRequest;
use App\Models\ServiceSubCategory;
use App\Http\Requests\AddWithdraw;
use App\Http\Requests\ProfileUpdate;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
    	$user = Auth::user();

        return view('frontend.user.edit_profile', ['user' => $user]);
    }

    public function updateProfile(
    	ProfileUpdate $request, User $user, Attachment $attachment, UserProfile $profileModel
    )
    {
    	$user = Auth::user();
    	$user->first_name = $request->get('first_name');
    	$user->last_name = $request->get('last_name');
    	if($user->save()){
    		if($request->hasFile('avatar')){
    			$file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                $avatarPath = 'User/'.$user->id.'/'.$filename;
                if(Storage::disk('uploads')->put($avatarPath,  File::get($file))){
    				$avatar = $user->avatar;
                    if(empty($avatar) === true){
                    	$attachment = $attachment->create([
                    		'filename' => $filename,
                            'path' => $avatarPath,
                            'type' => 'User',
                            'foreign_id' => $user->id
                    	]);
                    }
                    else{
                    	$avatar->filename = $filename;
                    	$avatar->path = $avatarPath;
                    	$avatar->save();
                    }
                }
    		}

    		$profile = $user->profile;
    		if(empty($profile) === true){
    			$profile = $profileModel->create([
    				'gender' => $request->get('gender'),
    				'about' => $request->get('about')
    			]);
    		}
    		else{
    			$profile->gender = $request->get('gender');
    			$profile->about = $request->get('about');
    			$profile->save();
    		}
    	}

    	return redirect()->back()->with('success', __('message_profile_update_success'));
    }

    public function getProfileForm(
    	Request $request, City $cityModel, ServiceSubCategory $serviceCategoryModel
    )
    {
    	$user = Auth::user();
    	$professions = $user->professions;
    	$cities = $user->cities;
	    $selectedProfession = null;
	    $selectedCity = null;
    	if(isProfessional()){
	    	if(empty($professions) === false){
	    		foreach ($professions as $key => $profession) {
	    			$selectedProfession = $profession->id;
	    		}
	    	}
	    	if(empty($cities) === false){
	    		foreach ($cities as $key => $city) {
	    			$selectedCity = $city->id;
	    		}
	    	}    		
    	}
    	else{
    		if(empty($professions) === false){
	    		foreach ($professions as $key => $profession) {
	    			$selectedProfession[] = $profession->id;
	    		}
	    	}
	    	if(empty($cities) === false){
	    		foreach ($cities as $key => $city) {
	    			$selectedCity[] = $city->id;
	    		}
	    	}    
    	}

    	$cities = $cityModel->where('is_active', '=', true)
                        ->pluck('name', 'id')
                        ->toArray();
        $subCategories = $serviceCategoryModel->where('is_active', '=', true)
                            ->pluck('name', 'id')
                            ->toArray();

        return view('frontend.user.profession_city_details', [
            'cities' => $cities,
            'subCategories' => $subCategories,
            'selectedCity' => $selectedCity,
            'selectedProfession' => $selectedProfession
        ]);
    }

    public function updateProfessionDetails(Request $request)
    {
    	$this->validate($request, [
    		'city_id' => 'required',
    		'profession' => 'required'
    	]);

    	$user = Auth::user();
    	$data = $request->all();

    	if(isProfessional()){
	    	$user->professions()->detach();
	    	$user->professions()->attach([$data['profession']]);
	    	$user->cities()->detach();
	        $user->cities()->attach([$data['city_id']]);
	    }
	    else{
	    	$user->professions()->detach();
	    	$user->professions()->attach($data['profession']);
	    	$user->cities()->detach();
	        $user->cities()->attach($data['city_id']);
	    }

        return redirect()->back()->with('success', __('message_profile_update_success'));
    }

    public function getProfessionalAddress(Request $request)
    {
        $address = Auth::user()->professionalAddress;
        return view('frontend.user.professional_address_form', ['address' => $address]);
    }

    public function updateProfessionalAddress(Request $request, UserAddress $addressModel)
    {
        $this->validate($request, [
            'flat_no' => 'required',
            'address_line1' => 'required',
            'pincode' => 'required|numeric'
        ]);

        $data = $request->except(['_token']);
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['country_id'] = config('settings.site_country');
        $cities = $user->cities;
        $data['city_id'] = config('settings.default_city');
        if(empty($cities) === false){
            foreach ($cities as $key => $city) {
                $data['city_id'] = $city->id;
            }
        }
        $address = $addressModel->where('user_id', '=', $user->id)->first();
        if(empty($address->id) === true){
            if($address = $addressModel->create($data)){
                return redirect()->back()->with('success', __('message_address_update_success'));
            }
        }
        else{
            $address = $addressModel->where('id', '=', $address->id)
                                ->update($data);

            return redirect()->back()->with('success', __('message_address_update_success'));
        }

        return redirect()->back()->with('error', __('message_address_update_success'));
    }

    public function getServiceProviderProfile(Request $request)
    {
        $user = Auth::user();

        return view('frontend.user.edit_provider_profile', ['user' => $user]);
    }

    public function updateProviderDetails(
        Request $request, ServiceProvider $providerModel, Attachment $attachment
    )
    {
        $this->validate($request, [
            'name' => 'required',
            'about' => 'required',
            'avatar' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $user = Auth::user();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        if($user->save()){

            $serviceProvider = $user->serviceProvider;
            $serviceProvider->name = $request->get('name');
            $serviceProvider->about = $request->get('about');
            $serviceProvider->save();

            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                $avatarPath = 'User/'.$user->id.'/'.$filename;
                if(Storage::disk('uploads')->put($avatarPath,  File::get($file))){
                    $avatar = $user->avatar;
                    if(empty($avatar) === true){
                        $attachment = $attachment->create([
                            'filename' => $filename,
                            'path' => $avatarPath,
                            'type' => 'User',
                            'foreign_id' => $user->id
                        ]);
                    }
                    else{
                        $avatar->filename = $filename;
                        $avatar->path = $avatarPath;
                        $avatar->save();
                    }
                }
            }
        }

        return redirect()->back()->with('success', __('message_profile_update_success'));
    }

    public function getProviderAddress(Request $request, UserAddress $addressModel)
    {
        $addresses = $addressModel->where('user_id', '=', Auth::user()->id)
                            ->paginate(20);

        return view('frontend.user.provider_address', ['addresses' => $addresses]);
    }

    public function addressAddForm(Request $request)
    {
        $cities = Auth::user()->cities->pluck('name', 'id')->toArray();
        return view('frontend.user.provider_address_add', ['cities' => $cities]);
    }

    public function createAddress(Request $request, UserAddress $addressModel)
    {
        $this->validate($request, [
            'flat_no' => 'required',
            'address_line1' => 'required',
            'city_id' => 'required',
            'pincode' => 'required|numeric'
        ]);

        $address = $addressModel->where('user_id', '=', Auth::user()->id)
                            ->where('city_id', '=', $request->get('city_id'))
                            ->first();
        if(empty($address->id) === false){
            return redirect()->back()->with('error', __('message_address_exists'));
        }

        $data = $request->except(['_token']);
        $data['user_id'] = Auth::user()->id;
        $data['country_id'] = config('settings.site_country');
        if($address = $addressModel->create($data)){
            return redirect()->route('site.provider.address.list')->with('success', __('message_address_created_success'));
        }

        return redirect()->back()->with('error', __('message_address_created_failed'));
    }

    public function getAddressEditForm(
        $id, Request $request, UserAddress $addressModel
    )
    {
        $address = $addressModel->where('user_id', '=', Auth::user()->id)
                            ->findOrFail($id);
        $cities = Auth::user()->cities->pluck('name', 'id')->toArray();
        return view('frontend.user.provider_address_edit', [
            'cities' => $cities,
            'address' => $address
        ]);
    }

    public function updateProviderAddress($id, Request $request, UserAddress $addressModel){
        $this->validate($request, [
            'flat_no' => 'required',
            'address_line1' => 'required',
            'city_id' => 'required',
            'pincode' => 'required|numeric'
        ]);

        $data = $request->except(['_token']);
        $address = $addressModel->where('id', '=', $id)
                                ->update($data);

        return redirect()->route('site.provider.address.list')->with('success', __('message_address_update_success'));
    }

    public function getOrders(Request $request, Order $orderModel)
    {
        $orders = $orderModel->where('user_id', '=', Auth::user()->id)
                        ->where('is_paid', '=', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('frontend.user.orders', ['orders' => $orders]);
    }

    public function getProfessionalOrders(Request $request, Order $orderModel)
    {
        $orders = $orderModel->join('service_packages', 'service_packages.id', '=', 'orders.service_package_id')
                        ->where('service_packages.user_id', '=', Auth::user()->id)
                        ->where('orders.is_paid', '=', true)
                        ->orderBy('orders.created_at', 'desc')
                        ->select(
                            'orders.is_paid','orders.id',
                            'orders.created_at', 'orders.user_id',
                            'orders.price', 'orders.discount', 'orders.appointment_date',
                            'orders.reference_id', 'orders.is_paid', 'orders.is_cancelled',
                            'orders.is_accepted', 'orders.is_completed', 'orders.service_package_id', 'orders.reference_id'
                        )
                        ->paginate(10);
        return view('frontend.user.service_bookings', ['orders' => $orders]);
    }

    public function getWithdrawal(Request $request, WithdrawalRequest $withdrawModel)
    {
        $withdrawals = $withdrawModel->where('user_id', '=', Auth::user()->id)
                                ->orderBy('created_at', '=', 'desc')
                                ->paginate(10);
        return view('frontend.user.withdrawal', [
            'withdrawals' => $withdrawals
        ]);
    }

    public function postWithdrawal(AddWithdraw $request, WithdrawalRequest $withdrawModel)
    {
        $user = Auth::user();
        if(empty($user->available_balance) === true || $user->available_balance == '0.00'){
            return redirect()->back()->with('error', __('message_insufficent_balance'));
        }

        $amount = $request->get('amount');
        if(empty($user->available_balance) === false && $user->available_balance <  $amount){
            return redirect()->back()->with('error', __('message_insufficent_balance'));
        }

        $data = [
            'user_id' => $user->id,
            'amount' => $amount
        ];

        $data['paypal_email'] = $request->get('paypal_email');
        $withdrawal = $withdrawModel->create($data);
        if(empty($withdrawal->id) === false){
            $user->available_balance = $user->available_balance - $amount;
            if($user->save()){
                return redirect()->back()->with('success',  __('message_withdrawal_request_success'));
            }
        }

        return redirect()->back()->with('error',  __('message_insufficent_balance'));
    }
}
