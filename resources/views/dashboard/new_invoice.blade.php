<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="{{ asset('/public/dist/plugins/font-awesome/css/font-awesome.min.css') }}">

  
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <link rel="stylesheet" href="{{ asset('/public/dist/css/adminlte.min.css') }}">
  
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body> 
  <div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <div class="invoice p-3 mb-3">
               
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fa fa-book"></i>Invoice.
                    <small class="float-right">Date: @if(isset($invoice)) {{ $invoice->invoice_date }} @endif</small>
                </h4>
            </div>

        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>@if(isset($user)) {{ $user->company_name }} @endif</strong><br>
                @if(isset($user)) {{ $user->address }} @endif<br>
                Phone: @if(isset($user)) {{ $user->phone }} @endif<br>
                Email: @if(isset($user)) {{ $user->email }} @endif
            </address>
        </div>

        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>@if(isset($invoice)) {{ $client_sel_data->company_name }} @endif</strong><br>
            @if(isset($invoice)) {{ $client_sel_data->address }} @endif<br>
            Phone: @if(isset($invoice)) {{ $client_sel_data->phone }} @endif<br>
            Email: @if(isset($invoice)) {{ $client_sel_data->email }} @endif
        </address>
    </div>

    <div class="col-sm-4 invoice-col">
      <b>Invoice</b> #@if(isset($invoice)) {{ $invoice->invoice_number }} @endif<br>
      <b>Payment Due:</b> @if(isset($invoice)) {{ $invoice->due_date }} @endif<br>
      <b>PO No:</b> @if(isset($invoice)) {{ $invoice->po_no }} @endif<br>
      <b>Place Supply:</b> @if(isset($invoice)) {{ $invoice->place_supply }} @endif
  </div>

</div>



<div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>{{ trans('app.No') }}</th>
            <th>{{ trans('app.Item Name') }}</th>
            <th>{{ trans('app.HSN/SAC') }}</th>
            <th>{{ trans('app.Unit') }}</th>
            <th>{{ trans('app.QTY') }}</th>
            <th>{{ trans('app.Price') }}</th>
            <th>{{ trans('app.Discount') }} (%)</th>
            <th style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>" >{{ trans('app.CGST') }}</th>
            <th style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">{{ trans('app.SGST') }}</th>
            <th style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">{{ trans('app.IGST') }}</th>
            <th>{{ trans('app.Total') }}</th>
        </tr>

        <?php 
        if(isset($invoice_product)){
            $i = '1';
            foreach ($invoice_product as $key) {
              ?>
              <tr id="check_remove_product1">
                <td>{{ $i }}</td>
                <td>{{ $key->product_name }}</td>
                <td>{{ $key->hsn }}</td>
                <td>{{ $key->unit }}</td>
                <td>{{ $key->qty }}</td>
                <td>{{ $key->price }}</td>
                <td>{{ $key->discount }}</td>
                <td style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">{{ $key->cgst }}</td>

                <td style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">{{ $key->sgst }}</td>


                <td style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">{{ $key->igst }}</td>
                <td>{{ $key->total_amount }}</td>
            </tr>
            <?php $i++;}} ?>



        </tbody>
    </table>
</div>

</div>


<div class="row">

    <div class="col-6">
      <p class="lead">{{ trans('app.Notes') }}:</p>
      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        <?php if(isset($invoice)){ echo $invoice->note; } ?>
    </p>
</div>

<div class="col-6">
  <p class="lead">{{ trans('app.Total Details') }}</p>

  <div class="table-responsive">
    <table class="table">
      <tbody>
          <tr>
            <th><b>{{ trans('app.Total') }}</b></th>
            <td>@if(isset($invoice)){{ $invoice->total_amount }}@endif</td>
        </tr>

        <tr style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">
            <th><b>{{ trans('app.CGST') }}</b></th>
            <td>@if(isset($invoice)){{ $invoice->total_cgst }}@endif</td>
        </tr>

        <tr  style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">
            <th><b>{{ trans('app.SGST') }}</b></th>
            <td>@if(isset($invoice)){{ $invoice->total_sgst }}@endif</td>
        </tr>

        <tr style="display:<?php if(isset($invoice)){ if($invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">
            <th><b>{{ trans('app.IGST') }}</b></th>
            <td>@if(isset($invoice)){{ $invoice->total_igst }}@endif</td>
        </tr>

        <tr>
            <th>@if(isset($invoice)){{ $invoice->other_charge_type }}@endif</th>
            <td>@if(isset($invoice)){{ $invoice->charge_amount }}@endif</td>
        </tr>
        <tr>
            <th><b>{{ trans('app.Net Amount') }}</b></th>
            <td>@if(isset($invoice)){{ $invoice->net_amount }}@endif</div></td>
        </tr>
    </tbody></table>
</div>
</div>

</div>

</div>
</div>
</div>
</section>

</div>
</body>
</html>
