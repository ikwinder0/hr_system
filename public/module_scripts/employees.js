$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/employees_list",
            type : 'GET'
        },
		"language": {
            "lengthMenu": dt_lengthMenu,
            "zeroRecords": dt_zeroRecords,
            "info": dt_info,
            "infoEmpty": dt_infoEmpty,
            "infoFiltered": dt_infoFiltered,
			"search": dt_search,
			"paginate": {
				"first": dt_first,
				"previous": dt_previous,
				"next": dt_next,
				"last": dt_last
			},
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	jQuery("#department_id").change(function(){
		jQuery.get(main_url+"employees/is_designation/"+jQuery(this).val(), function(data, status){
			jQuery('#designation_ajax').html(data);
		});
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_token"]').val(JSON.csrf_hash);	
					Ladda.stopAll();				
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var user_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url : main_url+"users/read",
		type: "GET",
		data: 'jd=1&data=user&user_id='+user_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var user_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url :  main_url+"users/read",
		type: "GET",
		data: 'jd=1&type=view_user&user_id='+user_id,
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
			}
		}
		});
	});
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'add_record');
		fd.append("form", action);
		e.preventDefault();		
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					
					if(JSON.type == 'info'){
						$('ul.step-anchor').find('.nav-item').removeClass('active');
						$('ul.step-anchor').find('li.step1').addClass('active');
						$('fieldset.fieldset_2').css({
							'display': 'none', 
							'opacity': 0,
							'transform': 'scale(1)',
							'position': 'absolute'
						});
						$('fieldset.fieldset_3').css({
							'display': 'none', 
							'opacity': 0,
							'transform': 'scale(1)',
							'position': 'absolute'
						});
						$('fieldset.fieldset_1').css({
							'display': 'block', 
							'transform': 'scale(1)', 
							'position': 'absolute',
							'opacity': 1
						});
					}
					if(JSON.type == 'educ'){
						$('ul.step-anchor').find('li.step3').removeClass('active');
						$('ul.step-anchor').find('li.step2').addClass('active');
						$('fieldset.fieldset_1').css({
							'display': 'none', 
							'opacity': 0,
							'transform': 'scale(1)',
							'position': 'absolute'
						});
						$('fieldset.fieldset_3').css({
							'display': 'none', 
							'opacity': 0,
							'transform': 'scale(1)',
							'position': 'absolute'
						});
						$('fieldset.fieldset_2').css({
							'display': 'block', 
							'transform': 'scale(1)', 
							'position': 'absolute',
							'opacity': 1
						});
					}
					
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('show');
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
			} 	        
	   });
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'employees/delete_staff');
});

var v = $(".add_employee_form").validate({
        
      rules: {
        
        applied_for: {
          required: true,
        },
        file: {
          required: true,
		  accept: "image/jpeg,image/png"
        },
        first_name: {
          required: true,
		  lettersonly:true
         
        },
        last_name: {
          required: true,
		  lettersonly:true
        },
		email: {
          required: true,
		  
          email: true,
            remote: {
                 headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('checkemail')}}",
                    type: "post"
                    
                 }
         
        },
		contact_number: {
          required: true,
        },
		dob: {
          required: true,
        },
		gender: {
          required: true,
        },
		marital_status: {
          required: true,
        },
		state: {
          required: true,
        },
		city: {
          required: true,
        },
		zipcode: {
          required: true,
        },
		religion: {
          required: true,
        },
		country: {
          required: true,
        },
		experience_1: {
          required: true,
        },
		high_school: {
          required: true,
        },
		degree: {
          required: true,
        },
		resume: {
          required: true,
        },
		passport: {
          required: true,
        },
		education_certificate: {
          required: true,
        },
		experience_certificate: {
          required: true,
        },
		police_clearance_certificate: {
          required: true,
        }
		
        
      },
      messages:{


    },
	errorPlacement: function(error, element) {
        $('.error-'+element.attr("name")).append(error);
    },
    
      //errorElement: "div",
      //errorClass: "help-inline-error",
     // errorLabelContainer: ".custom-error",
    });

//step form
var current_fs, next_fs, previous_fs; 
var left, opacity, scale; 
var animating;
$(".next").click(function () {
	//var form = $(".add_employee_form");
	if (animating) return false;
	animating = true;
	current_fs = $(this).parent().parent().parent().parent().parent();
	console.log(current_fs);
	next_fs = $(this).parent().parent().parent().parent().parent().next();
	if (v.form()) {
	$(".step-anchor li").eq($("fieldset").index(next_fs)).addClass("active");
	
	next_fs.show();
	current_fs.animate({
		opacity: 0
	}, {
		step: function (now, mx) {
			
			scale = 1 - (1 - now) * 0.2;
			opacity = 1 - now;
			current_fs.css({
				'transform': 'scale(' + scale + ')',
				'position': 'absolute'
			});
			next_fs.css({
				'opacity': opacity
			});
		},
		duration: 800,
		complete: function () {
			current_fs.hide();
			animating = false;
		},
		easing: 'easeInOutBack'
	});
	}
});
$(".previous").click(function () {
	if (animating) return false;
	animating = true;
	current_fs = $(this).parent().parent().parent().parent().parent();
	previous_fs = $(this).parent().parent().parent().parent().parent().prev();
	$(".step-anchor li").eq($("fieldset").index(current_fs)).removeClass("active");
	previous_fs.show();
	current_fs.animate({
		opacity: 0
	}, {
		step: function (now, mx) {
			scale = 0.8 + (1 - now) * 0.2;
			
			opacity = 1 - now;
	
			previous_fs.css({
				'transform': 'scale(' + scale + ')',
				'opacity': opacity
			});
		},
		duration: 800,
		complete: function () {
			current_fs.hide();
			animating = false;
		},
		easing: 'easeInOutBack'
	});
});

$('select').change(function(){
    if ($(this).val()!="")
    {
        $(this).valid();
    }
});

$('input[type=file]').change(function(){
    if ($(this).val()!="")
    {
        $(this).valid();
    }
});
