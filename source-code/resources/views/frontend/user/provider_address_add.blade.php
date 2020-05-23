@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_address_add') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row justify-content-center  mt-2">
            <div class="col-md-8">               
                <div class="card card-signin mt-2">
                    <div class="card-body">
                        <h3 class="card-title text-center p-3 border-bottom">
                            {{{  __('site_address_add') }}}
                        </h3>                        
                        {!! Form::open(['url' => route('site.provider.address.add'), 'files' => true]) !!}
                            <div class="form-group">
                                {!! Form::label('flat_no', __('site_flat_no') ,['class' => 'control-label']); !!}
                                {!! Form::text('flat_no', null , ['class' => $errors->has('flat_no') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('flat_no'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('flat_no') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::label('address_line1', __('site_address_line1') ,['class' => 'control-label']); !!}
                                {!! Form::text('address_line1',  null , ['class' => $errors->has('address_line1') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('address_line1'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('address_line1') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::label('address_line2', __('site_address_line2') ,['class' => 'control-label']); !!}
                                {!! Form::text('address_line2', null, ['class' => $errors->has('address_line2') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('address_line2'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('address_line2') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::label('city_id', __('site_city') ,['class' => 'control-label']); !!}
                                {!! Form::select('city_id', $cities, null, ['class' => $errors->has('city_id') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('city_id'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('city_id') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::label('pincode', __('site_pincode') ,['class' => 'control-label']); !!}
                                {!! Form::text('pincode', null, ['class' => $errors->has('pincode') ? 'form-control form-control-lg is-invalid' : 'form-control form-control-lg']) !!}
                                @if ($errors->has('pincode'))
                                    <div class="form-control-feedback text-danger">
                                        {{ $errors->first('pincode') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group">
                                {!! Form::submit(__('site_update'), ['class' => 'btn btn-lg btn-outline-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection