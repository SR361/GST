@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ trans('app.Dashboard') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('app.Home') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('app.Dashboard') }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $total_product }}</h3>
              <h2>{{ trans('app.Products') }}</h2>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('products.index',app()->getLocale()) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $total_client }}</h3>
              <h2>{{ trans('app.Clients') }}</h2>
            </div>
            <div class="icon">
              <i class="fas fa-user"></i>
            </div>
            <a href="{{ route('clients.index',app()->getLocale()) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $total_vendor }}</h3>
              <h2>{{ trans('app.Vendor') }}</h2>
            </div>
            <div class="icon">
              <i class="fas fa-user"></i>
            </div>
            <a href="{{ route('clients.index',app()->getLocale()) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-13 row">
        <div class="col-md-4">
          <div class="card" style="border: 1px solid #babac5;">
            <div class="card-header" style="padding: 12px 8px;">
              <h3 class="card-title" ><b>{{ trans('app.SELLINGS') }}</b></h3>
              <div class="card-tools">
                <a href="{{ route('invoices.create',app()->getLocale()) }}" class="btn btn-sm btn-primary">{{ trans('app.Add Invoice') }}</a>
                <button type="button" class="btn btn-tool" data-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($invoice as $row)
                <li class="item">
                  <a href="{{ route('invoices.edit',[app()->getLocale(),$row->id]) }}">
                  <label style="margin-bottom: 0px;">{{ $row->invoice_number }}</label>
                  </a><div class="product-info"><a href="http://localhost/ankit/CART2/en/admin/orders/13/edit">
                    </a><a style="color: #007bff;" class="product-title">
                      <span class="badge badge-success float-right">₹{{ $row->net_amount  }}</span>
                    </a>
                  </div>
                  <span class="product-description">
                    <?php $client = App\Tbl_client::where('id',$row->client_id)->first()->company_name; ?>
                    {{ $client }}
                  </span> 
                  
                </li>
                  @endforeach
                </ul>
              </div>
              <div class="card-footer text-center">
                <a href="{{ route('invoices.index',app()->getLocale()) }}" class="uppercase">{{ trans('app.View All Sellings') }}</a>                
              </div>
            </div>
          </div>
          <div class="col-md-4">
          <div class="card" style="border: 1px solid #babac5;">
            <div class="card-header" style="padding: 12px 8px;">
              <h3 class="card-title"><b>{{ trans('app.PURCHASE') }}</b></h3>
              <div class="card-tools">
                <a href="{{ route('purchasebills.create',app()->getLocale()) }}" class="btn btn-sm btn-primary">{{ trans('app.Add Purchase') }}</a>
                <button type="button" class="btn btn-tool" data-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($purchase as $row)
                <li class="item">
                  <a href="{{ route('purchasebills.edit',[app()->getLocale(),$row->id]) }}">
                  <label style="margin-bottom: 0px;">{{ $row->invoice_number }}</label>
                  </a><div class="product-info"><a href="http://localhost/ankit/CART2/en/admin/orders/13/edit">
                    </a><a style="color: #007bff;" class="product-title">
                      <span class="badge badge-success float-right">₹{{ $row->net_amount  }}</span>
                    </a>
                  </div>
                  <span class="product-description">
                    <?php $client = App\Tbl_client::where('id',$row->client_id)->first()->company_name; ?>
                    {{ $client }}
                  </span> 
                  
                </li>
                  @endforeach
                </ul>
              </div>
              <div class="card-footer text-center">
                <a href="{{ route('purchasebills.index',app()->getLocale()) }}" class="uppercase">{{ trans('app.View All Purchase') }}</a>                
              </div>
            </div>
          </div>
          <div class="col-md-4">
          <div class="card" style="border: 1px solid #babac5;">
            <div class="card-header" style="padding: 12px 8px;">
              <h3 class="card-title"><b>{{ trans('app.PAYMENT REMINDER') }}</b></h3>
              <div class="card-tools">
                <!-- <span class="badge badge-danger">New Posts</span> -->
                <button type="button" class="btn btn-tool" data-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($payment as $row)
                <li class="item">
                  <a href="{{ route('invoices.edit',[app()->getLocale(),$row->id]) }}">
                  <label style="margin-bottom: 0px;">{{ $row->invoice_number }}</label>
                  </a><div class="product-info"><a href="http://localhost/ankit/CART2/en/admin/orders/13/edit">
                    </a><a style="color: #007bff;" class="product-title">
                      <span class="badge badge-success float-right">₹{{ $row->net_amount  }}</span>
                    </a>
                  </div>
                  <span class="product-description">
                    <?php $client = App\Tbl_client::where('id',$row->client_id)->first()->company_name; ?>
                    {{ $client }}
                    <!-- <span style="color: red;">{{ $row->due_date }}</span> -->
                    
                  </span> 
                  
                </li>
                  @endforeach
                </ul>
              </div>
              <div class="card-footer text-center">
                <a href="{{ route('invoices.index',app()->getLocale()) }}" class="uppercase">{{ trans('app.View All Sellings') }}</a>                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @php echo $locale = session()->get('locale'); @endphp
</div>
@endsection
