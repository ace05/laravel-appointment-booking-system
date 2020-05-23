<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
   <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="{{{ route('admin.dashboard') }}}">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">{{{ __('site_dashboard') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.categories.list', 'admin.categories.add', 'admin.categories.edit', 'admin.categories.enable', 'admin.categories.disable']) === true) active @endif" href="{{{ route('admin.categories.list') }}}">
                <i class="app-menu__icon fa fa-bars"></i>
                <span class="app-menu__label">{{{ __('site_service_categories') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.subcategories.list', 'admin.subcategories.add', 'admin.subcategories.edit', 'admin.subcategories.enable', 'admin.subcategories.disable']) === true) active @endif" href="{{{ route('admin.subcategories.list') }}}">
                <i class="app-menu__icon fa fa-reorder"></i>
                <span class="app-menu__label">{{{ __('site_service_sub_categories') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.providers.list']) === true) active @endif" href="{{{ route('admin.providers.list') }}}">
                <i class="app-menu__icon fa fa-building"></i>
                <span class="app-menu__label">{{{ __('site_service_providers') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.professionals.list']) === true) active @endif" href="{{{ route('admin.professionals.list') }}}">
                <i class="app-menu__icon fa fa-male"></i>
                <span class="app-menu__label">{{{ __('site_service_professionals') }}}</span>
            </a>
        </li>
        <li class="treeview @if(in_array(Route::currentRouteName(), ['admin.users.list', 'admin.users.login.list']) === true) is-expanded @endif">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">{{{ __('site_users') }}}</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('admin.users.list') }}">
                       <i class="icon fa fa-circle-o"></i>
                       {{{ __('site_all_users') }}}
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('admin.users.login.list') }}">
                        <i class="icon fa fa-circle-o"></i>
                        {{{ __('site_user_logins') }}}
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.service.packages']) === true) active @endif" href="{{{ route('admin.service.packages') }}}">
                <i class="app-menu__icon fa fa-cubes"></i>
                <span class="app-menu__label">{{{ __('site_service_packages') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.packages.orders']) === true) active @endif" href="{{{ route('admin.packages.orders') }}}">
                <i class="app-menu__icon fa fa-shopping-cart"></i>
                <span class="app-menu__label">{{{ __('site_orders') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.withdrawal.lists']) === true) active @endif" href="{{{ route('admin.withdrawal.lists') }}}">
                <i class="app-menu__icon fa fa-money"></i>
                <span class="app-menu__label">{{{ __('site_withdrawal_requests') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.country.list']) === true) active @endif" href="{{{ route('admin.country.list') }}}">
                <i class="app-menu__icon fa fa-globe"></i>
                <span class="app-menu__label">{{{ __('site_countries') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.city.list', 'admin.city.add', 'admin.cities.edit', 'admin.cities.enable', 'admin.cities.disable']) === true) active @endif" href="{{{ route('admin.city.list') }}}">
                <i class="app-menu__icon fa fa-map-marker"></i>
                <span class="app-menu__label">{{{ __('site_cities') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.site.pages']) === true) active @endif" href="{{{ route('admin.site.pages') }}}">
                <i class="app-menu__icon fa fa-file-text-o"></i>
                <span class="app-menu__label">{{{ __('site_pages') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.email.templates', 'admin.edit.email.template']) === true) active @endif" href="{{{ route('admin.email.templates') }}}">
                <i class="app-menu__icon fa fa-envelope"></i>
                <span class="app-menu__label">{{{ __('site_email_templates') }}}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.sms.templates', 'admin.edit.sms.template']) === true) active @endif" href="{{{ route('admin.sms.templates') }}}">
                <i class="app-menu__icon fa fa-envelope-square"></i>
                <span class="app-menu__label">{{{ __('site_sms_templates') }}}</span>
            </a>
        </li>
        @if(env('APP_MODE') != 'demo')
            <li class="treeview @if(Route::currentRouteName() === 'admin.settings') is-expanded @endif">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-cog"></i>
                    <span class="app-menu__label">{{{ __('site_settings') }}}</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if(empty($settingCategories) === false)
                       @foreach($settingCategories as $key => $settingCategory)
                          <li>
                               <a class="treeview-item" href="{{{ route('admin.settings', ['slug' => $key ]) }}}">
                                   <i class="icon fa fa-circle-o"></i>
                                   {{{ __('site_'.$key) }}}
                               </a>
                          </li>
                       @endforeach
                   @endif
                </ul>
            </li>
        @endif
        <li>
            <a class="app-menu__item @if(in_array(Route::currentRouteName(), ['admin.translation.languages', 'admin.translation.add', 'admin.translation.edit']) === true) active @endif" href="{{{ route('admin.translation.languages') }}}">
                <i class="app-menu__icon fa fa-clone"></i>
                <span class="app-menu__label">{{{ __('site_translation') }}}</span>
            </a>
        </li>   
   </ul>
</aside>