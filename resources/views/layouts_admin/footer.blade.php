<!-- Main Footer -->
<footer class="main-footer">
	<!-- Default to the left -->
	<strong>Copyright © 2019-2020 Admin. All rights reserved.</strong>
	<div class="float-right d-none d-sm-inline-block">
      <b>Thanks</b>
    </div>
</footer>
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>
	function validate() {
		var old_pswd = document.getElementById("old_pswd").value;
		var new_pswd = document.getElementById("new_pswd").value;
		var confirm_pswd = document.getElementById("confirm_pswd").value;
		if(old_pswd != '' &&  new_pswd != '' && confirm_pswd != '')
		{
			$.ajax({  
				url: "{{ url('admin/updatePassword')}}",
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

	$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
});





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
</script>