@extends('backend.layouts.app')
@section('title')
   {{{  __('site_service_categories') }}}
@endsection
@section('content')
<div class="app-title">
    <h1>
        <i class="icon fa fa-chevron-right"></i> {{{ __('site_service_categories') }}}
    </h1>
    <a href="{{{ route('admin.categories.add') }}}" class="btn btn-lg btn-primary">
        <i class="fa fa-plus"></i>{{{ __('site_add') }}}
    </a>
</div>
@include('backend.partials.notifications')
<div class="row">
    <div class="col-md-12">
       <div class="tile">
        @if($categories->count() > 0)
            <div class="table-responsive">
                 <table class="table">
                    <thead>
                       <tr>
                          <th>{{{ __('site_category_name') }}}</th>
                          <th>{{{ __('site_category_cover_photo') }}}</th>
                          <th>{{{ __('site_is_active') }}}</th>
                          <th>{{{ __('site_actions') }}}</th>
                       </tr>
                    </thead>
                    <tbody>
                            @foreach($categories as $category)
                               <tr>
                                    <td>{{{ $category->name }}}</td>
                                    <td>
                                        <img src="{{{ url($category->cover) }}}"  class="img-thumbnail" />
                                    </td>
                                    <td>
                                        @if(empty($category->is_active) === false)
                                            <span class="badge badge-success">{{{ __('site_yes') }}}</span>
                                        @else
                                            <span class="badge badge-danger">{{{ __('site_no') }}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{{ route('admin.categories.edit', ['id' => $category->id ]) }}}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                            {{{ __('site_edit') }}}
                                        </a>
                                        <a href="{{{ route('admin.categories.delete', ['id' => $category->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                           {{{ __('site_delete') }}}
                                        </a>
                                        @if($category->is_active)
                                             <a href="{{{ route('admin.categories.disable', ['id' => $category->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-info">
                                                <i class="fa fa-times"></i>
                                               {{{ __('site_disable') }}}
                                            </a>
                                        @else
                                            <a href="{{{ route('admin.categories.enable', ['id' => $category->id ]) }}}" data-confirm="{{ __('message_are_you_sure') }}" class="confirmation btn btn-success">
                                                <i class="fa fa-check"></i>
                                               {{{ __('site_enable') }}}
                                            </a>
                                        @endif
                                    </td>
                               </tr>
                            @endforeach
                    </tbody>
                 </table>
              </div>
                {{ $categories->render("pagination::bootstrap-4") }}
            @else
                <div class="alert alert-warning">
                    <p>No Categories found</p>
                </div>
            @endif
       </div>
    </div>
  </div>
@endsection