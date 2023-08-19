@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
        <?php if($type == 'received'){ ?>
          <h1 class="m-0 text-dark">{{ trans('app.Add Received Payment') }}</h1>
        <?php }else{ ?>
          <h1 class="m-0 text-dark">{{ trans('app.Add Made Payment') }}</h1>
        <?php }?>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
         <li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/Payments') }}">{{ trans('app.Payment List') }}</a></li>
         <?php if($type == 'received'){ ?>
          <li class="breadcrumb-item active">{{ trans('app.Add Received Payment') }}</li>
        <?php }else{ ?>
          <li class="breadcrumb-item active">{{ trans('app.Add Made Payment') }}</li>
        <?php }?>
      </ol>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>

<section class="content">
	<div class="col-md-12">
		<div class="col-md-12">
			@if(isset($payment))        
			<form action="{{ route('payments.update',[app()->getLocale(),$payment->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" value="{{ $payment->id }}" name="id"> 
				@method('PUT')      
				@else
				<form action="{{ route('payments.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data" autocomplete="off">     
					@endif
					@csrf
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
                 <?php if($type == 'received'){ ?>
                  <input type="hidden" id="bill_type" value="0">
                   <div class="form-group input-group">
                    <div class="col-md-2">
                     <label>{{ trans('app.Client') }}</label>
                   </div>
                   <?php if(isset($payment)){ ?>
                    <input type="hidden" value="<?php echo $payment->client_id; ?>" name="client_id">
                   <?php } ?>
                   <div class="col-md-4">
                     <select class="form-control select2" required  name="client_id"  id="client_id" onchange="client_chanage(this.value)" <?php if(isset($payment)){ echo "disabled";} ?>>
                      <option selected disabled value="">{{ trans('app.Select One') }}</option>
                      @foreach($client_data as $client_val)
                      <option value="{{ $client_val->id }}" <?php if(isset($payment)){if($payment->client_id == $client_val->id){echo "selected";}} ?> >{{ $client_val->company_name }}-{{ $client_val->contact_person }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              <?php }else{ ?>

               <div class="form-group input-group">
                <input type="hidden" id="bill_type" value="3">
                    <div class="col-md-2 m-t-5">
                      <label>{{ trans('app.Vendor') }}</label>
                    </div>
                    <div class="col-md-6 col-sm-8">
                      <select class="form-control select2" required  name="client_id"  id="client_id" onchange="client_chanage(this.value)" >
                        <option selected disabled value="">{{ trans('app.Select One') }}</option>
                        @foreach($vendor_data as $vendor_val)
                        <option value="{{ $vendor_val->id }}" <?php if(isset($payment)){if($payment->client_id == $vendor_val->id){echo "selected";}} ?> >{{ $vendor_val->company_name }}-{{ $vendor_val->contact_person }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

              <?php } ?>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Number') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="text" required class="form-control" name="number"  value="@if(isset($payment)){{ $payment->number }}@endif">
												</div>
											</div>
										</div>
                    <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Date') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <input type="text" required id="date"  class="form-control datepicker" name="date"  value="@if(isset($payment)){{ date('d-m-Y',strtotime($payment->date)) }}@endif">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Method') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <select class="form-control select2" name="method" onchange="payment_due_date(this.value)" required>
                           <option value="0" <?php if(isset($payment)){if($payment->method == '0'){echo "selected";}} ?> >{{ trans('app.Cash Memo') }}</option> 
                            <option value="1" <?php if(isset($payment)){if($payment->method == '1'){echo "selected";}} ?> >{{ trans('app.Credit Card') }}</option> 
                            <option value="2" <?php if(isset($payment)){if($payment->method == '2'){echo "selected";}} ?> >{{ trans('app.Cheque') }}</option> 
                            <option value="3" <?php if(isset($payment)){if($payment->method == '3'){echo "selected";}} ?> >{{ trans('app.Bank Transfer') }}</option> 
                            <option value="4" <?php if(isset($payment)){if($payment->method == '4'){echo "selected";}} ?> >{{ trans('app.Pay Slip') }}</option> 
                            <option value="5" <?php if(isset($payment)){if($payment->method == '5'){echo "selected";}} ?> >{{ trans('app.Credit Note') }}</option> 
                            <option value="6" <?php if(isset($payment)){if($payment->method == '6'){echo "selected";}} ?> >{{ trans('app.Other') }}</option> 
                          </select>
                        </div>
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Amount') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <input type="number" min="1" required class="form-control" id="amount" onkeyup="final_result();" name="amount"  value="@if(isset($payment)){{ $payment->amount }}@else{{ 0 }}@endif">
                        </div>
                      </div>
                    </div>
                    <?php /*
                     <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Reference') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <input type="text" class="form-control" name="refrence"  value="@if(isset($payment)){{ $payment->refrence }}@endif">
                        </div>
                      </div>
                    </div>
                    */ ?>
                     <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Bank charges') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <input type="text" class="form-control" name="bank_charge"  value="@if(isset($payment)){{ $payment->bank_charge }}@endif">
                        </div>
                      </div>
                    </div>
									</div>
								</div>
								<div class="col-12">
									<div class="card">
                    <input type="hidden" value="<?php if(isset($payment_details)){ echo count($payment_details); }else{ echo '0'; } ?>" id="total_invoice" name="total_invoice">
                    <?php if($type == 'received'){ ?>
                     <input type="hidden" id="payment_type" name="payment_type" value="0">
                    <?php }else{ ?>
                    <input type="hidden" id="payment_type" name="payment_type" value="1">
                    <?php } ?>
                  
										<div class="card-body table-responsive p-0">
											<table class="table table-hover" id="invoice_table">
												<tbody>
                         <tr style="background-color: #e9ecef;">
                           <th colspan="5">{{ trans('app.Unpaid Bills') }}</th>
                         </tr>
                         <tr style="background-color: #e9ecef;">
                          <th>{{ trans('app.Date') }}</th>
                           <th>{{ trans('app.Number') }}</th>
                           <th>{{ trans('app.Amount') }}</th>
                           <th>{{ trans('app.Amount Due') }}</th>
                           <th>{{ trans('app.Payment Value') }}</th>
                         </tr>
                      
                        <?php if(isset($payment_details))
                          {
                            $i = 1;
                        foreach ($payment_details as $key_pay) {?>
                          <tr>
                          <td><input type="hidden" value="<?php echo $key_pay['invoice_id']; ?>" id="invoice_id<?php echo $i; ?>" name="invoice_id<?php echo $i; ?>"><?php echo $key_pay['date']; ?></td>
                          <td><?php echo $key_pay['number']; ?></td>
                          <td><?php echo $key_pay['amount']; ?></td>
                          <td><?php echo $key_pay['amount_due']; ?></td>
                          <td><input type="number" onkeyup="final_result();" max="<?php echo $key_pay['amount_due']; ?>" min="0" class="form-control" value="<?php echo $key_pay['payment_val']; ?>" id="payment_add<?php echo $i; ?>" name="payment_add<?php echo $i; ?>"></td>
                        </tr>
                        <?php  $i ++;}}else{
                         ?>
                          <tr>
                        <?php if($type == 'received'){ ?>
                          <td colspan="5"><center>Please select a client.</center></td>
                        <?php }else{ ?>
                          <td colspan="5"><center>Please select a vendor.</center></td>
                        <?php } ?>
                        </tr>
                      <?php } ?>
                       

										</tbody></table>
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.card -->
							</div>
              <div class="col-12 row">
                <div class="col-6">
                  <label>{{ trans('app.Notes') }}:</label>
                  <textarea class="form-control" name="note" required><?php if(isset($payment)){ echo $payment->note; } ?></textarea>
                </div>
                <div class="col-6">
                  <p class="lead">{{ trans('app.Payment Details') }}</p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th><b>{{ trans('app.Amount paid') }}</b></th>
                        <td><input type="hidden" name="amount_paid" id="amount_paid" value="<?php if(isset($payment)){ echo $payment['amount']; } ?>"><div id="amount_paid_show"><?php if(isset($payment)){ echo $payment['amount']; }else{ echo '0'; } ?></div></td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Amount used for payments') }}</b></th>
                        <td><input type="hidden" name="amount_used" id="amount_used" value="<?php if(isset($payment)){ echo $payment['amount_used']; } ?>"><div id="amount_used_show"><?php if(isset($payment)){ echo $payment['amount_used']; } ?></div></td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Amount in excess') }}</b></th>
                        <td><input type="hidden" name="amount_excess" id="amount_excess" value="<?php if(isset($payment)){ echo $payment['amount_excess']; } ?>"><div id="amount_excess_show"><?php if(isset($payment)){ echo $payment['amount_excess']; } ?></div></td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="    bottom: 0;
		position: fixed;
		width: 100%;
		background-color: #ffffff;
		padding-top: 10px;
		padding-left: 10px;
		padding-bottom: 10px;">

		<button type="submit" name="submit" class="btn btn-primary">{{ trans('app.Submit') }}</button>
		<button type="button" name="back" onClick="javascript:history.go(-1);" class="btn btn-secondary"><i
			class="fa fa-chevron-circle-left"> &nbsp;</i>{{ trans('app.Back') }}
		</button>
	</div>
</form>
</section>
</div>
@endsection
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>

function client_chanage(id)
{
  $("#invoice_table").find("tr:gt(1)").remove();
  var bill_type = $("#bill_type").val();
	$.ajax({  
		url: "<?= route('clientpaymentinfo',app()->getLocale()) ?>",
		type: 'POST',
		data: {id:id,bill_type:bill_type,"_token":"<?= csrf_token() ?>"},
		success:function(data)  
		{
      var new_data = JSON.parse(data);
      $("#total_invoice").val(new_data.total_invoice);
      $('#invoice_table tr:last').after(new_data.tabl_info);
		}
	});
}

$(function () {
	$(".select2").select2();
});

function change_product(id)
{
   var client_id = $('#client_id :selected').val();
  if(client_id == '')
  {
    swal("Please select Client first.", "", "error");
    $('#client_id').focus();
  }
  else
  {
  	$.ajax({  
  		url: "<?= route('invoicesproductinfo',app()->getLocale()) ?>",
  		type: 'POST',
  		data: {id:id,"_token":"<?= csrf_token() ?>"},
  		success:function(data)  
  		{
  			var new_data = JSON.parse(data);
  			$("#read_hsn").val(new_data.hsn);
        $("#read_hsn_display").html(new_data.hsn);
  			$("#read_unit").val(new_data.unit);
  			$("#read_price").val(new_data.sale_price);
  			$("#read_sgst").val('0');
  			$("#read_cgst").val('0');
  			$("#read_igst").val('0');
  			$("#read_discount").val('0');
  		}
  	});
  }
}

function final_result()
{
  var amount = $("#amount").val();
  var total_invoice = $("#total_invoice").val();
  var payment_add = 0;
  for (var i = 1; i <= total_invoice; i++) {
    payment_add += parseFloat($("#payment_add"+i).val());
  }

  var amount_excess = amount - payment_add;

  $("#amount_used").val(parseFloat(payment_add).toFixed(2));
  $("#amount_paid").val(parseFloat(amount).toFixed(2));
  $("#amount_excess").val(parseFloat(amount_excess).toFixed(2));

  $("#amount_used_show").html(parseFloat(payment_add).toFixed(2));
  $("#amount_paid_show").html(parseFloat(amount).toFixed(2));
  $("#amount_excess_show").html(parseFloat(amount_excess).toFixed(2));
}
</script>


