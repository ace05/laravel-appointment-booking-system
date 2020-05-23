@extends('frontend.layouts.installation')
@section('title')
    Installation
@endsection

@section('content')
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="py-5 text-center">
                <h2>Installation</h2>
            </div>
            @include('frontend.partials.notifications')
            @if((empty($requirements['php_version']) === false && empty($requirements['openssl_enabled']) === false && empty($requirements['pdo_enabled']) === false && empty($requirements['mbstring_enabled']) === false && empty($requirements['tokenizer_enabled']) === false && empty($requirements['xml_enabled']) === false && empty($requirements['ctype_enabled']) === false && 
            empty($requirements['json_enabled']) === false && 
            empty($requirements['bcmath_enabled']) === false && 
            empty($requirements['curl_enabled']) === false && 
            $requirements['server'] === 'nginx') || (empty($requirements['php_version']) === false && empty($requirements['openssl_enabled']) === false && empty($requirements['pdo_enabled']) === false && empty($requirements['mbstring_enabled']) === false && empty($requirements['tokenizer_enabled']) === false && empty($requirements['xml_enabled']) === false && empty($requirements['ctype_enabled']) === false && 
            empty($requirements['json_enabled']) === false && 
            empty($requirements['bcmath_enabled']) === false &&  
            empty($requirements['curl_enabled']) === false &&empty($requirements['mod_rewrite_enabled']) === false && $requirements['server'] === 'apache'))
                {!! Form::open(['url' => route('app.install') ]) !!}                      
                        <h4>Application and Login Settings</h4>
                        <hr>
                        <p>This credential going to use for admin login.</p>
                        <div class="form-group">
                            {!! Form::label('first_name', __('site_first_name')) !!}
                            {!! Form::text('first_name', null, ['class' => $errors->has('first_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_first_name')]) !!}
                            @if ($errors->has('first_name'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @endif 
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name', __('site_last_name')) !!}
                            {!! Form::text('last_name', null, ['class' => $errors->has('last_name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_last_name')]) !!}
                            @if ($errors->has('last_name'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @endif 
                        </div>
                        <div class="form-group">
                            {!! Form::label('mobile_number', __('site_mobile_number')) !!}
                            {!! Form::text('mobile_number', null, ['class' => $errors->has('mobile_number') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_mobile_number')]) !!}
                            @if ($errors->has('mobile_number'))
                                <div class="form-control-username text-danger">
                                    {{ $errors->first('mobile_number') }}
                                </div>
                            @endif 
                            <small id="Help" class="form-text text-muted">Without country extension</small>
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', __('site_email')) !!}
                            {!! Form::text('email', null, ['class' => $errors->has('email') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_email')]) !!}
                            @if ($errors->has('email'))
                                <div class="form-control-email text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif 
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', __('site_password')) !!}
                            {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_password')]) !!}
                            @if ($errors->has('password'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif 
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', __('site_confirm_password')) !!}
                            {!! Form::password('password_confirmation', ['class' => $errors->has('password_confirmation') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg', 'placeholder' =>  __('site_confirm_password')]) !!}
                            @if ($errors->has('password_confirmation'))
                                <div class="form-control-feedback text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            @endif 
                        </div>                      
                        {!! Form::submit('Install', ['class' => 'btn btn-outline-primary btn-lg btn-block']) !!}
                {!! Form::close() !!}
            @else
                    <p>Following extensions are require to install application.</p>
                    <table class="table table-condensed">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>PHP version</td>
                            <td>
                                @if(empty($requirements['php_version']) === false)
                                    <span class="badge badge-success">Compatible</span>
                                @else
                                    <span class="badge badge-danger">PHP version: >= 7.0.0 required</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>OpenSSL PHP Extension</td>
                            <td>
                                @if(empty($requirements['openssl_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>PDO PHP Extension</td>
                            <td>
                                @if(empty($requirements['pdo_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Mbstring PHP Extension</td>
                            <td>
                                @if(empty($requirements['mbstring_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tokenizer PHP Extension</td>
                            <td>
                                @if(empty($requirements['tokenizer_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>XML PHP Extension</td>
                            <td>
                                @if(empty($requirements['xml_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Ctype PHP Extension</td>
                            <td>
                                @if(empty($requirements['ctype_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>JSON PHP Extension</td>
                            <td>
                                @if(empty($requirements['json_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Bcmath PHP Extension</td>
                            <td>
                                @if(empty($requirements['bcmath_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Curl PHP Extension</td>
                            <td>
                                @if(empty($requirements['curl_enabled']) === false)
                                    <span class="badge badge-success">Enabled</span>
                                @else
                                    <span class="badge badge-danger">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        @if(empty($requirements['server']) === false && $requirements['server'] === 'apache')
                            <tr>
                                <td>Mod Rewrite</td>
                                <td>
                                    @if(empty($requirements['mod_rewrite_enabled']) === false)
                                        <span class="badge badge-success">Enabled</span>
                                    @else
                                        <span class="badge badge-danger">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>                
                @endif
            </div>
        </div> 
    </div>
</section>
@endsection