<!-- Main Footer -->
<footer class="main-footer hidden-print">
	<!-- Default to the left -->
	<strong>{{ trans('app.Copyright © 2019-2020 Admin. All rights reserved') }}.</strong>
	<div class="float-right d-none d-sm-inline-block">
      <b>{{ trans('app.Thanks') }}</b>
    </div>
</footer>
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>

	// $(window).bind('beforeunload', function(){
	// 	return 'Are you sure you want to leave?';
	// });

	$('form').on('focus', 'input[type=number]', function (e) {
		$(this).on('mousewheel.disableScroll', function (e) {
			e.preventDefault()
		})
	})
	$('form').on('blur', 'input[type=number]', function (e) {
		$(this).off('mousewheel.disableScroll')
	})

	function validate() {
		var old_pswd = document.getElementById("old_pswd").value;
		var new_pswd = document.getElementById("new_pswd").value;
		var confirm_pswd = document.getElementById("confirm_pswd").value;
		if(old_pswd != '' &&  new_pswd != '' && confirm_pswd != '')
		{
			$.ajax({  
				url: "{{ url(app()->getLocale(),'updatePassword')}}",
				type: 'GET',
				data: {old_password:old_pswd,new_password:new_pswd,confirm_password:confirm_pswd,"_token":"<?= csrf_token() ?>"},
				success:function(data)  
				{
					alert(data);
					location.reload();
				}
			});
		}
		else
		{
			alert("Please enter all fields.");
		}
	}

	function language_chnage(value) {

		

		var newURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname + window.location.search;

		var pathArray = window.location.pathname.split('/');

		var newPathname = "";
		for (i = 1; i < pathArray.length; i++) {
			newPathname += "/";
			if(i == '2')
			{
				newPathname += value;
			}
			else
			{
				newPathname += pathArray[i];
			}
			
		}


		console.log(window.location.protocol);

		var updated_url = window.location.protocol + "//" + window.location.host  + newPathname + window.location.search;


		location.href = updated_url;

		// $.ajax({  
		// 		url: "{{ url('language')}}",
		// 		type: 'GET',
		// 		data: {value:value,"_token":"<?= csrf_token() ?>"},
		// 		success:function(data)  
		// 		{
		// 			alert(data);
		// 			location.reload();
		// 		}
		// 	});

	}
</script>
<script>
	$(function(){
		$('.mailbox-messages input[type="checkbox"]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});
		$(".checkbox-toggle").click(function(){
			var clicks = $(this).data('clicks');
			if (clicks) {
			//Uncheck all checkboxes
			$(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
			$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
		} else {
			//Check all checkboxes
			$(".mailbox-messages input[type='checkbox']").iCheck("check");
			$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
		}
		$(this).data("clicks", !clicks);
	});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		})
	});


	$(function () {
		$("#example1").DataTable();
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});

// 	$(function () {
//     //Initialize Select2 Elements
//     $('.select2').select2()
// });





	function giveNotation(textToShow){
		if(textToShow == null || textToShow == "undefined")
			textToShow = "Please select checkbox !!";
		var bvm=0;
		$(".all_del").each(function (i) {
			isChecked = $(".all_del").is(':checked');
			if(isChecked){
				bvm++;
			}
		});
		if(bvm == 0){
			alert(textToShow);
			return false;
		}else{
			var x =confirm("Are you sure to delete")
			if(x == 1){
				return true;
			}else{
				return false;
			}
		}
	}


	window.setTimeout(function() {
    $("#alert_box").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);

	$(document).ready(function() {
    $('.datepicker').datepicker({
        format: "<?php echo Config('constants.DATE_PICKER'); ?>",
        'setDate': new Date()
    }).datepicker('setDate', 'today');

		$(".search-menu-box").on('input', function() {
		    var filter = $(this).val();
		    $(".nav-sidebar li").each(function(){
		        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
		            $(this).hide();
		        } else {
		        	// console.log(this);
		            $(this).show();
		            // $(this).parentsUntil(".treeview").openMenu();
		        }
		    });
		});
});
</script>