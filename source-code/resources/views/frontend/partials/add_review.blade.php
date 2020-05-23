<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
     	{{ __('site_write_review') }}
    </h4>
</div>
<div class="modal-body">
	{!! Form::open(['url' => route('site.package.add.review', ['packageId' => $package->id]), 'class' => 'package-review-form']) !!}
        <div class="frmError"></div>
        <div class="form-group">
        	<label for="rating" class="text-bold-700">
        		{{ __('site_select_rating') }}:
        	</label>
        	<div class="star-rating">
		        <span class="fa fa-star-o" data-rating="1"></span>
		        <span class="fa fa-star-o" data-rating="2"></span>
		        <span class="fa fa-star-o" data-rating="3"></span>
		        <span class="fa fa-star-o" data-rating="4"></span>
		        <span class="fa fa-star-o" data-rating="5"></span>
		        <input type="hidden" name="rating" class="rating-value" value="@if(empty($review->rating) === false){{{ $review->rating }}}@else 0 @endif">
		    </div>
        </div>
        <input type="hidden" name="service_package_id" value="{{{ $package->id }}}">
		<div class="form-group">
			{!! Form::label('comments', __('site_write_review'), ['class' => 'text-bold-700']) !!}
            {!! Form::textarea('comments', empty($review->comments) === false ? $review->comments : null, ['class' => 'form-control']) !!} 
		</div>
		<div class="form-group">
			{!! Form::submit(__('site_update'), ['class' => 'btn btn-outline-primary collab-form-submit']) !!}
		</div>
	{!! Form::close() !!}
</div>