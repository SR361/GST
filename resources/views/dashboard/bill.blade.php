@extends('layouts.master') 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ trans('app.Bill') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ trans('app.Home') }}</a></li>
              <li class="breadcrumb-item active">{{ trans('app.Bill') }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fa fa-book"></i>Bill.
                    <small class="float-right">Date: <?php if(isset($invoice)){ echo $invoice->invoice_date; } ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <?php if(isset($invoice))
                  { 
                    $client_sel_data = \App\Tbl_client::where(['id' => $invoice->client_id])->first();
                  }
                  ?>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php if(isset($invoice)){ echo $client_sel_data->company_name; } ?></strong><br>
                    <?php if(isset($invoice)){ echo $client_sel_data->address; } ?><br>
                    Phone: <?php if(isset($invoice)){ echo $client_sel_data->phone; } ?><br>
                    Email: <?php if(isset($invoice)){ echo $client_sel_data->email; } ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice</b> #<?php if(isset($invoice)){ echo $invoice->invoice_number; } ?><br>
                  <b>Payment Due:</b> <?php if(isset($invoice)){ echo $invoice->due_date; } ?><br>
                  <b>PO No:</b> <?php if(isset($invoice)){ echo $invoice->po_no; } ?><br>
                  <b>Place Supply:</b> <?php if(isset($invoice)){ echo $invoice->place_supply; } ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->


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
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">{{ trans('app.Notes') }}:</p>
                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    <?php if(isset($invoice)){ echo $invoice->note; } ?>
                  </p>
                </div>
                <!-- /.col -->
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
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <div onclick="window.print();return false;" class="btn btn-default"><i class="fa fa-print"></i> Print</div>
                  <button type="button" class="btn btn-success float-right"><i class="fa fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>
</script>


