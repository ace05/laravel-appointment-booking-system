@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_add_service_package') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="card card-signin mt-2">
            <div class="card-body">
                <div class="title-header border-bottom p-2">
                    <h3 class="card-title">
                        {{{  __('site_add_service_package') }}}
                    </h3>                  
                </div>
                <div class="row mt-3 justify-content-center">
                    <div class="col-md-8">
                        {!! Form::open(['url' => route('site.packages.add'), 'files' => true]) !!}
                            <div class="form-group">
                                {!! Form::label('name', __('site_package_name'), ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('name'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('details', __('site_package_details') ,['class' => 'control-label']); !!}
                                {!! Form::textarea('details' , null, ['class' => $errors->has('details') ? 'form-control form-control-lg is-invalid list-rich-editor' : 'form-control form-control-lg list-rich-editor']) !!}
                                @if ($errors->has('details'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('details') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('inclusion', __('site_package_inclusion_details') ,['class' => 'control-label']); !!}
                                {!! Form::textarea('inclusion' , null, ['class' => $errors->has('inclusion') ? 'form-control form-control-lg is-invalid list-rich-editor' : 'form-control form-control-lg list-rich-editor']) !!}
                                @if ($errors->has('inclusion'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('inclusion') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('exclusion', __('site_package_exclusion_details') ,['class' => 'control-label']); !!}
                                {!! Form::textarea('exclusion' , null, ['class' => $errors->has('exclusion') ? 'form-control form-control-lg is-invalid list-rich-editor' : 'form-control form-control-lg list-rich-editor']) !!}
                                @if ($errors->has('exclusion'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('exclusion') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('conditions', __('site_package_conditions') ,['class' => 'control-label']); !!}
                                {!! Form::textarea('conditions' , null, ['class' => $errors->has('conditions') ? 'form-control form-control-lg is-invalid list-rich-editor' : 'form-control form-control-lg list-rich-editor']) !!}
                                @if ($errors->has('conditions'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('conditions') }}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {!! Form::label('price', __('site_price') ,['class' => 'control-label']); !!}
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                {{{ config('settings.site_currency') }}}
                                            </span>
                                        </div>
                                        {!! Form::text('price', null, ['class' => $errors->has('price') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    </div>
                                    @if ($errors->has('price'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    {!! Form::label('discount', __('site_discount') ,['class' => 'control-label']); !!}({{{__('site_flat_discount_price')}}})
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                {{{ config('settings.site_currency') }}}
                                            </span>
                                        </div>
                                        {!! Form::text('discount', null, ['class' => $errors->has('discount') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    </div>
                                    @if ($errors->has('discount'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('discount') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {!! Form::label('cover', __('site_package_cover_photo') ,['class' => 'control-label']); !!}(350x245)
                                    {!! Form::file('cover', ['class' => $errors->has('cover') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('cover'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('cover') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-check mt-3">
                                        {!! Form::checkbox('is_allow_appointment', true, true, ['class' => 'form-check-input']) !!}
                                        {!! Form::label('is_allow_appointment', __('site_allow_appointment') ,['class' => 'form-check-label']); !!}
                                        <p id="is_allow_appointment" class="form-text">
                                            ({{{ __('site_allow_cutomer_to_fix_appointment') }}})
                                        </p>
                                    </div>
                                    <div class="form-check mt-3">
                                        {!! Form::checkbox('is_address_required', true, true, ['class' => 'form-check-input']) !!}
                                        {!! Form::label('is_address_required', __('site_is_address_required') ,['class' => 'form-check-label']); !!}
                                        <p id="is_address_required" class="form-text">
                                            ({{{ __('site_is_address_required_help') }}})
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {!! Form::label('city_id', __('site_select_city') ,['class' => 'control-label']); !!}
                                    {!! Form::select('city_id', $cities, null, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('city_id'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('city_id') }}
                                        </div>
                                    @endif
                                </div>
                                 <div class="form-group col-md-6">
                                    {!! Form::label('service_sub_category_id', __('site_service_category') ,['class' => 'control-label']); !!}
                                    {!! Form::select('service_sub_category_id', $categories, null, ['class' => $errors->has('service_sub_category_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                    @if ($errors->has('service_sub_category_id'))
                                        <div class="form-control-feedback text-danger">
                                            {{ $errors->first('service_sub_category_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                 {!! Form::submit(__('site_add'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
