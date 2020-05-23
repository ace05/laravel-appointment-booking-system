<footer class="footer">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-3">
  				<span>{{{ __('site_copy_rights') }}} © {{{ date('Y') }}} {{{ config('settings.site_name') }}}</span>
  			</div>
  			<div class="col-md-9 ">
  				@if(empty($page_lists) === false)
  					<div class="float-right">
	  					@foreach($page_lists as $pageList)
	  						<a href="{{{ route('site.page.details', ['slug' => $pageList['slug']]) }}}" class="mr-1">{{{ $pageList['title'] }}}</a>
	  					@endforeach
  					</div>
  				@endif
  			</div>
  		</div>    	
  	</div>
</footer>