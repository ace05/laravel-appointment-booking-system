<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use File;
use Cache;
use Storage;
use Stripe\Stripe;
use Carbon\Carbon;
use Stripe\Customer;
use App\Models\City;
use PayPal\Api\Item;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use App\Models\Country;
use PayPal\Api\Transaction;
use App\Models\PaymentLog;
use App\Models\Attachment;
use PayPal\Api\RedirectUrls;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\OrderAddress;
use App\Models\ServicePackage;
use App\Http\Requests\AddPackage;
use App\Http\Requests\AddReview;
use App\Models\ServiceSubCategory;
use App\Models\ServicePackageReview;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function getPackages(Request $request, ServicePackage $packageModel)
    {
    	$packages = $packageModel->where('user_id', '=', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
    						->paginate(12);

        return view('frontend.packages.index', ['packages' => $packages]);
    }

    public function getAddForm(Request $request)
    {   
        $user = Auth::user();
        $cities = $user->cities->pluck('name', 'id')->toArray();
        $categories = $user->professions->pluck('name', 'id')->toArray();
    	return view('frontend.packages.add', [
            'cities' => $cities,
            'categories' => $categories
        ]);
    }

    public function addPackage(
    	AddPackage $request, ServicePackage $packageModel, Attachment $attachmentModel
    )
    {
    	$user = Auth::user();
    	$data = $request->except(['cover', '_token']);
    	$data['user_id'] = $user->id;
    	if(empty($data['discount']) === true){
    		unset($data['discount']);
    	}
    	
    	if($package = $packageModel->create($data)){
    		if($request->hasFile('cover')) {
                $file = $request->file('cover');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                $filePath = 'packages/'.$filename;
                if(Storage::disk('uploads')->put($filePath,  File::get($file))){
                    $attachment = $attachmentModel->create([
                		'filename' => $filename,
                        'path' => $filePath,
                        'type' => 'Package',
                        'foreign_id' => $package->id
                	]);
                }
            }

            return redirect()->route('site.packages.list')->with('success', __('message_package_created_success'));
    	}

    	return redirect()->route('site.packages.list')->with('error', __('message_package_created_failed'));
    }

    public function getPackage($slug, Request $request, ServicePackage $packageModel){
        $user = Auth::user();
        $cities = $user->cities->pluck('name', 'id')->toArray();
        $categories = $user->professions->pluck('name', 'id')->toArray();
        $package = $packageModel->where('slug', '=', $slug)
                            ->where('user_id', '=', Auth::user()->id)
                            ->firstOrFail();
        return view('frontend.packages.edit', [
            'package' => $package,
            'cities' => $cities,
            'categories' => $categories
        ]);
    }

    public function updatePackage(
        $slug, AddPackage $request, ServicePackage $packageModel, 
        Attachment $attachmentModel
    )
    {
        $user = Auth::user();
        $data = $request->all();        
        $package = $packageModel->where('slug', '=', $slug)
                        ->where('user_id', '=', Auth::user()->id)
                        ->firstOrFail();
        $package->name = $data['name'];
        $package->details = $data['details'];
        $package->inclusion = $data['inclusion'];
        $package->exclusion = $data['exclusion'];
        $package->conditions = $data['conditions'];
        $package->city_id = $data['city_id'];
        $package->service_sub_category_id = $data['service_sub_category_id'];
        $package->price = $data['price'];
        $package->is_allow_appointment = empty($data['is_allow_appointment']) === false ? true : false;
        $package->is_address_required = empty($data['is_address_required']) === false ? true : false;
        if(empty($data['discount']) === false){
            $package->discount = $data['discount'];            
        }

        if($package->save()){
            if($request->hasFile('cover')) {
                $file = $request->file('cover');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName().'.'.$extension;
                $filename = md5($filename . microtime()).'.'.$extension;
                $filePath = 'packages/'.$filename;
                if(Storage::disk('uploads')->put($filePath,  File::get($file))){
                    $attachment = $attachmentModel->where('foreign_id', '=', $package->id)->delete();

                    $attachment = $attachmentModel->create([
                        'filename' => $filename,
                        'path' => $filePath,
                        'type' => 'Package',
                        'foreign_id' => $package->id
                    ]);
                }
            }

            return redirect()->route('site.packages.list')->with('success', __('message_package_updated_success'));
        }

        return redirect()->route('site.packages.list')->with('error', __('message_package_updated_failed'));
    }

    public function changePackageStatus(
        $id, $status, Request $request, ServicePackage $packageModel
    ){
        $package = $packageModel->findOrFail($id);
        if(empty($status) === false){
            if(strtolower($status) === 'active'){
                $package->is_active = true;
            }
            else{
                $package->is_active = false;
            }
        }

        if($package->save()){
            return redirect()->route('site.packages.list')->with('success', __('message_package_status_success'));
        }

        return redirect()->route('site.packages.list')->with('error', __('message_package_status_failed'));
    }

    public function view(
        $slug, Request $request, ServicePackage $packageModel, 
        UserAddress $addressModel, ServicePackageReview $reviewModel
    )
    {
        $package = $packageModel->where('slug', '=', $slug)->firstOrFail();

        if(Auth::user()){
            if(!isAdmin() && Auth::user()->id != $package->user_id){
                if(empty($package->is_active) === true || empty($package->is_approved) === true){
                    abort(404);
                }
            }
        }
        else{
            if(empty($package->is_active) === true || empty($package->is_approved) === true){
                abort(404);
            }
        }

        $address = $addressModel->where('user_id', '=', $package->user_id)
                            ->where('city_id', '=', $package->city_id)
                            ->first();

        $reviews = $reviewModel->where('service_package_id', '=', $package->id)
                            ->paginate(20);

        return view('frontend.packages.view', [
            'package' => $package,
            'address' => $address,
            'reviews' => $reviews
        ]);
    }

    public function createOrder(
        $slug, Request $request, Order $orderModel, ServicePackage $packageModel
    )
    {
        $data = $request->all();
        $package = $packageModel->where('slug', '=', $slug)
                            ->where('is_approved', '=', true)
                            ->where('is_active', '=', true)
                            ->firstOrFail();

        if(empty($package->is_allow_appointment) === false){
            $this->validate($request, [
                'appointment_date' => 'required|date_format:d/m/Y'
            ]);
        }

        $order = $orderModel->create([
            'user_id' => Auth::user()->id,
            'service_package_id' => $package->id,
            'price' => $package->price,
            'discount' => $package->discount,
            'appointment_date' => empty($data['appointment_date']) === false ? Carbon::parse($data['appointment_date'])->format('Y-m-d') : null
        ]);
        if(empty($order->id) === false){
            return redirect()->route('site.order.process', ['orderId' => $order->id]);
        }

        return redirect()->back()->with('error', __('message_order_process_failed'));
    }

    public function getOrderProcessForm(
        $orderId, Request $request, Order $orderModel, UserAddress $addressModel, 
        City $cityModel
    )
    {
        $order = $orderModel->findOrFail($orderId);
        if(empty($order->is_paid) === false){
            return redirect()->route('site.packages.view', ['slug' => $order->package->slug])->with('error', __('message_order_process_failed'));
        }

        $cities = [];
        if(empty($order->package->is_address_required) === false){
            $cities = $cityModel->where('is_active', '=', true)
                                ->pluck('name', 'id')
                                ->toArray();
        }

        return view('frontend.packages.checkout', [
            'order' => $order,
            'is_address_required' => $order->package->is_address_required,
            'cities' => $cities
        ]);
    }


    public function processOrder($id, Request $request, Order $orderModel)
    {
        $data = $request->all();
        $order = $orderModel->find($id);
        if(empty($order->id) === true){
            abort(500);
        }

        $amount = round($order->price - $order->discount, 2);
        $transFee = round($amount*(config('settings.stripe_trans_fee_percentage')/100) + config('settings.stripe_trans_fee_flat') , 2);            
        $payAmount = round($amount + $transFee, 2)*100;
        $payment = $this->processStripePayment($order->id, $payAmount, $request);
        if(empty($payment) === false){
            $order->is_paid = true;
            $order->reference_id = $payment;
            if($order->save()){ 
                $status = true;                  
            }
        }

        if(empty($status) === true){
            return redirect(route('site.payment.failed', ['id' => $id]));
        }

        $package = $order->package;
        $commission = round($amount*config('settings.website_commission')/100, 2);
        if(empty($package->id) === false){
            $owner = $package->user;
            $owner->available_balance = $owner->available_balance + round( $amount - $commission, 2);
            $owner->total_earnings = $owner->total_earnings + round( $amount - $commission, 2);
            $owner->site_commissions = $owner->site_commissions + $commission;
            $owner->save();
        }

        return redirect()->route('site.user.orders')->with('success', __('message_order_completed'));

    }

    public function processPaypal($id, Request $request, Order $orderModel)
    {
        $data = $request->all();
        $order = $orderModel->find($id);
        if(empty($order->id) === true){
            abort(500);
        }

        try{
            $paypalContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                        config('settings.paypal_client_id'), 
                        config('settings.paypal_client_secret')
                ),
                'Request' . time()
            );

            $paypalContext->setConfig(
                [
                'mode' => strtolower(config('settings.paypal_mode'))
                ]
            );

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('site.order.paypal.success', ['orderId' => $id]));
            $redirectUrls->setCancelUrl(route('site.order.paypal.cancel', ['orderId' => $id]));

            $payer = new Payer();
            $payer->setPaymentMethod("paypal");

            $amount = round($order->price - $order->discount, 2);
            $transFee = round($amount*(config('settings.paypal_trans_fee_percentage')/100) + config('settings.paypal_trans_fee_flat') , 2); 
            $total = $amount + $transFee;

            $inputFields = new \PayPal\Api\InputFields();
            $inputFields->setNoShipping(1)
                        ->setAddressOverride(0);

            $webProfile = new \PayPal\Api\WebProfile();
            $webProfile->setName('WebProfile' . uniqid())
               ->setInputFields($inputFields)
               ->setTemporary(true);

            $webProfileId = $webProfile->create($paypalContext)->getId();

            $amount = new Amount();
            $amount->setCurrency(strtoupper($this->getCurrencyCode()));
            $amount->setTotal($total);
                                            
            $items = new ItemList();
            $items->setItems([
                [
                    'name' => $order->package->name,
                    'quantity' => 1,
                    'price' => $total,
                    'currency' => strtoupper($this->getCurrencyCode())
                ]
            ]);
                
            $transaction = new Transaction();
            $transaction->setAmount($amount);
            $transaction->setItemList($items);

            $payment = new Payment();
            $payment->setExperienceProfileId($webProfileId);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setIntent("sale");
            $payment->setPayer($payer);
            $payment->setTransactions(array($transaction));      
            $result = $payment->create($paypalContext);
            if($result->state == "created" && $result->payer->payment_method == "paypal"){
                $order->reference_id = $result->id;
                if($order->save()){
                    return redirect()->to($result->links[1]->href);
                }
            }
        }
        catch(\PayPal\Exception\PayPalConnectionException $ex) {
            \Log::info('Paypal Connection Exception : '.$ex->getData());
        } 
        catch (\Exception $ex) {
            \Log::info('Paypal Exception : '.$ex->getMessage());
        }

        return redirect(route('site.payment.failed'))->with('error', __('message_order_failed'));
    }

    public function processSuccessOrder(
        $orderId, Request $request, Order $orderModel
    )
    {
        $data = $request->all();
        $order = $orderModel->find($orderId);
        if(empty($order->id) === true){
            abort(500);
        }

        $paymentlog = PaymentLog::create([
            'order_id' => $order->id,
            'payment_method' => 'paypal',
            'response' => json_encode($data)
        ]);

        if(empty($data['token']) === false && empty($data['PayerID']) === false && empty($data['paymentId']) === false){
            try{
                $paymentId = $order->reference_id;
                $PayerID = $data['PayerID'];
                $paypalContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                            config('settings.paypal_client_id'), 
                            config('settings.paypal_client_secret')
                        ),
                    'Request' . time()
                );

                $paypalContext->setConfig(
                    [
                    'mode' => strtolower(config('settings.paypal_mode'))
                    ]
                );
                $payment = Payment::get($paymentId, $paypalContext);
                $paymentExecution = new \PayPal\Api\PaymentExecution();
                $paymentExecution->setPayerId($PayerID);  
                $payment = $payment->execute($paymentExecution, $paypalContext);                
                if(strtolower($payment->state) == "approved"){
                    $paymentlog->response = $payment->toJson();
                    $paymentlog->save();
                    $order->is_paid = true;
                    if($order->save()){
                        return redirect()->route('site.user.orders')->with('success', __('message_order_completed'));
                    }
                }
            }
            catch(\Exception $ex) {
                \Log::info('Paypal response Exception : '.$ex->getMessage());
            }
        }

        return redirect(route('site.payment.failed'))->with('error', __('message_order_failed'));
    }

    public function processCancelOrder($orderId, Request $request){
        return redirect(route('site.user.orders'))->with('error', __('message_order_cancelled'));
    }

    public function paymentFailed($id, Request $request)
    {
        return view('frontend.packages.payment_failed', ['id' => $id]);
    }

    private function processStripePayment($orderId, $amount, Request $request)
    {
        try{
            $stripe = [
              'secret_key'      => config('settings.stripe_secret_key'),
              'publishable_key' => config('settings.stripe_pub_key')
            ];
            Stripe::setApiKey($stripe['secret_key']);
            $token  = $request->get('stripeToken');
            $customer = Customer::create(array(
                'email' => Auth::user()->email,
                'source'  => $token
            ));
            $charge = \Stripe\Charge::create(array(
               'customer' => $customer->id,
               'amount'   => $amount,
               'currency' => strtolower($this->getCurrencyCode())
            ));
            $response = json_decode(json_encode($charge), true);
            $paymentlog = PaymentLog::create([
                'order_id' => $orderId,
                'payment_method' => 'stripe',
                'response' => json_encode($response)
            ]);
            if(empty($response['status']) === false && strtolower($response['status']) === 'succeeded'){
                return $response['id'];
            }

            return false;
        }
        catch(\Exception $e){
            $paymentlog = PaymentLog::create([
                'order_id' => $orderId,
                'payment_method' => 'stripe',
                'response' => $e->getMessage()
            ]);
        }

        return false;
    }

    protected function getCurrencyCode()
    {
        $code = Cache::get('currency_code');
        if(empty($code) === true){
            $code = 'usd';
        }

        return $code;
    }

    public function addCheckoutAddress(
        $id, Request $request, Order $orderModel, OrderAddress $orderAddressModel
    ){
        if(!$request->ajax()) abort(500);

        $this->validate($request, [
            'flat_no' => 'required',
            'address_line1' => 'required',
            'city_id' => 'required',
            'pincode' => 'required|numeric'
        ]);

        $data = $request->except(['_token']);
        $data['user_id'] = Auth::user()->id;
        $data['country_id'] = config('settings.site_country');
        $order = $orderModel->findOrFail($id);
        if($address = $orderAddressModel->create($data)){
            $order->order_address_id = $address->id;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => __('message_order_address_success')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('message_order_address_failed')
        ]);
    }

    public function orderStatusUpdate($type, $orderId, Request $request, Order $orderModel)
    {
        $data = [];
        switch (strtolower($type)) {
            case 'cancel':
                $data = [
                    'is_cancelled' => true,
                    'is_accepted' => false,
                    'is_completed' => false
                ];
                break;
            case 'accept':
                $data = [
                    'is_cancelled' => false,
                    'is_accepted' => true,
                    'is_completed' => false
                ];
                break;
            case 'completed':
                $data = [
                    'is_cancelled' => false,
                    'is_accepted' => false,
                    'is_completed' => true
                ];
                break;
            
            default:
                break;
        }

        if(empty($data) === false){
            $order = $orderModel->where('id', '=', $orderId)->update($data);
        }

        if(strtolower($type) === 'cancel'){
            $order = $orderModel->find($orderId);

            $amount = round($order->price - $order->discount, 2);
            $owner = $order->package->user;
            $user = $order->user;

            $owner->available_balance = $owner->available_balance - $amount;
            $owner->save();

            $user->available_balance = $user->available_balance + $amount;
            $user->save();
        }

        return redirect()->route('site.professional.orders')->with('success', __(
            'message_order_status_success'
        ));
    }

    public function searchService(Request $request, ServiceSubCategory $categoryModel)
    {
        $query = $request->get('q');
        $services = $categoryModel->whereRaw('lower(name) like (?)', ["%{$query}%"])
                                ->where('is_active', '=', true)
                                ->limit(10)
                                ->get();
        $response = [];
        foreach ($services as $key => $service) {
            $response[] = [
                'value' => $service->name,
                'url' => route('site.service.listing', ['slug' => $service->slug]),
                'image' => route('image.manipulation', ['path' =>  $service->cover, 'w' => 30, 'h' => 30, 'fit' => 'crop'])
            ];
        }

        return response()->json($response);
    }

    public function listPackages(
        $slug, Request $request, ServicePackage $packageModel, 
        ServiceSubCategory $categoryModel
    )
    {
        $category = $categoryModel->where('slug', '=', $slug)
                            ->where('is_active', '=', true)
                            ->firstOrFail();

        $city = $this->getSelectedCity();
        $packages = $packageModel->where('city_id', '=', $city)
                            ->where('service_sub_category_id', '=', $category->id)
                            ->where('is_approved', '=', true)
                            ->where('is_active', '=', true)
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);

        return view('frontend.packages.listings', [
            'packages' => $packages,
            'category' => $category
        ]);
    }

    public function getReviewForm($packageId, Request $request, ServicePackage $packageModel, ServicePackageReview $reviewModel)
    {
        if($request->ajax() === false) abort(500);

        $package = $packageModel->find($packageId);
        if(empty($package->id) === true){
            return response()->json([
                'success' => false,
                'errors' => [
                    'comments' => [__('message_service_package_not_available')]
                ]
            ], 422);
        }

        $review = $reviewModel->where('user_id', '=', Auth::user()->id)
                        ->where('service_package_id', '=', $packageId)
                        ->first();
        return view('frontend.partials.add_review', [
            'package' => $package, 'review' => $review
        ]);
    }

    public function addReview(
        $packageId, AddReview $request, ServicePackageReview $reviewModel, ServicePackage $packageModel
    )
    {
        if($request->ajax() === false) abort(500);

        $package = $packageModel->find($packageId);
        if(empty($package->id) === true){
            return response()->json([
                'success' => false,
                'errors' => [
                    'comments' => [__('message_service_package_not_available')]
                ]
            ], 422);
        }

        $review = $reviewModel->where('user_id', '=', Auth::user()->id)
                        ->where('service_package_id', '=', $packageId)
                        ->first();
        $data = $request->all();
        $isReviewed = false;
        if(empty($review->id) === true){
            $review = $reviewModel->create([
                'user_id' => Auth::user()->id,
                'service_package_id' => $packageId,
                'rating' => (int) $data['rating'],
                'comments' => $data['comments']
            ]);
        }
        else{
            $isReviewed = true;
            $review->rating = (int) $data['rating'];
            $review->comments = $data['comments'];
            $review->save();
        }
        
        if(empty($review->id) === false){
            $reviewAverage = $reviewModel->where('service_package_id', '=', $packageId)
                                ->avg('rating');
            $package->rating = $reviewAverage;
            if($package->save()){
                return response()->json([
                    'success' => true
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'comments' => [__('message_review_failed')]
            ]
        ], 422);
    }
}
