@extends('frontend.layouts.app')
@section('title')
    {{{ $page->title }}}
@endsection
@section('content')
<section class="py-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="page-title  text-center border-bottom py-3">
                    <h3>
                        {{{ $page->title }}}
                    </h3>
                </div>
                <div class="details py-3">
                    {!! $page->details !!}                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
