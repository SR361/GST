@extends('layouts.master') 
@section('content')
 @guest @yield('content') @else
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{ trans('app.Employee List') }}</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('app.Employee List') }}</li>
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
    
     <form action="{{ url(app()->getLocale().'/employeesmuldel') }}" method="post" onsubmit="return giveNotation()">
    {{ csrf_field() }}
      <div class="card">

         <div class="card-header" style="display: <?php if($delete_row == '0' && $add_row == '0'){ echo "none"; } ?>">
          <?php if($delete_row == '1'){ ?>
          <input type="submit" name="submit" id="del_btn" value="{{ trans('app.Delete') }}" class="btn btn-danger btn-sm pull-left"/>
          <?php } ?>
          <?php if($add_row == '1'){ ?>
           <a href="{{ route('employees.create',app()->getLocale()) }}" class="btn btn-success btn-sm pull-right">{{ trans('app.Add Employee') }}</a>
          <?php } ?>
        </div>
        
        <div class="card-body mailbox-messages " > <!-- style="overflow:scroll" -->
          <table id="employee_table" class="{{ Config::get('constants.TABLE_CLASS') }}"  style="width:100%; text-align: center;"> <!-- class="table table-bordered table-hover table-striped mailbox-messages" -->
           <thead bgcolor="{{ Config::get('constants.TABLE_COLOR') }}">
            <tr style="color: {{ Config::get('constants.TABLE_FONT_COLOR') }}">
              <th style="text-align:center" class="sorting_disabled" >
                <!-- <div class="mailbox-controls "> -->
                  <button type="button" class="btn btn-default btn-xl checkbox-toggle" name="ch[]" style="padding:0 1rem;"><i class="fa fa-square-o" ></i>
                  </button>
                <!-- </div> -->
              </th>
              <th>{{ trans('app.Name') }}</th>
              <th>{{ trans('app.Email') }}</th>
              <th>{{ trans('app.Role') }}</th>
              <th>{{ trans('app.Date') }}</th>
              <th>{{ trans('app.Option') }}</th>
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
 @endguest @yield('javascript')
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
	var table = $('#employee_table').DataTable( {
		"pagingType": "full_numbers",
		"processing": true,
		"serverSide": true,
		"order": [0],
		"ajax": {
			"url":"<?= route('employeedataProcessing',app()->getLocale()) ?>",
			"dataType":"json",
			"type":"POST",
			"data":{"_token":"<?= csrf_token() ?>"}
		},
    dom: 'Bfrtip',
    buttons: [
        {
          extend: 'excelHtml5',
          className: '<?php if($excel == '0'){ echo 'd-none'; } ?>',
          exportOptions: {
            columns: [1,2,3,4]
          },
          text:"{{ trans('app.Excel') }}"
        },
        {
          extend: 'pdfHtml5',
          className: '<?php if($pdf == '0'){ echo 'd-none'; } ?>',
          orientation: 'landscape',//landscape give you more space
          pageSize: 'A4',
          title:'Employee PDF',
          exportOptions: {
            columns: [1,2,3,4]
          },
          text:"{{ trans('app.PDF') }}"
        },
        {
          extend: 'print',
          className: '<?php if($print == '0'){ echo 'd-none'; } ?>',
          exportOptions: {
            columns: [1,2,3,4]
          },
          text:"{{ trans('app.Print') }}"
        },
        {
          extend: 'colvis',
          className: '<?php if($col_visible == '0'){ echo 'd-none'; } ?>',
          columns: <?php if($delete_row == '0' && $update_row == '0'){ echo '[1,2,3,4]'; }else{ echo '[1,2,3,4,5]'; } ?>,
          text:"{{ trans('app.Column visibility') }}"
        },
        {
          extend: 'pageLength',
          className: '<?php if($show_row == '0'){ echo 'd-none'; } ?>',
        }
        ],
        lengthMenu: [
            [ 10, 25, 50, 10000 ],
            [ '10 rows', '25 rows', '50 rows', '10000 rows' ]
        ],
      "columnDefs": [
        { 
          "targets": [0,3,5],
          "orderable": false
        },
        {
          "targets": [ 0 ],
          "visible": '<?php if($delete_row == '0'){ echo false; }else{ echo true; } ?>'
        },
        {
          "targets": [ 1 ],
          "visible": '<?php if(in_array('1', $array_check)){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('1', $array_check)){ echo false; }else{ echo true; } ?>'
        }
        ,{
          "targets": [ 2 ],
          "visible": '<?php if(in_array('2', $array_check)){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('2', $array_check)){ echo false; }else{ echo true; } ?>'
        }
        ,{
          "targets": [ 3 ],
          "visible": '<?php if(in_array('3', $array_check)){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('3', $array_check)){ echo false; }else{ echo true; } ?>'
        }
        ,{
          "targets": [ 4 ],
          "visible": '<?php if(in_array('4', $array_check)){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('4', $array_check)){ echo false; }else{ echo true; } ?>'
        }
        ,{
          "targets": [ 5 ],
           "visible": '<?php if(in_array('5', $array_check) || ($delete_row == '0' && $update_row == '0')){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('5', $array_check) || ($delete_row == '0' && $update_row == '0')){ echo false; }else{ echo true; } ?>'
        }]
    } );

  $('#employee_table').on( 'column-visibility.dt', function ( e, settings, column, state ) {
   var name = "Emplist";
   
   if(state == true)
   {
     $.ajax({  
      url: "{{ url(app()->getLocale().'/visible') }}",
      type: 'POST',
      data: {notvisible:column,val:'1',name:name,"_token":"<?= csrf_token() ?>"},
      success:function(data)  
      {
        swal("", "Column show done!", "success");
        table.ajax.reload();
      }
    });
   }
   else
   {
     $.ajax({  
      url: "{{ url(app()->getLocale().'/visible') }}",
      type: 'POST',
      data: {notvisible:column,val:'0',name:name,"_token":"<?= csrf_token() ?>"},
      success:function(data)  
      {
        swal("", "Column hide done!", "success");
        table.ajax.reload();
             }
    });
   }

 } );

	function dlt_data(id)
	{
		if (confirm("Are You Sure you want to delete?")) {
			$.ajax({  
				url: "{{ url(app()->getLocale().'/employeesdelete')}}/"+id,
				type: 'DELETE',
        data: {id:id,"_token":"<?= csrf_token() ?>"},
				success:function(data)  
				{
          swal("", "Record Deleted successfully!", "success");
          table.ajax.reload();
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