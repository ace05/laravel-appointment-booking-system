<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/install', 'InstallationController@getInstallation')->name('app.install');
Route::post('/install', 'InstallationController@updateDetails');

//Social Login
Route::group(['middleware' => ['web', 'site.configuration']], function () {
	Route::get('/img/{path}', 'ImageController@show')->where('path', '.*')->name('image.manipulation');
	Route::namespace('Frontend')->group(function(){
		Route::get('/connect/{type}', 'SocialController@connect')->name('site.social.login');
		Route::get('/connect/{type}/callback', 'SocialController@socialCallback')->name('site.social.callback');
	});
});
Route::group(['middleware' => ['web', 'site.configuration', 'site.city', 'language']], function () {	
	Route::get('404','ErrorHandlerController@errorCode404')->name('site.error.404');
	Route::get('500', 'ErrorHandlerController@errorCode500')->name('site.error.500');
	Route::namespace('Frontend')->group(function () {
		Route::get('/', 'HomeController@index')->name('site.home');
		Route::get('/register', 'AuthController@showRegisterForm')->name('site.register');
        Route::post('/register', 'AuthController@register');
		Route::get('/login', 'AuthController@showLoginForm')->name('site.login');
	    Route::post('/login', 'AuthController@login');

	    Route::get('/email/activation/resend', 'AuthController@resendEmailActivation')->name('site.email.activation.resend');
	    Route::post('/email/activation/resend', 'AuthController@resendActivationEmail');
	    Route::get('/email/activation/{code}', 'AuthController@activateEmail')->name('site.email.activation');

	    Route::get('/otp/resend/{code}', 'AuthController@resendOtpForm')->name('site.otp.resend');
	    Route::post('/otp/resend/{code}', 'AuthController@resendOtp');
	    Route::get('/otp/verification/{code}', 'AuthController@verifyOtpForm')->name('site.otp.verify');
	    Route::post('/otp/verification/{code}', 'AuthController@verifyOtp');
	    Route::get('/forgot/password', 'PasswordController@showLinkRequestForm')->name('site.forgot.password');
    	Route::post('/password/email', 'PasswordController@sendResetLinkEmail')->name('password.email');
    	Route::get('password/reset/{token}', 'PasswordController@showResetForm')->name('password.reset');
    	Route::post('password/reset', 'PasswordController@reset')->name('password.update');  
    	Route::get('/become/partner', 'AuthController@getPartnerPage')->name('site.partner.page');
    	Route::get('/professional/register', 'AuthController@professionalSignup')->name('site.professional.register'); 
    	Route::post('/professional/register', 'AuthController@registerProfessional');   
    	Route::get('/service/provider/register', 'AuthController@registerServiceProviderForm')->name('site.service.provider.register');
    	Route::post('/service/provider/register', 'AuthController@registerServiceProvider');
    	Route::get('/update/mobile/number/{code}', 'SocialController@addMobileNumberForm')->name('site.add.mobile.number');
    	Route::post('/update/mobile/number/{code}', 'SocialController@updateMobileNumber');
    	
	    Route::group(['middleware' => 'auth'], function(){
	    	Route::get('/logout', 'AuthController@logout')->name('site.logout');
	    	Route::get('/update/profile', 'UserController@getUserProfile')->name('site.profile');
	    	Route::post('/update/profile', 'UserController@updateProfile');
	    	Route::get('/update/profile/details', 'UserController@getProfileForm')->name('site.profile.details');
	    	
	    	Route::get('/profile/earning/withdrawal', 'UserController@getWithdrawal')->name('site.earning.withdrawal');
			Route::post('/profile/earning/withdrawal', 'UserController@postWithdrawal');

	    	Route::get('/professional/update/address', 'UserController@getProfessionalAddress')->name('site.address.update');
	    	Route::post('/professional/update/address', 'UserController@updateProfessionalAddress');
	    	Route::post('/update/profile/details', 'UserController@updateProfessionDetails');
	    	Route::get('/service/packages', 'ServiceController@getPackages')->name('site.packages.list');
	    	Route::get('/service/package/add', 'ServiceController@getAddForm')->name('site.packages.add');
	    	Route::post('/service/package/add', 'ServiceController@addPackage');
	    	Route::get('/service/package/edit/{slug}', 'ServiceController@getPackage')->name('site.packages.edit');
	    	Route::post('/service/package/edit/{slug}', 'ServiceController@updatePackage');
	    	Route::get('/service/package/status/{id}/{status}', 'ServiceController@changePackageStatus')->name('site.packages.status');
	    	
	    	Route::get('/service/provider/profile', 'UserController@getServiceProviderProfile')->name('site.provider.profile');
	    	Route::post('/service/provider/profile', 'UserController@updateProviderDetails');
	    	Route::get('/service/provider/address', 'UserController@getProviderAddress')->name('site.provider.address.list');
	    	Route::get('/service/provider/address/add', 'UserController@addressAddForm')->name('site.provider.address.add');
	    	Route::post('/service/provider/address/add', 'UserController@createAddress');
	    	Route::get('/service/provider/address/edit/{id}', 'UserController@getAddressEditForm')->name('site.provider.address.edit');
	    	Route::post('/service/provider/address/edit/{id}', 'UserController@updateProviderAddress');
	    	Route::post('/service/package/order/{slug}', 'ServiceController@createOrder')->name('site.create.order');
	    	Route::get('/service/order/checkout/{orderId}', 'ServiceController@getOrderProcessForm')->name('site.order.process');
			Route::post('/service/checkout/add/address/{id}', 'ServiceController@addCheckoutAddress')->name('site.order.address');
	    	Route::post('/service/order/checkout/{orderId}', 'ServiceController@processOrder');

	    	Route::get('/service/order/checkout/paypal/{id}', 'ServiceController@processPaypal')->name('site.paypal.order.process');
	    	Route::get('/service/order/paypal/{orderId}/success', 'ServiceController@processSuccessOrder')->name('site.order.paypal.success');
			Route::get('/service/order/paypal/{orderId}/cancel', 'ServiceController@processCancelOrder')->name('site.order.paypal.cancel');
	    	Route::get('/service/order/payment/failed/{id}', 'ServiceController@paymentFailed')->name('site.payment.failed');
	    	Route::get('/profile/orders', 'UserController@getOrders')->name('site.user.orders');
	    	Route::get('/professional/orders', 'UserController@getProfessionalOrders')->name('site.professional.orders');
	    	Route::get('/professional/order/status/{type}/{orderId}', 'ServiceController@orderStatusUpdate')->name('site.orders.status');
	    	Route::get('/package/review/{packageId}', 'ServiceController@getReviewForm')->name('site.package.add.review');
			Route::post('/package/review/{projectId}', 'ServiceController@addReview');
	    });

	    Route::get('/change/city/{city}', 'HomeController@changeCity')->name('site.city.change');
	    Route::get('/service/package/{slug}', 'ServiceController@view')->name('site.packages.view');
	    Route::get('/service/search/categories', 'ServiceController@searchService')->name('site.service.search');
	    Route::get('/service/search/{slug}', 'ServiceController@listPackages')->name('site.service.listing');
	    Route::get('/page/{slug}', 'HomeController@getPage')->name('site.page.details');
	});
});

Route::group(['middleware' => ['web', 'site.configuration', 'language']], function () {
	//Admin Routes	
	Route::group(['namespace' => 'Backend', 'prefix' => 'admin'],function () {
		Route::get('/login', 'AuthController@getLoginForm')->name('admin.login');
		Route::post('/login', 'AuthController@login');
		Route::group(['middleware' => ['auth.admin', 'auth.adminCheck']], function() {
			Route::get('/logout', 'AuthController@logout')->name('admin.logout');
			Route::get('/dashboard', 'DashboardController@getDashboard')->name('admin.dashboard');

			//Settings
			Route::get('/settings/{slug}', 'SettingsController@getSettings')->name('admin.settings');
			Route::post('/settings/{slug}', 'SettingsController@updateSettings');

			//Service Providers
			Route::get('/service/providers', 'UserController@getAllProviders')->name('admin.providers.list');
			Route::get('/service/professionals', 'UserController@getAllProfessinals')->name('admin.professionals.list');
			Route::get('/user/lists', 'UserController@getAllUsers')->name('admin.users.list');			
			Route::get('/user/login/lists', 'UserController@getUserLogins')->name('admin.users.login.list');			
			Route::get('/service/providers/status/{id}/{type}', 'UserController@statusUpdate')->name('admin.providers.status');

			//Service Packages
			Route::get('/service/packages', 'ServiceController@getPackages')->name('admin.service.packages');
			Route::get('/service/package/status/{id}/{type}', 'ServiceController@statusUpdate')->name('admin.packages.status');

			//Service Orders
			Route::get('/service/orders', 'ServiceController@getOrders')->name('admin.packages.orders');

			//Withdrawal Requests
			Route::get('/withdrawal/requests', 'UserController@getWithdrawalRequests')->name('admin.withdrawal.lists');
			Route::get('/withdrawal/request/processed/{id}', 'UserController@markProcessedWithdrawal')->name('admin.withdrawal.status');

			//Translation
			Route::get('/translations', 'TranslationController@getLanguages')->name('admin.translation.languages');
			Route::get('/translation/add', 'TranslationController@addLanguage')->name('admin.translation.add');
			Route::post('/translation/add', 'TranslationController@createLanguage');
			Route::get('/translation/edit/{id}', 'TranslationController@edit')->name('admin.translation.edit');
			Route::get('/translation/enable/{id}', 'TranslationController@enableLanguage')->name('admin.translation.enable');
			Route::get('/translation/disable/{id}', 'TranslationController@disableLanguage')->name('admin.translation.disable');
			Route::post('/translation/edit/{id}', 'TranslationController@update');
			Route::get('/translation/delete/{id}', 'TranslationController@delete')->name('admin.translation.delete');

			//Countries
			Route::get('/countries', 'CountryController@getCountries')->name('admin.country.list');
			Route::get('/countries/edit/{id}', 'CountryController@getCountry')->name('admin.countries.edit');
			Route::post('/countries/edit/{id}', 'CountryController@updateCountry');

			//Pages
			Route::get('/site/pages', 'PageController@getPages')->name('admin.site.pages');
			Route::get('/site/pages/add', 'PageController@getPageAddForm')->name('admin.page.add');
			Route::post('/site/pages/add', 'PageController@addPage');
			Route::get('/site/page/{id}', 'PageController@getEditPage')->name('admin.page.edit');
			Route::post('/site/page/{id}', 'PageController@updatePage');
			Route::get('/site/page/delete/{id}', 'PageController@deletePage')->name('admin.page.delete');

			//Cities
			Route::get('/cities', 'CityController@getCities')->name('admin.city.list');
			Route::get('/city/add', 'CityController@addCity')->name('admin.city.add');
			Route::post('/city/add', 'CityController@add');
			Route::get('/cities/edit/{id}', 'CityController@getCity')->name('admin.cities.edit');
			Route::post('/cities/edit/{id}', 'CityController@updateCity');
			Route::get('/cities/enable/{id}', 'CityController@enableCity')->name('admin.cities.enable');
			Route::get('/cities/disable/{id}', 'CityController@disableCity')->name('admin.cities.disable');
			Route::get('/cities/delete/{id}', 'CityController@delete')->name('admin.cities.delete');

			//Service Categories
			Route::get('/categories', 'CategoryController@getCategories')->name('admin.categories.list');
			Route::get('/categories/add', 'CategoryController@addCategory')->name('admin.categories.add');
			Route::post('/categories/add', 'CategoryController@add');
			Route::get('/categories/edit/{id}', 'CategoryController@getCategory')->name('admin.categories.edit');
			Route::post('/categories/edit/{id}', 'CategoryController@updateCategory');
			Route::get('/categories/enable/{id}', 'CategoryController@enableCategory')->name('admin.categories.enable');
			Route::get('/categories/disable/{id}', 'CategoryController@disableCategory')->name('admin.categories.disable');
			Route::get('/categories/delete/{id}', 'CategoryController@delete')->name('admin.categories.delete');

			//Service Sub Categories
			Route::get('/subcategories', 'SubCategoryController@getCategories')->name('admin.subcategories.list');
			Route::get('/subcategories/add', 'SubCategoryController@addCategory')->name('admin.subcategories.add');
			Route::post('/subcategories/add', 'SubCategoryController@add');
			Route::get('/subcategories/edit/{id}', 'SubCategoryController@getCategory')->name('admin.subcategories.edit');
			Route::post('/subcategories/edit/{id}', 'SubCategoryController@updateCategory');
			Route::get('/subcategories/enable/{id}', 'SubCategoryController@enableCategory')->name('admin.subcategories.enable');
			Route::get('/subcategories/disable/{id}', 'SubCategoryController@disableCategory')->name('admin.subcategories.disable');
			Route::get('/subcategories/delete/{id}', 'SubCategoryController@delete')->name('admin.subcategories.delete');

			//Email Templates
			Route::get('/email/templates', 'EmailTemplateController@getTemplates')->name('admin.email.templates');
			Route::get('/email/template/{slug}', 'EmailTemplateController@getTemplate')->name('admin.edit.email.template');
			Route::post('/email/template/{slug}', 'EmailTemplateController@updateTemplate');

			//SMS Templates
			Route::get('/sms/templates', 'SmsTemplateController@getTemplates')->name('admin.sms.templates');
			Route::get('/sms/template/{slug}', 'SmsTemplateController@getTemplate')->name('admin.edit.sms.template');
			Route::post('/sms/template/{slug}', 'SmsTemplateController@updateTemplate');
		});
	});
});
