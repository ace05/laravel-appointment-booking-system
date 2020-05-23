@extends('frontend.layouts.app')

@section('title')
   {{{  __('site_orders') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-12">               
                <div class="card mt-2">
                    <div class="card-body">
                        <h3 class="card-title p-3 border-bottom">
                            {{{  __('site_orders') }}}
                        </h3> 
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{{ __('site_order_id') }}}</th>
                                            <th scope="col">{{{ __('site_package_name') }}}</th>
                                            <th scope="col">{{{ __('site_price') }}}</th>
                                            <th scope="col">{{{ __('site_service_contact_details') }}}</th>
                                            <th scope="col">{{{ __('site_service_status') }}}</th>
                                            <th scope="col">{{{ __('site_appointment_date') }}}</th>
                                            <th scope="col">{{{ __('site_actions') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <th>{{{ $order->id }}}</th>
                                                <td>
                                                    <a href="{{{ route('site.packages.view', ['slug' => $order->package->slug]) }}}" target="_blank">
                                                        {{{ $order->package->name }}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{{ config('settings.site_currency') }}}{{{ round($order->price - $order->discount, 2) }}}
                                                </td>
                                                <td>
                                                    <dl>
                                                        <dt>
                                                            {{{ __('site_name_text') }}}:
                                                        </dt>
                                                        <dd>
                                                            @if(isProfessional($order->package->user))
                                                                {{{ $order->package->user->getName() }}}
                                                            @elseif(isServiceProvider($order->package->user))
                                                                {{{ $order->package->user->serviceProvider->name }}}
                                                            @endif
                                                        </dd>
                                                        <dt>
                                                            {{{ __('site_mobile_number') }}}:
                                                        </dt>
                                                        <dd>
                                                            {{{ $order->package->user->mobile }}}
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <td>
                                                    @if(empty($order->is_accepted) === false)
                                                        <span class="badge badge-primary">
                                                            {{{ __('site_accepted') }}}
                                                        </span>
                                                        <span class="badge badge-success">
                                                            {{{ __('site_in_progess') }}}
                                                        </span>
                                                    @elseif(empty($order->is_cancelled) === false)
                                                        <span class="badge badge-danger">
                                                            {{{ __('site_cancelled') }}}
                                                        </span>
                                                    @elseif(empty($order->is_completed) === false)
                                                        <span class="badge badge-success">
                                                            {{{ __('site_completed') }}}
                                                        </span>
                                                    @elseif(empty($order->is_accepted) === true)
                                                        <span class="badge badge-warning">
                                                            {{{ __('site_waiting_for_service_approval') }}}
                                                        </span>            
                                                    @endif
                                                </td>
                                                <td>{{{ \Carbon\Carbon::parse($order->appointment_date)->format('d/m/Y') }}}</td>
                                                <td>
                                                    <a href="{{{ route('site.package.add.review', ['packageId' => $order->package->id]) }}}" data-dismiss="modal" data-toggle="modal" data-target="#review"  class="btn btn-outline-primary review-modal review-button-{{{ $order->package->id }}}">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{{ __('site_write_review') }}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">                            
                                {{ $orders->render("pagination::bootstrap-4") }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>{{{ __('site_no_orders_found') }}}</p>
                            </div>
                        @endif              
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade dir-pop-com" id="review" data-content="{{{ __('message_review_success') }}}" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
@endsection