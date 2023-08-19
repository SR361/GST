@extends('layouts.master') 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ trans('app.Payment') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ trans('app.Home') }}</a></li>
              <li class="breadcrumb-item active">{{ trans('app.Payment') }}</li>
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
                    <?php if(isset($payment))
                    {
                      if($payment->payment_type == '1')
                      {
                        $pay = 'Made';
                      }else{
                        $pay = 'Received';
                      }
                    }
                    ?>
                    <i class="fa fa-book"></i>Payment <?php echo $pay; ?>.
                    <small class="float-right">Date: <?php if(isset($payment)){ echo $payment->date; } ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong><?php if(isset($user)){ echo $user->company_name; } ?></strong><br>
                    <?php if(isset($user)){ echo $user->address; } ?><br>
                    Phone: <?php if(isset($user)){ echo $user->phone; } ?><br>
                    Email: <?php if(isset($user)){ echo $user->email; } ?>
                  </address>
                </div>
                <?php if(isset($payment))
                  { 
                    $client_sel_data = \App\Tbl_client::where(['id' => $payment->client_id])->first();
                  }
                  ?>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php if(isset($payment)){ echo $client_sel_data->company_name; } ?></strong><br>
                    <?php if(isset($payment)){ echo $client_sel_data->address; } ?><br>
                    Phone: <?php if(isset($payment)){ echo $client_sel_data->phone; } ?><br>
                    Email: <?php if(isset($payment)){ echo $client_sel_data->email; } ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Payment No</b> #<?php if(isset($payment)){ echo $payment->number; } ?><br>
                  <b>Date:</b> <?php if(isset($payment)){ echo $payment->date; } ?><br>
                  <b>Method:</b> <?php if(isset($payment)){ echo $payment->method; } ?><br>
                  <b>Bank Charges:</b> <?php if(isset($payment)){ echo $payment->bank_charge; } ?>
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
                        <th>{{ trans('app.Invoice Number') }}</th>
                        <th>{{ trans('app.Date') }}</th>
                        <th>{{ trans('app.Amount') }}</th>
                        <th>{{ trans('app.Pay amount') }}</th>
                      </tr>
                      <?php 
                      if(isset($payment_data)){
                        $i = '1';
                        foreach ($payment_data as $key) {
                          ?>
                          <tr id="check_remove_product1">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $key['invoice_number']; ?></td>
                            <td><?php echo $key['date']; ?></td>
                            <td><?php echo $key['amount']; ?></td>
                            <td><?php echo $key['payment_val']; ?></td>
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
                    <?php if(isset($payment)){ echo $payment->note; } ?>
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">{{ trans('app.Payment Details') }}</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th><b>{{ trans('app.Amount paid') }}</b></th>
                        <td>@if(isset($payment)){{ $payment->amount }}@endif</td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Amount used for payments') }}</b></th>
                        <td>@if(isset($payment)){{ $payment->amount_used }}@endif</div></td>
                      </tr>

                      <tr>
                        <th><b>{{ trans('app.Amount in excess') }}</b></th>
                        <td>@if(isset($payment)){{ $payment->amount_excess }}@endif</div></td>
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
                  <a href="#" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                  </a>
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


