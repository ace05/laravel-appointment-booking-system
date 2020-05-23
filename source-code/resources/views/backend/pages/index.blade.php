@extends('backend.layouts.app')
@section('title')
   {{{  __('site_pages') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_pages') }}}
    </h1>
    <a href="{{{ route('admin.page.add') }}}" class="btn btn-lg btn-primary">
        <i class="fa fa-plus"></i>{{{ __('site_add') }}}
    </a>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($pages->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_title') }}}</th>
                          <th>{{{ __('site_slug') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($pages as $page)
                               <tr>
                                    <td>
                                        <a href="{{{ route('site.page.details', ['slug' => $page->slug]) }}}" target="_blank">
                                            {{{ $page->title }}}
                                        </a>
                                    </td>
                                    <td>
                                        {{{ $page->slug }}}
                                    </td>
                                    <td>
                                      <div class="btn-group">
                                            <button class="btn btn-outline-primary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{{ __('site_actions')}}}</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.page.edit', ['id' => $page->id]) }}" >   {{{ __('site_edit')}}}
                                                </a>
                                                <a class="dropdown-item confirmation" href="{{{ route('admin.page.delete', ['id' => $page->id]) }}}" data-confirm="{{ __('message_are_you_sure') }}">   {{{ __('site_delete')}}}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $pages->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>{{{ __('site_no_pages_found') }}}</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection