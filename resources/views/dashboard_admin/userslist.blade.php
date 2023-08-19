@extends('layouts_admin.master') 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Users List</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Users List</li>
					</ol>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<section class="content">
  <div class="row">
   <div class="col-12">
    
     <form action="{{ url('admin/usersmuldel') }}" method="post" onsubmit="return giveNotation()">
    {{ csrf_field() }}
      <div class="card">
        <div class="card-header">
         
          <input type="submit" name="submit" id="del_btn" value="Delete" class="btn btn-danger btn-sm pull-left"/>
          <a href="{{ route('users.create') }}" class="btn btn-success btn-sm pull-right">Add</a>
          
        </div>
        
        <div class="card-body mailbox-messages " style="overflow:scroll">
          <table id="product_table" class="table table-bordered table-hover table-striped mailbox-messages" style="width:100%; text-align: center;">
           <thead bgcolor="{{ Config::get('constants.TABLE_COLOR') }}">
            <tr style="color: {{ Config::get('constants.TABLE_FONT_COLOR') }}">
              <th style="text-align:center" class="sorting_disabled" >
                <!-- <div class="mailbox-controls "> -->
                  <button type="button" class="btn btn-default btn-xl checkbox-toggle" name="ch[]" style="padding:0 1rem;"><i class="fa fa-square-o" ></i>
                  </button>
                <!-- </div> -->
              </th>
              <th>Name</th>
              <th>Email</th>
              <th>logo</th>
              <th>Date</th>
              <th>Expire Date</th>
              <th>Option</th>
            </tr>
          </thead>
          
        </table>
      </div>
    </div>
  </form>
</div>
</div>
</section>
</div>

<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('/public/dist/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script>
	$('#product_table').DataTable( {
		"pagingType": "full_numbers",
		"processing": true,
		"serverSide": true,
		"order": [0],
		"ajax": {
			"url":"<?= route('usersdataProcessing') ?>",
			"dataType":"json",
			"type":"POST",
			"data":{"_token":"<?= csrf_token() ?>"}
		},
    dom: 'Bfrtip',
    buttons: [
        {
          extend: 'copyHtml5',
          exportOptions: {
            columns: [1,2,4,5]
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [1,2,4,5]
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [1,2,4,5]
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: [1,2,4,5]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [1,2,4,5]
          }
        },
        {
          extend: 'colvis',
          columns: ':not(:first-child)'
        }
        ],
      colVis: {
          exclude: [ 0 ]
        },
    "columnDefs": [
        { 
          "targets": [0,6],
          "orderable": false
        }]
    } );

	function dlt_data(id)
	{
		if (confirm("Are You Sure you want to delete?")) {
			$.ajax({  
				url: "{{ url('admin/usersdelete') }}/"+id,
				type: 'DELETE',
        data: {id:id,"_token":"<?= csrf_token() ?>"},
				success:function(data)  
				{
					alert("Record deleted successfully!");
					location.reload();
				}
			});
		}  
	}
</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <script>
  @if(Session::get('success'))
    var type="{{Session::get('alert-type','info')}}"

    switch(type){
      case 'info':
             toastr.info("{{ Session::get('success') }}");
             break;
          case 'success':
              toastr.success("{{ Session::get('success') }}");
              break;
          case 'warning':
              toastr.warning("{{ Session::get('success') }}");
              break;
          case 'error':
            toastr.error("{{ Session::get('success') }}");
            break;
    }
  @endif
</script>

@endsection