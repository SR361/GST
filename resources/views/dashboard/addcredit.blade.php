@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
  <div class="content-header">
   <div class="container-fluid">
    <div class="row mb-2">
     <div class="col-sm-6">
      <h1 class="m-0 text-dark">{{ trans('app.Add Credit') }}</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
       <li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
       <li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/credits') }}">{{ trans('app.Credit List') }}</a></li>
       <li class="breadcrumb-item active">{{ trans('app.Add Credit') }}</li>
     </ol>
   </div>
 </div>
</div>
</div>

<section class="content">
	<div class="col-md-12">
		<div class="col-md-12">
			@if(isset($credit))        
			<form action="{{ route('credits.update',[app()->getLocale(),$credit->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" value="{{ $credit->id }}" name="id"> 
				@method('PUT')      
				@else
				<form action="{{ route('credits.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data" autocomplete="off">     
					@endif
					@csrf
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
                   <div class="form-group input-group">
                    <div class="col-md-2">
                     <label>{{ trans('app.Client') }}</label>
                   </div>
                   <?php if(isset($credit)){ ?>
                    <input type="hidden" value="<?php echo $credit->client_id; ?>" name="client_id">
                   <?php } ?>
                   <div class="col-md-4">
                     <select class="form-control select2" required  name="client_id"  id="client_id" onchange="client_change(this.value)" <?php if(isset($credit)){ echo "disabled";} ?>>
                      <option selected disabled value="">{{ trans('app.Select One') }}</option>
                      @foreach($client_data as $client_val)
                      <option value="{{ $client_val->id }}" <?php if(isset($credit)){if($credit->client_id == $client_val->id){echo "selected";}} ?> >{{ $client_val->company_name }}-{{ $client_val->contact_person }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
								</div>
                <div class="col-md-12">
                   <div class="form-group input-group">
                    <div class="col-md-2">
                     <label>{{ trans('app.Invoice Number') }}</label>
                   </div>
                   <?php if(isset($credit)){ ?>
                    <input type="hidden" value="<?php echo $credit->invoice_id; ?>" name="invoice_id">
                   <?php } ?>
                   <div class="col-md-4">
                     <select class="form-control js-example-data-array" required  name="invoice_id"  id="invoice_id" onchange="invoice_change(this.value)" disabled>
                      <option selected disabled value="">{{ trans('app.Select One') }}</option>
                    </select>
                  </div>
                </div>
                </div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Credit Number') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="text" required class="form-control" name="credit_number"  value="<?php if(isset($credit)){ echo $credit['credit_number']; } ?>">
												</div>
											</div>
										</div>
                    <div class="col-md-4">
                      <div class="form-group input-group">
                        <div class="col-md-4 m-t-5">
                          <label>{{ trans('app.Date') }}</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <input type="text" required id="date"  class="form-control datepicker" name="date"  value="<?php if(isset($credit)){ echo date('d-m-Y',strtotime($credit['date'])); } ?>">
                        </div>
                      </div>
                    </div>
									</div>
								</div>
								<div class="col-12">
									<div class="card">
                    <input type="hidden" value="<?php if(isset($credit_product)){ echo count($credit_product); }else{ echo '0'; } ?>" id="total_credit_product" name="total_credit_product">
                   
										<div class="card-body table-responsive p-0">
											<table class="table table-hover" id="credit_table">
												<tbody>
                         <tr style="background-color: #e9ecef;">
                           <th colspan="6">{{ trans('app.Credit Bill Products') }}</th>
                         </tr>
                         <tr style="background-color: #e9ecef;">
                           <th>{{ trans('app.Name') }}</th>
                           <th>{{ trans('app.Description') }}</th>
                           <th>{{ trans('app.Amount') }}</th>
                           <th>{{ trans('app.QTY') }}</th>
                           <th>{{ trans('app.Credit QTY') }}</th>
                           <th>{{ trans('app.Credit Amount') }}</th>
                         </tr>
                         <?php if(isset($credit_product))
                         {
                          $i = 1;
                          foreach ($credit_product as $key) {?>
                            <tr>
                              <td><input type="hidden" value="<?php echo $key['invoice_product_id']; ?>" id="invoice_product_id<?php echo $i; ?>" name="invoice_product_id<?php echo $i; ?>"><?php echo $key['product_name']; ?></td>

                              <td><?php echo $key['product_description']; ?></td>

                              <td><input type="hidden" value="<?php echo $key['product_total_amount']; ?>" id="total_amount<?php echo $i; ?>" name="total_amount<?php echo $i; ?>" ><?php echo $key['product_total_amount']; ?></td>

                              <td><input type="hidden" value="<?php echo $key['total_qty']; ?>" id="total_qty<?php echo $i; ?>" name="total_qty<?php echo $i; ?>" ><?php echo $key['total_qty']; ?></td>

                              <td><input type="number" onkeyup="final_result();" max="<?php echo $key['total_qty']; ?>" min="0" class="form-control" value="<?php echo $key['qty']; ?>" id="total_return_qty<?php echo $i; ?>" name="total_return_qty<?php echo $i; ?>"></td>


                              <td><input type="hidden" id="total_credit<?php echo $i; ?>" name="total_credit<?php echo $i; ?>" value="<?php echo $key['total_amount']; ?>" ><p id="showtotal_credit<?php echo $i; ?>"><?php echo $key['total_amount']; ?></p></td>
                            </tr>
                            <?php  $i ++;}}else{
                             ?>
                           <?php } ?>
										</tbody></table>
									</div>
								</div>
							</div>
              <div class="col-12 row">
                <div class="col-6">
                  <label>{{ trans('app.Reason') }}:</label>
                  <textarea class="form-control" name="reason" required><?php if(isset($credit)){ echo $credit->reason; } ?></textarea>
                </div>
                <div class="col-6">
                  <p class="lead">{{ trans('app.Credit Details') }}</p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th><b>{{ trans('app.Total Credit') }}</b></th>
                        <td><input type="hidden" name="total_amount" id="total_amount" value="<?php if(isset($credit)){ echo $credit['total_amount']; } ?>"><div id="amount_paid_show"><?php if(isset($credit)){ echo $credit['total_amount']; }else{ echo '0'; } ?></div></td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Charges') }}</b></th>
                        <td><input type="number" onkeyup="final_result();" class="form-control" min='0' name="charge" id="charge" value="<?php if(isset($credit)){ echo $credit['charge']; }else{ echo '0'; } ?>"></td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Final Credit Amount') }}</b></th>
                        <td><input type="hidden" name="total_amount_credit" id="total_amount_credit" value="<?php if(isset($credit)){ echo $credit['total_amount_credit']; } ?>"><div id="amount_excess_show"><?php if(isset($credit)){ echo $credit['total_amount_credit']; }else{ echo '0'; } ?></div></td>
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

		<button type="submit" name="submit" id="submit" <?php if(isset($credit)){ echo ''; }else{ echo "disabled";} ?> class="btn btn-primary">{{ trans('app.Submit') }}</button>
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

function client_change(id)
{
	$.ajax({  
		url: "<?= route('clientinvoiceinfo',app()->getLocale()) ?>",
		type: 'POST',
		data: {id:id,"_token":"<?= csrf_token() ?>"},
		success:function(data)  
		{
      var new_data = JSON.parse(data);
      $('.js-example-data-array').find('option').remove().end().append('<option value="" disabled selected>Select One</option>');
      if(new_data.length === 0)
      {
        $("#invoice_id").select2({
          data: new_data
        })
        $("#invoice_id").prop('disabled',true);
        $("#submit").prop('disabled',true);
        swal("Client don't have any invoice.", "", "error");
      }
      else
      {
        $("#invoice_id").prop('disabled',false);
        $("#submit").prop('disabled',false);
        $("#invoice_id").select2({
          data: new_data
        })
      }
		}
	});
}

function invoice_change(id)
{
  $("#credit_table").find("tr:gt(1)").remove();
  $.ajax({  
    url: "<?= route('invoiceproductinfo',app()->getLocale()) ?>",
    type: 'POST',
    data: {id:id,"_token":"<?= csrf_token() ?>"},
    success:function(data)  
    {
      var new_data = JSON.parse(data);
      $("#total_credit_product").val(new_data.total_invoice_product);
      $('#credit_table tr:last').after(new_data.tabl_info);
    }
  });
}

$(function () {
	$(".select2").select2();
});

function final_result()
{
  var total_credit_product = $("#total_credit_product").val();
  var amount_paid_show = 0;
  for (var i = 1; i <= total_credit_product; i++) {
    var total_amount = parseInt($("#total_amount"+i).val());
    var total_qty = $("#total_qty"+i).val();
    var per_qty_price = parseFloat(total_amount/total_qty).toFixed(2);
    var total_return_qty = $("#total_return_qty"+i).val();
    var credit = parseFloat(total_return_qty*per_qty_price).toFixed(2);
    $("#total_credit"+i).val(credit);
    $("#showtotal_credit"+i).html(credit);
    amount_paid_show += parseInt(credit);
  }

  $("#amount_paid_show").html(parseFloat(amount_paid_show).toFixed(2));
  $("#total_amount").val(parseFloat(amount_paid_show).toFixed(2));
  var charge = $("#charge").val();
  var amount_with_charge = parseInt(amount_paid_show) - parseInt(charge);
  $("#amount_excess_show").html(parseFloat(amount_with_charge).toFixed(2));
  $("#total_amount_credit").val(parseFloat(amount_with_charge).toFixed(2));
}
</script>


