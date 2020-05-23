@extends('backend.layouts.app')

@section('title')
   {{{  __('site_withdrawal_requests') }}}
@endsection

@section('content')
<section class="py-2">
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-12">               
                <div class="card mt-2">
                    <div class="card-body">
                        <h3 class="card-title p-3 border-bottom">
                            {{{  __('site_withdrawal_requests') }}}
                        </h3> 
                        @if($withdrawals->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{{ __('site_request_id') }}}</th>
                                            <th scope="col">{{{ __('site_amount') }}}</th>
                                            <th scope="col">{{{ __('site_fee') }}}</th>
                                            <th scope="col">{{{ __('site_credited_amount') }}}</th>
                                            <th scope="col">{{{ __('site_paypal_email') }}}</th>
                                            <th scope="col">{{{ __('site_status') }}}</th>
                                            <th scope="col">{{{ __('site_date') }}}</th>

                                            <th scope="col">{{{ __('site_processed_date') }}}</th>
                                            <th scope="col">{{{ __('site_actions') }}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($withdrawals as $withdrawal)
                                            <tr>
                                                <td>{{{ $withdrawal->id }}}</td>
                                                <td>
                                                    {{{ config('settings.site_currency') }}}{{{ $withdrawal->amount }}}
                                                </td>
                                                <td>
                                                    {{{ config('settings.site_currency') }}}
                                                    @php 
                                                        $fee = round(config('site.withdraw_fee.paypal')/100*$withdrawal->amount,2);
                                                    @endphp

                                                    {{{ $fee }}}
                                                </td>
                                                <td>
                                                    {{{ config('settings.site_currency') }}}{{{ round($withdrawal->amount - $fee, 2) }}}
                                                </td>
                                                <td>
                                                    {{{ $withdrawal->paypal_email }}}
                                                </td>
                                                <td>
                                                    @if(empty($withdrawal->is_completed) == true)
                                                        <p class="badge badge-warning">  {{{ __('site_in_progess') }}}
                                                        </p>
                                                    @else
                                                        <p class="badge badge-success">
                                                            {{ __('site_completed') }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{{ $withdrawal->created_at->format('F d, Y') }}}
                                                </td>
                                                <td>
                                                    {{{ $withdrawal->updated_at->format('F d, Y') }}}
                                                </td>
                                                <td>
                                                    @if(empty($withdrawal->is_completed) == true)
                                                        <a href="{{ route('admin.withdrawal.status', ['id' => $withdrawal->id ]) }}" class="btn btn-outline-primary confirmation" data-confirm="{{ __('message_are_you_sure') }}">
                                                            {{{ __('site_mark_processed') }}}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">                            
                                {{ $withdrawals->render("pagination::bootstrap-4") }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>{{{ __('site_no_request_found') }}}</p>
                            </div>
                        @endif     
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection