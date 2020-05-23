$(function() {
	var treeviewMenu = $('.app-menu');
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
	$("[data-toggle='tooltip']").tooltip();
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
	$('.rich-editor').summernote({
		height: ($(window).height() - 350), 
	});
	$('#from-datepicker').datepicker({
		format: "dd-mm-yyyy",
		todayHighlight: true,
	  	autoclose: true,
		container: '.from_datepicker_wrapper'
	});
	$('#to-datepicker').datepicker({
		format: "dd-mm-yyyy",
		todayHighlight: true,
	  	autoclose: true,
		container: '.to_datepicker_wrapper'
	});

	if($("#lineChartDemo").length > 0){
		var revenue = JSON.parse($('.revenue-trends').html());
		var orders = JSON.parse($('.orders-trends').html());
		var revenueKeys = [];
	    var revenueValues = [];
	    var orderValues = [];
	    for(var k in revenue) revenueKeys.push(k);
	    for(var k in revenue) revenueValues.push(revenue[k]);
	    for(var k in orders) orderValues.push(orders[k]);
		var data = {
	  		labels: revenueKeys,
		  	datasets: [
		  		{
		  			label: "Revenue",
		  			fillColor: "rgba(220,220,220,0.2)",
		  			strokeColor: "rgba(220,220,220,1)",
		  			pointColor: "rgba(220,220,220,1)",
		  			pointStrokeColor: "#fff",
		  			pointHighlightFill: "#fff",
		  			pointHighlightStroke: "rgba(220,220,220,1)",
		  			data: revenueValues
		  		},
		  		{
		  			label: "Orders",
		  			fillColor: "rgba(151,187,205,0.2)",
		  			strokeColor: "rgba(151,187,205,1)",
		  			pointColor: "rgba(151,187,205,1)",
		  			pointStrokeColor: "#fff",
		  			pointHighlightFill: "#fff",
		  			pointHighlightStroke: "rgba(151,187,205,1)",
		  			data: orderValues
		  		}
		  	]
	  	};
	  	var ctxl = $("#lineChartDemo").get(0).getContext("2d");
	    var lineChart = new Chart(ctxl).Line(data, {
	    	multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>"
	    });
	}
});