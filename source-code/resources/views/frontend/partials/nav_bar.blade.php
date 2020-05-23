<section id="app" class="app-navbar-mb">
    <nav class="navbar navbar-expand-md navbar-light fixed-top app-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                @if(config('settings.logo'))
                    <img src="{{{ url(config('settings.logo')) }}}" alt="{{{ config('settings.site_name') }}}">
                @else
                    {{{ config('settings.site_name') }}}
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-col" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="app-navbar-col">
                <ul class="navbar-nav">
                    @php $cityCount = round(count($cityLists)/2) @endphp                    
                    <li class="nav-item dropdown  @if(count($cityLists) > $cityCount) megamenu @endif">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            @if(empty($cityLists[$selected_city]) === false) 
                                {{{ $cityLists[$selected_city] }}}
                            @else
                                {{{ __('site_select_city') }}}
                            @endif
                            <span class="caret"></span>
                        </a>
                        @if(count($cityLists) > $cityCount)
                            <div class="dropdown-menu p-3">
                                @php list($cities1, $cities2) = array_chunk($cityLists, ceil(count($cityLists) / 2)); @endphp
                                <div class="row">
                                    <ul class="list-unstyled col-md-6" role="menu">
                                        @foreach($cities1 as $city)
                                            <li>
                                                <a class="nav-link" href="{{{ route('site.city.change', ['city' => array_search ($city, $cityLists)]) }}}">
                                                    <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{{ $city }}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>                                
                                    <ul class="list-unstyled col-md-6" role="menu">
                                        @foreach($cities2 as $city)
                                            <li>
                                                <a class="nav-link" href="{{{ route('site.city.change', ['city' => array_search ($city, $cityLists)]) }}}">
                                                    <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{{ $city }}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="dropdown-menu">
                                <ul class="list-unstyled">
                                    @foreach($cityLists as $city)
                                        <li>
                                            <a class="nav-link" href="#">
                                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> {{{ $city }}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>  
                        @endif
                    </li>
                </ul>
                @if(Route::currentRouteName() != 'site.home')
                    <form class="mr-auto search-form form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control border service-search"  data-url="{{{ route('site.service.search') }}}" placeholder="{{{ __('site_search_placeholder') }}}">
                        </div>
                    </form>
                @endif
                <ul class="navbar-nav  ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{{ route('site.partner.page') }}}">  {{ __('site_become_partner') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('site.login') }}">{{ __('site_login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-lg" href="{{ route('site.register') }}">
                                {{ __('site_register') }}
                            </a>
                        </li>

                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{{ route('image.manipulation', ['path' =>  getImagePath(Auth::user()->avatar), 'w' => 30, 'h' => 30, 'fit' => 'crop']) }}}" class="rounded-circle">
                                {{ Auth::user()->getName() }} 
                            </a>
                            <div class="dropdown-menu" aria-labelledby="user-dropdown">
                                <div class="dropdown-item text-center">
                                    <h5>{{{ __('site_available_balance') }}}</h5>
                                    <h5>
                                        {{{ config('settings.site_currency') }}}
                                        {{{ Auth::user()->available_balance }}}
                                    </h5>
                                </div> 
                                <div class="dropdown-divider"></div>
                                @if(isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        {{ __('site_admin_dashboard') }}
                                    </a>
                                @endif
                                @if(!isServiceProvider() && !isProfessional())
                                    <a class="dropdown-item" href="{{ route('site.user.orders') }}">
                                        {{{ __('site_orders') }}}
                                    </a>
                                @endif
                                @if(!isServiceProvider())
                                    <a class="dropdown-item" href="{{ route('site.profile') }}">
                                        {{{ __('site_edit_profile') }}}
                                    </a>
                                @endif                                
                                @if(isServiceProvider() || isProfessional())
                                    @if(!isServiceProvider())
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('site.professional.orders') }}">
                                        {{ __('site_service_bookings') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('site.profile.details') }}">
                                        {{ __('site_update_profession_city_details') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('site.packages.list') }}">
                                        {{ __('site_service_packages') }}
                                    </a>
                                    @if(isProfessional())
                                        <a class="dropdown-item" href="{{ route('site.address.update') }}">
                                            {{ __('site_update_address_details') }}
                                        </a>                                        
                                    @endif
                                    @if(isServiceProvider())
                                        <a class="dropdown-item" href="{{{ route('site.provider.profile') }}}">
                                            {{ __('site_company_profile_details') }}
                                        </a>
                                        <a class="dropdown-item" href="{{{ route('site.provider.address.list') }}}">
                                            {{ __('site_address_details') }}
                                        </a>
                                        
                                    @endif
                                @endif
                                <a class="dropdown-item" href="{{{ route('site.earning.withdrawal') }}}">
                                    {{{ __('site_withdrawals') }}}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('site.logout') }}">
                                    {{ __('site_logout') }}
                                </a>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</section>