$(function(){
	$('.mobile-edit').on('click', function(e){
		e.preventDefault();
		$('#mobile_number').removeAttr('readonly');
	});
	$('.resend-otp').on('click', function(e){
		e.preventDefault();
		var formData = {
            'mobile_number': $('#mobile_number').val() 
        };
        $.ajax({
            url: $(this).data('url'),
            type: "post",
            data: formData,
            success: function(data) {
            	if(data.success == true){
            		swal({
				      	title: data.error,
				      	type: "success"
				    });
            	}
            	else{
	               	swal({
				      	title: data.error,
				      	type: "error"
				    });            		
            	}
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
			    swal({
				  	type: 'error',
				  	title: 'Oops...',
				  	text: 'Something went wrong!'
				})
			}
        });
	});

	$(".select2").select2();
	$('.list-rich-editor').summernote({
		height: ($(window).height() - 550), 
        toolbar: [
            ['para', ['ul', 'ol']]
        ]
    });
    $('.confirmation').click(function(e) {
		e.preventDefault();
		var linkURL = $(this).attr("href");
		var message = $(this).data('confirm');
		swal({
	      title: message,
	      type: "warning",
	      showCancelButton: true
	    }, function() {
	      window.location.href = linkURL;
	    });
	});

	var date = new Date();
	date.setDate(date.getDate());
	$('#appointment').datepicker({
		format: "dd/mm/yyyy",
	  	orientation: "auto",
	  	startDate: date,
	  	clearBtn: true,
	  	todayHighlight: true,
	  	autoclose: true,
	  	container: '.datepicker_wrapper'
	});

	$('.checkout-address-add').ajaxForm({
		beforeSubmit:function(formData, jqForm, options){ 
			$('#form-errors').html('');
			swal({
				title:'<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
              	html: true,
              	showConfirmButton: false,
              	allowOutsideClick: false
            })
		},
		success:function(responseText, statusText, xhr, $form){
			$('#form-errors').html('');
			swal.close();
			if(responseText.success){
				$('.payment').removeClass('disabledarea');	
				$('#form-errors').html('<div class="alert alert-success">'+responseText.message+'</div>');
			    $('html, body').animate({
			        scrollTop: $(".payment").offset().top
			    }, 2000);
			}
			else{
				$('#form-errors').html('<div class="alert alert-danger">'+responseText.message+'</div>');
			}
		},
		error :function( jqXhr ) {
			swal.close();
        	if( jqXhr.status === 401 )
            	location.reload();
        	if( jqXhr.status === 422 ) {
        		data = jqXhr.responseJSON;
        		errorsHtml = '<div class="alert alert-danger"><ul>';
		        $.each(data.errors, function( key, value ) {
		            errorsHtml += '<li>' + value + '</li>';
		        });
        		errorsHtml += '</ul></di>';            
        		$('#form-errors' ).html( errorsHtml );
        	}
	    }
	}); 

	var services = new Bloodhound({
	  	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  	queryTokenizer: Bloodhound.tokenizers.whitespace,
	  	remote: {
	    	url: $('.service-search').data('url')+'?q=%QUERY',
	    	wildcard: '%QUERY'
	  	}
	});
    $('.service-search').typeahead({
	  	hint: true,
	  	highlight: true,
	  	minLength: 1
	},{
		name: 'services',
        source: services,
        display: 'value',
        templates: {
		    suggestion: function(data) {
		    	return '<a href="'+data.url+'"><div class="media"><img class="mr-2" src="'+data.image+'"><div class="media-body"> <h5 class="mt-0 font-small">'+data.value+'</h5></div></div></a>';
			}
		 }
    });

    
    if($('.review-modal').length > 0){    	
		var packageId = null;
		$('#package-review-form').ajaxForm({
			delegation: true,
	        beforeSubmit:function(formData, jqForm, options){
	            $('.frmError').html('');
	            packageId = formData[2].value;
	        },
	        error:function(jqXhr) {
	            if( jqXhr.status === 422 ) {
	                var errors = jqXhr.responseJSON;
	                var valErr = '<ul>';
	                $.each(errors.errors, function( key, value ) {
	                    valErr += '<li class="text-danger">'+ value[0] + '</li>';
	                });
	                valErr += '</ul>'
	                $('.frmError').html(valErr);
	            } 
	        },
	        success:function(responseText, statusText, xhr, $form){
	            $('#review').modal('toggle');
	            $('.frmError').html('');
	            swal({
				  	type: 'success',
				  	title: '',
				  	text: $('#review').data('content')
				});
	        }
	    });
    }

    var SetRatingStar = function() {
	    return $('.star-rating .fa').each(function() {
	    	console.log($('.star-rating .fa').siblings('input.rating-value').val());
	        if (parseInt($('.star-rating .fa').siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
	            return $(this).removeClass('fa-star-o').addClass('fa-star');
	        } else {
	            return $(this).removeClass('fa-star').addClass('fa-star-o');
	        }
	    });
	};
	$('body').delegate('.star-rating .fa', 'click', function() {
	    $('.star-rating .fa').siblings('input.rating-value').val($(this).data('rating'));
	    return SetRatingStar();
	});
	$('body').delegate('.review-modal', 'click', function(){
        $($(this).data("target")+' .modal-content').load($(this).attr("href"));
        
    }); 
    $('#review').on('shown.bs.modal', function() {
	    SetRatingStar();
	});
});