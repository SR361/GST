@extends('layouts.master') 
@section('content')
 @guest @yield('content') @else
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{ trans('app.Role List') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('app.Role List') }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
<div id="update_visiblity" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title">{{ trans('app.Visible') }}</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body">
      <form method="POST" id="visible_form" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="role_id" id="visible_role_id">

        <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th style="width: 20%;">{{ trans('app.Tab Name') }}</th>
                    <th style="width: 10%;">{{ trans('app.Add') }} </th>
                    <th style="width: 10%;">{{ trans('app.Delete') }}</th>
                    <th style="width: 10%;">{{ trans('app.Edit') }}</th>
                    <th style="width: 10%;">{{ trans('app.Excel') }}</th>
                    <th style="width: 10%;">{{ trans('app.PDF') }}</th>
                    <th style="width: 10%;">{{ trans('app.Print') }}</th>
                    <th style="width: 10%;">{{ trans('app.Column visibility') }}</th>
                    <th style="width: 10%;">{{ trans('app.Show Rows') }}</th>
                  </tr>
        <?php if(isset($tab_list)){
        foreach ($tab_list as $tkey) { ?>
          <tr>
            <td><input type="checkbox" name="check{{ $tkey['id'] }}" id="check{{ $tkey['id'] }}" title="{{ $tkey['id'] }}" class="check" value="1"> {{ trans('app.'.$tkey['name']) }}
            </td>
            <td><input type="checkbox" name="add{{ $tkey['id'] }}" id="add{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="delete{{ $tkey['id'] }}" id="delete{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="update{{ $tkey['id'] }}" id="update{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="excel{{ $tkey['id'] }}" id="excel{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="pdf{{ $tkey['id'] }}" id="pdf{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="print{{ $tkey['id'] }}" id="print{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="col_vis{{ $tkey['id'] }}" id="col_vis{{ $tkey['id'] }}" class="flat-red" value="1"></td>
            <td><input type="checkbox" name="col_show{{ $tkey['id'] }}" id="col_show{{ $tkey['id'] }}" class="flat-red" value="1"></td>
           </tr>
        <?php } } ?>
         </tbody></table>
        </div>
        <center><input type="submit" value="{{ trans('app.Submit') }}" class="btn btn-info"/></center>
      </form>
    </div>
  </div>
</div>
</div>

<div id="add_role" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title">{{ trans('app.Add Role') }}</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body">
         <div class="form-group">
          <label>{{ trans('app.Role Name') }}</label>
          <input type="text" class="form-control" id="add_role_name">
        </div>
         <center><input type="submit" value="{{ trans('app.Submit') }}" class="btn btn-info" onclick="add_role();"/></center>
    </div>
  </div>
</div>
</div>

<div id="update_role" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title">{{ trans('app.Update Role') }}</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body">
         <div class="form-group">
          <label>{{ trans('app.Role Name') }}</label>
          <input type="text" required class="form-control" id="update_role_name">
          <input type="hidden" id="update_role_id">
        </div>
         <center><input type="submit" value="{{ trans('app.Update') }}" class="btn btn-info" onclick="update_role();" /></center>
    </div>
  </div>
</div>
</div>

	<!-- /.content-header -->
	<section class="content">
  <div class="row">
   <div class="col-12">
    
     <form action="{{ url(app()->getLocale().'/rolesmuldel') }}" method="post" onsubmit="return giveNotation()">
    {{ csrf_field() }}
      <div class="card">
        <div class="card-header" style="display: <?php if($delete_row == '0' && $add_row == '0'){ echo "none"; } ?>">
          <?php if($delete_row == '1'){ ?>
          <input type="submit" name="submit" id="del_btn" value="{{ trans('app.Delete') }}" class="btn btn-danger btn-sm pull-left"/>
          <?php } ?>
          <?php if($add_row == '1'){ ?>
          <a href="#" class="btn btn-success btn-sm pull-right" onclick="open_add_modal();">{{ trans('app.Add Role') }}</a>
          <?php } ?>
        </div>
        
        <div class="card-body mailbox-messages " > <!-- style="overflow:scroll" -->
          <table id="role_table" class="{{ Config::get('constants.TABLE_CLASS') }}"  style="width:100%; text-align: center;"> <!-- class="table table-bordered table-hover table-striped mailbox-messages" -->
           <thead bgcolor="{{ Config::get('constants.TABLE_COLOR') }}">
            <tr style="color: {{ Config::get('constants.TABLE_FONT_COLOR') }}">
              <th style="text-align:center" class="sorting_disabled" >
                  <button type="button" class="btn btn-default btn-xl checkbox-toggle" name="ch[]" style="padding:0 1rem;"><i class="fa fa-square-o" ></i>
                  </button>
              </th>
              <th>{{ trans('app.Role Name') }}</th>
              <th>{{ trans('app.Visiblity') }}</th>
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

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
	var table = $('#role_table').DataTable( {
		"pagingType": "full_numbers",
		"processing": false,
		"serverSide": true,
		"order": [0],
		"ajax": {
			"url":"<?= route('roledataProcessing',app()->getLocale()) ?>",
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
            columns: [1,3]
          },
          text:"{{ trans('app.Excel') }}"
        },
        {
          extend: 'pdfHtml5',
          className: '<?php if($pdf == '0'){ echo 'd-none'; } ?>',
          orientation: 'landscape',//landscape give you more space
          pageSize: 'A4',
          title:'Role List',
          exportOptions: {
            columns: [1,3]
          },
          text:"{{ trans('app.PDF') }}"
        },
        {
          extend: 'print',
          className: '<?php if($print == '0'){ echo 'd-none'; } ?>',
          exportOptions: {
            columns: [1,3]
          },
          text:"{{ trans('app.Print') }}"
        },
        {
          extend: 'colvis',
          className: '<?php if($col_visible == '0'){ echo 'd-none'; } ?>',
          columns: <?php if($delete_row == '0' && $update_row == '0'){ echo '[1,2,3]'; }else{ echo '[1,2,3,4]'; } ?>,
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
          "targets": [0,2,4],
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
        },
        {
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
          "visible": '<?php if(in_array('4', $array_check) || ($delete_row == '0' && $update_row == '0')){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('4', $array_check) || ($delete_row == '0' && $update_row == '0')){ echo false; }else{ echo true; } ?>'
        }]
    } );

  $('#role_table').on( 'column-visibility.dt', function ( e, settings, column, state ) {
   var name = "Rolelist";
   
   if(state == true)
   {
     $.ajax({  
      url: "{{ url(app()->getLocale().'/visible') }}",
      type: 'POST',
      data: {notvisible:column,val:'1',name:name,"_token":"<?= csrf_token() ?>"},
      success:function(data)  
      {
        swal("", "Column show done!", "success");
        table.ajax.reload(null, false);
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
        table.ajax.reload(null, false);
             }
    });
   }

 } );

//   setInterval( function () {
// table.ajax.reload(null, false);
// }, 1000 );

	function dlt_data(id)
	{
		if (confirm("Are You Sure you want to delete?")) {
			$.ajax({  
				url: "{{ url(app()->getLocale().'/rolesdelete')}}/"+id,
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

  function open_add_modal()
  {
    $("#add_role").modal('show');
  }

  function add_role()
  {
    var name = $("#add_role_name").val();
    if(name == '')
    {
      swal("", "Enter Role Name first!", "error");
    }
    else
    {
      $.ajax({  
        url: "{{ route('roles.store',app()->getLocale()) }}",
        type: 'POST',
        data: {name:name,"_token":"<?= csrf_token() ?>"},
        success:function(data)  
        {
          $("#add_role_name").val('');
          $("#add_role").modal('hide');
          swal("", "Role Add successfully!", "success");
          table.ajax.reload();
        }
      });
    }
  }



  function update_role_data(name,id)
  {
    $("#update_role_name").val(name);
    $("#update_role_id").val(id);
    $("#update_role").modal('show');
  }

  function update_role()
  {
    var name = $("#update_role_name").val();
    var id = $("#update_role_id").val();
    if(name == '')
    {
      swal("", "Enter Role Name first!", "error");
    }
    else
    {
      $.ajax({  
        url: "{{ route('roleupdate',app()->getLocale()) }}",
        type: 'POST',
        data: {id:id,name:name,"_token":"<?= csrf_token() ?>"},
        success:function(data)  
        {
          $("#update_role").modal('hide');
          swal("", "Role Update successfully!", "success");
          table.ajax.reload(null, false);
          // table.ajax.reload();
        }
      });
    }
  }

  $(".check").on('change',function(){
    var id = $(this).attr("title");
    if (this.checked == true) {
      $("#add"+id).iCheck("check");
      $("#update"+id).iCheck("check");
      $("#delete"+id).iCheck("check");
      $("#excel"+id).iCheck("check");
      $("#pdf"+id).iCheck("check");
      $("#print"+id).iCheck("check");
      $("#col_vis"+id).iCheck("check");
      $("#col_show"+id).iCheck("check");
    }else{
      $("#add"+id).iCheck("uncheck");
      $("#update"+id).iCheck("uncheck");
      $("#delete"+id).iCheck("uncheck");
      $("#excel"+id).iCheck("uncheck");
      $("#pdf"+id).iCheck("uncheck");
      $("#print"+id).iCheck("uncheck");
      $("#col_vis"+id).iCheck("uncheck");
      $("#col_show"+id).iCheck("uncheck");
    }
  })

  function update_visiblity(id)
  {
    $.ajax({  
        url: "{{ route('visible_data',app()->getLocale()) }}",
        type: 'POST',
        data: {id:id,"_token":"<?= csrf_token() ?>"},
        success:function(data)  
        {
          $(".flat-red").iCheck("uncheck");
          $("#visible_form")[0].reset();
          var new_data = JSON.parse(data);
          for (var i=0; i < new_data.length; i++) { 
             $("#check"+new_data[i].tab_id).iCheck("check");
             if(new_data[i].add_row == '1')
             {
              $("#add"+new_data[i].tab_id).iCheck("check");
             }  
             if(new_data[i].update_row == '1')
             {
              $("#update"+new_data[i].tab_id).iCheck("check");
             }  
             if(new_data[i].delete_row == '1')
             {
              $("#delete"+new_data[i].tab_id).iCheck("check");
             } 
             if(new_data[i].excel == '1')
             {
              $("#excel"+new_data[i].tab_id).iCheck("check");
             } 
             if(new_data[i].pdf == '1')
             {
              $("#pdf"+new_data[i].tab_id).iCheck("check");
             } 
             if(new_data[i].print == '1')
             {
              $("#print"+new_data[i].tab_id).iCheck("check");
             } 
             if(new_data[i].col_visible == '1')
             {
              $("#col_vis"+new_data[i].tab_id).iCheck("check");
             } 
             if(new_data[i].show_row == '1')
             {
              $("#col_show"+new_data[i].tab_id).iCheck("check");
             }    
          }
          $("#update_visiblity").modal('show');
          $("#visible_role_id").val(id);
        }
      });  
  }


  $(document).ready(function (e){
    $("#visible_form").on('submit',(function(e) {
      e.preventDefault();
      var sdata = new FormData(this);
      $.ajax({
        url: "<?= route('update_visible',app()->getLocale()) ?>",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
          $("#update_visiblity").modal('hide');
          swal("visiblity Update Done.", {
            icon: "success",
          });
        }        
      });
    }));
  });
</script>
<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> -->
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