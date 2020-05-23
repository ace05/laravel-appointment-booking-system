@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_become_partner') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="title-header text-center p-2 border-bottom">
                    <h3>
                        {{{  __('site_expand_your_services_with') }}} {{{ config('settings.site_name') }}}
                    </h3>
                    <p>{{{ __('site_join_our_community') }}}</p>                    
                </div>
                <div class="join-section my-5 p-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                            <a href="{{{ route('site.professional.register') }}}" title="{{{ __('site_register_as_professional') }}}" class="btn btn-outline-primary btn-lg btn-block">
                                <i class="fa fa-user"></i> {{{ __('site_register_as_professional') }}}
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                            <a href="{{{ route('site.service.provider.register') }}}" title="{{{ __('site_register_as_service_provider') }}}" class="btn btn-outline-primary btn-lg btn-block">
                                <i class="fa fa-wrench"></i> {{{ __('site_register_as_service_provider') }}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="benifits-section text-center">
                    <h4 class="p-2 border-bottom">{{{ __('site_why_become_partner') }}}</h4>
                    <div class="row mt-4">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">               
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-usd fa-3x" aria-hidden="true"></i>
                                    <div class="title">
                                        <h4>{{{ __('site_grow_your_business') }}}</h4>
                                    </div>
                                    <div class="text">
                                       <p>{{{ __('site_grow_your_business_slogan') }}}</p>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">               
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
                                    <div class="title">
                                        <h4>{{{ __('site_work_on_your_own_terms') }}}</h4>
                                    </div>
                                    <div class="text">
                                       <p>{{{ __('site_work_on_your_own_terms_slogan') }}}</p>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">               
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-clipboard fa-3x" aria-hidden="true"></i>
                                    <div class="title">
                                        <h4>{{{ __('site_business_tools') }}}</h4>
                                    </div>
                                    <div class="text">
                                       <p>{{{ __('site_business_tools_slogan') }}}</p>
                                    </div>                                
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
