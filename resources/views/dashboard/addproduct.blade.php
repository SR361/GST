@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{ trans('app.Add Product') }}</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/products') }}">{{ trans('app.Product List') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('app.Add Product') }}</li>
					</ol>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>

	<section class="content">
		<div class="col-md-12 row">
			<div class="col-md-6">
				@if(isset($Tbl_product))        
				<form action="{{ route('products.update',[app()->getLocale(),$Tbl_product->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data">
				<input type="hidden" value="{{ $Tbl_product->id }}" name="id"> 
				 @method('PUT')      
					@else
					<form action="{{ route('products.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data">     
						@endif
						@csrf
				
					<div class="card">
						<div class="card-body">
							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Name') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="name"  value="@if(isset($Tbl_product)){{ $Tbl_product->name }}@else{{old('name')}}@endif" style="border-color: @if ($errors->get('name')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('name'))
									@foreach ($errors->get('name') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Description') }}<span style="color: red;">*</span></label>
								<textarea class="form-control" name="description" style="border-color: @if ($errors->get('description')){{ '#e74c3c' }}@endif">@if(isset($Tbl_product)){{ $Tbl_product->description }}@else{{old('description')}}@endif</textarea>
								<div class="error_style_msg">@if ($errors->get('description'))
									@foreach ($errors->get('description') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Quantity') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="quantity"  value="@if(isset($Tbl_product)){{ $Tbl_product->quantity }}@else{{old('quantity')}}@endif" style="border-color: @if ($errors->get('quantity')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('quantity'))
									@foreach ($errors->get('quantity') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<!-- <div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Unit') }}</label>
								<input type="text"  class="form-control" name="unit"  value="@if(isset($Tbl_product)){{ $Tbl_product->unit }}@else{{old('unit')}}@endif" style="border-color: @if ($errors->get('unit')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('unit'))
									@foreach ($errors->get('unit') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Tax') }}</label>
								<input type="text"  class="form-control" name="tax"  value="@if(isset($Tbl_product)){{ $Tbl_product->tax }}@else{{old('tax')}}@endif" style="border-color: @if ($errors->get('tax')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('tax'))
									@foreach ($errors->get('tax') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div> -->

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.HSN') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="hsn"  value="@if(isset($Tbl_product)){{ $Tbl_product->hsn }}@else{{old('hsn')}}@endif" style="border-color: @if ($errors->get('hsn')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('hsn'))
									@foreach ($errors->get('hsn') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

						</div>
					</div>
			</div>
			<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<center><strong>{{ trans('app.Sale') }}</strong></center>
							<div style="border: 1px solid #ced4da;padding: 10px;">
							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Sale Price') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="sale_price"  value="@if(isset($Tbl_product)){{ $Tbl_product->sale_price }}@else{{old('sale_price')}}@endif" style="border-color: @if ($errors->get('sale_price')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('sale_price'))
									@foreach ($errors->get('sale_price') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group row">
								<div class="col-md-4"><b>{{ trans('app.Sale Currency') }}</b><span style="color: red;">*</span></div>
								<div class="col-md-8">
								<select class="form-control select2"  name="sale_currency" style="text-align: right;">
									<option value="INR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'INR'){echo "selected";}}elseif(old('sale_currency') == 'INR'){echo "selected";}?> >India Rupees</option>

									<option value="USD" <?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'USD'){echo "selected";}}elseif(old('sale_currency') == 'USD'){echo "selected";}?>>United States Dollars</option>

									<option value="EUR" <?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'EUR'){echo "selected";}}elseif(old('sale_currency') == 'EUR'){echo "selected";}?> >Euro</option>

									<option value="GBP" <?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'GBP'){echo "selected";}}elseif(old('sale_currency') == 'GBP'){echo "selected";}?> >United Kingdom Pounds</option>

									<option value="DZD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'DZD'){echo "selected";}}elseif(old('sale_currency') == 'DZD'){echo "selected";}?> >Algeria Dinars</option>

									<option value="ARP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ARP'){echo "selected";}}elseif(old('sale_currency') == 'ARP'){echo "selected";}?> >Argentina Pesos</option>

									<option value="AUD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'AUD'){echo "selected";}}elseif(old('sale_currency') == 'AUD'){echo "selected";}?> >Australia Dollars</option>

									<option value="ATS"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ATS'){echo "selected";}}elseif(old('sale_currency') == 'ATS'){echo "selected";}?> >Austria Schillings</option>

									<option value="BSD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'EUR'){echo "selected";}}elseif(old('sale_currency') == 'EUR'){echo "selected";}?> >Bahamas Dollars</option>

									<option value="BBD" <?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'BBD'){echo "selected";}}elseif(old('sale_currency') == 'BBD'){echo "selected";}?> >Barbados Dollars</option>

									<option value="BEF"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'BEF'){echo "selected";}}elseif(old('sale_currency') == 'BEF'){echo "selected";}?> >Belgium Francs</option>

									<option value="BMD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'BMD'){echo "selected";}}elseif(old('sale_currency') == 'BMD'){echo "selected";}?> >Bermuda Dollars</option>

									<option value="BRR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'BRR'){echo "selected";}}elseif(old('sale_currency') == 'BRR'){echo "selected";}?> >Brazil Real</option>

									<option value="BGL"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'BGL'){echo "selected";}}elseif(old('sale_currency') == 'BGL'){echo "selected";}?> >Bulgaria Lev</option>

									<option value="CAD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CAD'){echo "selected";}}elseif(old('sale_currency') == 'CAD'){echo "selected";}?> >Canada Dollars</option>

									<option value="CLP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CLP'){echo "selected";}}elseif(old('sale_currency') == 'CLP'){echo "selected";}?> >Chile Pesos</option>

									<option value="CNY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CNY'){echo "selected";}}elseif(old('sale_currency') == 'CNY'){echo "selected";}?> >China Yuan Renmimbi</option>

									<option value="CYP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CYP'){echo "selected";}}elseif(old('sale_currency') == 'CYP'){echo "selected";}?> >Cyprus Pounds</option>

									<option value="CSK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CSK'){echo "selected";}}elseif(old('sale_currency') == 'CSK'){echo "selected";}?> >Czech Republic Koruna</option>

									<option value="DKK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'DKK'){echo "selected";}}elseif(old('sale_currency') == 'DKK'){echo "selected";}?> >Denmark Kroner</option>

									<option value="NLG"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'NLG'){echo "selected";}}elseif(old('sale_currency') == 'NLG'){echo "selected";}?> >Dutch Guilders</option>
									<option value="XCD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XCD'){echo "selected";}}elseif(old('sale_currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="EGP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'EGP'){echo "selected";}}elseif(old('sale_currency') == 'EGP'){echo "selected";}?> >Egypt Pounds</option>
									<option value="FJD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'FJD'){echo "selected";}}elseif(old('sale_currency') == 'FJD'){echo "selected";}?> >Fiji Dollars</option>
									<option value="FIM"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'FIM'){echo "selected";}}elseif(old('sale_currency') == 'FIM'){echo "selected";}?> >Finland Markka</option>
									<option value="FRF"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'FRF'){echo "selected";}}elseif(old('sale_currency') == 'FRF'){echo "selected";}?> >France Francs</option>
									<option value="DEM"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'DEM'){echo "selected";}}elseif(old('sale_currency') == 'DEM'){echo "selected";}?> >Germany Deutsche Marks</option>
									<option value="XAU"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XAU'){echo "selected";}}elseif(old('sale_currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="GRD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'GRD'){echo "selected";}}elseif(old('sale_currency') == 'GRD'){echo "selected";}?> >Greece Drachmas</option>
									<option value="HKD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'HKD'){echo "selected";}}elseif(old('sale_currency') == 'HKD'){echo "selected";}?> >Hong Kong Dollars</option>
									<option value="HUF"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'HUF'){echo "selected";}}elseif(old('sale_currency') == 'HUF'){echo "selected";}?> >Hungary Forint</option>
									<option value="ISK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ISK'){echo "selected";}}elseif(old('sale_currency') == 'ISK'){echo "selected";}?> >Iceland Krona</option>
									
									<option value="IDR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'IDR'){echo "selected";}}elseif(old('sale_currency') == 'IDR'){echo "selected";}?> >Indonesia Rupiah</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JPY'){echo "selected";}}elseif(old('sale_currency') == 'JPY'){echo "selected";}?> >Ireland Punt</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JPY'){echo "selected";}}elseif(old('sale_currency') == 'JPY'){echo "selected";}?> >Israel New Shekels</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JPY'){echo "selected";}}elseif(old('sale_currency') == 'JPY'){echo "selected";}?> >Italy Lira</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JPY'){echo "selected";}}elseif(old('sale_currency') == 'JPY'){echo "selected";}?> >Jamaica Dollars</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JPY'){echo "selected";}}elseif(old('sale_currency') == 'JPY'){echo "selected";}?> >Japan Yen</option>
									<option value="JOD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'JOD'){echo "selected";}}elseif(old('sale_currency') == 'JOD'){echo "selected";}?> >Jordan Dinar</option>
									<option value="KRW"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'KRW'){echo "selected";}}elseif(old('sale_currency') == 'KRW'){echo "selected";}?> >Korea (South) Won</option>
									<option value="LBP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'LBP'){echo "selected";}}elseif(old('sale_currency') == 'LBP'){echo "selected";}?> >Lebanon Pounds</option>
									<option value="LUF"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'LUF'){echo "selected";}}elseif(old('sale_currency') == 'LUF'){echo "selected";}?> >Luxembourg Francs</option>
									<option value="MYR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'MYR'){echo "selected";}}elseif(old('sale_currency') == 'MYR'){echo "selected";}?> >Malaysia Ringgit</option>
									<option value="MXP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'MXP'){echo "selected";}}elseif(old('sale_currency') == 'MXP'){echo "selected";}?> >Mexico Pesos</option>
									<option value="NLG"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'NLG'){echo "selected";}}elseif(old('sale_currency') == 'NLG'){echo "selected";}?> >Netherlands Guilders</option>
									<option value="NZD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'NZD'){echo "selected";}}elseif(old('sale_currency') == 'NZD'){echo "selected";}?> >New Zealand Dollars</option>
									<option value="NOK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'NOK'){echo "selected";}}elseif(old('sale_currency') == 'NOK'){echo "selected";}?> >Norway Kroner</option>
									<option value="PKR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'PKR'){echo "selected";}}elseif(old('sale_currency') == 'PKR'){echo "selected";}?> >Pakistan Rupees</option>
									<option value="XPD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XPD'){echo "selected";}}elseif(old('sale_currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="PHP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'PHP'){echo "selected";}}elseif(old('sale_currency') == 'PHP'){echo "selected";}?> >Philippines Pesos</option>
									<option value="XPT"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XPT'){echo "selected";}}elseif(old('sale_currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
									<option value="PLZ"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'PLZ'){echo "selected";}}elseif(old('sale_currency') == 'PLZ'){echo "selected";}?> >Poland Zloty</option>
									<option value="PTE"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'PTE'){echo "selected";}}elseif(old('sale_currency') == 'PTE'){echo "selected";}?> >Portugal Escudo</option>
									<option value="ROL"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ROL'){echo "selected";}}elseif(old('sale_currency') == 'ROL'){echo "selected";}?> >Romania Leu</option>
									<option value="RUR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'RUR'){echo "selected";}}elseif(old('sale_currency') == 'RUR'){echo "selected";}?> >Russia Rubles</option>
									<option value="SAR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'SAR'){echo "selected";}}elseif(old('sale_currency') == 'SAR'){echo "selected";}?> >Saudi Arabia Riyal</option>
									<option value="XAG"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XAG'){echo "selected";}}elseif(old('sale_currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="SGD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'SGD'){echo "selected";}}elseif(old('sale_currency') == 'SGD'){echo "selected";}?> >Singapore Dollars</option>
									<option value="SKK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'SKK'){echo "selected";}}elseif(old('sale_currency') == 'SKK'){echo "selected";}?> >Slovakia Koruna</option>
									<option value="ZAR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ZAR'){echo "selected";}}elseif(old('sale_currency') == 'ZAR'){echo "selected";}?> >South Africa Rand</option>
									<option value="KRW"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'KRW'){echo "selected";}}elseif(old('sale_currency') == 'KRW'){echo "selected";}?> >South Korea Won</option>
									<option value="ESP"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ESP'){echo "selected";}}elseif(old('sale_currency') == 'ESP'){echo "selected";}?> >Spain Pesetas</option>
									<option value="XDR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XDR'){echo "selected";}}elseif(old('sale_currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="SDD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'SDD'){echo "selected";}}elseif(old('sale_currency') == 'SDD'){echo "selected";}?> >Sudan Dinar</option>
									<option value="SEK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'SEK'){echo "selected";}}elseif(old('sale_currency') == 'SEK'){echo "selected";}?> >Sweden Krona</option>
									<option value="CHF"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'CHF'){echo "selected";}}elseif(old('sale_currency') == 'CHF'){echo "selected";}?> >Switzerland Francs</option>
									<option value="TWD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'TWD'){echo "selected";}}elseif(old('sale_currency') == 'TWD'){echo "selected";}?> >Taiwan Dollars</option>
									<option value="THB"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'THB'){echo "selected";}}elseif(old('sale_currency') == 'THB'){echo "selected";}?> >Thailand Baht</option>
									<option value="TTD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'TTD'){echo "selected";}}elseif(old('sale_currency') == 'TTD'){echo "selected";}?> >Trinidad and Tobago Dollars</option>
									<option value="TRL"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'TRL'){echo "selected";}}elseif(old('sale_currency') == 'TRL'){echo "selected";}?> >Turkey Lira</option>
									<option value="VEB"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'VEB'){echo "selected";}}elseif(old('sale_currency') == 'VEB'){echo "selected";}?> >Venezuela Bolivar</option>
									<option value="ZMK"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'ZMK'){echo "selected";}}elseif(old('sale_currency') == 'ZMK'){echo "selected";}?> >Zambia Kwacha</option>
									<option value="EUR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'EUR'){echo "selected";}}elseif(old('sale_currency') == 'EUR'){echo "selected";}?> >Euro</option>
									<option value="XCD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XCD'){echo "selected";}}elseif(old('sale_currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="XDR"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XDR'){echo "selected";}}elseif(old('sale_currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="XAG"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XAG'){echo "selected";}}elseif(old('sale_currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="XAU"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XAU'){echo "selected";}}elseif(old('sale_currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="XPD"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XPD'){echo "selected";}}elseif(old('sale_currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="XPT"<?php if(isset($Tbl_product)){if($Tbl_product->sale_currency == 'XPT'){echo "selected";}}elseif(old('sale_currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
								</select>
								</div>
							</div>

							<!-- <div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Sale CESS %') }}</label>
								<input type="text"  class="form-control" name="sale_cess_per"  value="@if(isset($Tbl_product)){{ $Tbl_product->sale_cess_per }}@else{{old('sale_cess_per')}}@endif" style="border-color: @if ($errors->get('sale_cess_per')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('sale_cess_per'))
									@foreach ($errors->get('sale_cess_per') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Sale CESS +') }}</label>
								<input type="text"  class="form-control" name="sale_cess_pluse"  value="@if(isset($Tbl_product)){{ $Tbl_product->sale_cess_pluse }}@else{{old('sale_cess_pluse')}}@endif" style="border-color: @if ($errors->get('sale_cess_pluse')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('sale_cess_pluse'))
									@foreach ($errors->get('sale_cess_pluse') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>-->
						</div>


							<center><strong>{{ trans('app.Purchase') }}</strong></center>
							<div style="border: 1px solid #ced4da;padding: 10px;">
							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Purchase Price') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="purchase_price"  value="@if(isset($Tbl_product)){{ $Tbl_product->purchase_price }}@else{{old('purchase_price')}}@endif" style="border-color: @if ($errors->get('purchase_price')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('purchase_price'))
									@foreach ($errors->get('purchase_price') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group row">
								<div class="col-md-4"><b>{{ trans('app.Purchase Currency') }}</b><span style="color: red;">*</span></div>
								<div class="col-md-8">
								<select class="form-control select2"  name="purchase_currency">
									<option value="INR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'INR'){echo "selected";}}elseif(old('purchase_currency') == 'INR'){echo "selected";}?> >India Rupees</option>

									<option value="USD" <?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'USD'){echo "selected";}}elseif(old('purchase_currency') == 'USD'){echo "selected";}?>>United States Dollars</option>

									<option value="EUR" <?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'EUR'){echo "selected";}}elseif(old('purchase_currency') == 'EUR'){echo "selected";}?> >Euro</option>

									<option value="GBP" <?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'GBP'){echo "selected";}}elseif(old('purchase_currency') == 'GBP'){echo "selected";}?> >United Kingdom Pounds</option>

									<option value="DZD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'DZD'){echo "selected";}}elseif(old('purchase_currency') == 'DZD'){echo "selected";}?> >Algeria Dinars</option>

									<option value="ARP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ARP'){echo "selected";}}elseif(old('purchase_currency') == 'ARP'){echo "selected";}?> >Argentina Pesos</option>

									<option value="AUD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'AUD'){echo "selected";}}elseif(old('purchase_currency') == 'AUD'){echo "selected";}?> >Australia Dollars</option>

									<option value="ATS"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ATS'){echo "selected";}}elseif(old('purchase_currency') == 'ATS'){echo "selected";}?> >Austria Schillings</option>

									<option value="BSD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'EUR'){echo "selected";}}elseif(old('purchase_currency') == 'EUR'){echo "selected";}?> >Bahamas Dollars</option>

									<option value="BBD" <?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'BBD'){echo "selected";}}elseif(old('purchase_currency') == 'BBD'){echo "selected";}?> >Barbados Dollars</option>

									<option value="BEF"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'BEF'){echo "selected";}}elseif(old('purchase_currency') == 'BEF'){echo "selected";}?> >Belgium Francs</option>

									<option value="BMD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'BMD'){echo "selected";}}elseif(old('purchase_currency') == 'BMD'){echo "selected";}?> >Bermuda Dollars</option>

									<option value="BRR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'BRR'){echo "selected";}}elseif(old('purchase_currency') == 'BRR'){echo "selected";}?> >Brazil Real</option>

									<option value="BGL"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'BGL'){echo "selected";}}elseif(old('purchase_currency') == 'BGL'){echo "selected";}?> >Bulgaria Lev</option>

									<option value="CAD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CAD'){echo "selected";}}elseif(old('purchase_currency') == 'CAD'){echo "selected";}?> >Canada Dollars</option>

									<option value="CLP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CLP'){echo "selected";}}elseif(old('purchase_currency') == 'CLP'){echo "selected";}?> >Chile Pesos</option>

									<option value="CNY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CNY'){echo "selected";}}elseif(old('purchase_currency') == 'CNY'){echo "selected";}?> >China Yuan Renmimbi</option>

									<option value="CYP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CYP'){echo "selected";}}elseif(old('purchase_currency') == 'CYP'){echo "selected";}?> >Cyprus Pounds</option>

									<option value="CSK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CSK'){echo "selected";}}elseif(old('purchase_currency') == 'CSK'){echo "selected";}?> >Czech Republic Koruna</option>

									<option value="DKK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'DKK'){echo "selected";}}elseif(old('purchase_currency') == 'DKK'){echo "selected";}?> >Denmark Kroner</option>

									<option value="NLG"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'NLG'){echo "selected";}}elseif(old('purchase_currency') == 'NLG'){echo "selected";}?> >Dutch Guilders</option>
									<option value="XCD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XCD'){echo "selected";}}elseif(old('purchase_currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="EGP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'EGP'){echo "selected";}}elseif(old('purchase_currency') == 'EGP'){echo "selected";}?> >Egypt Pounds</option>
									<option value="FJD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'FJD'){echo "selected";}}elseif(old('purchase_currency') == 'FJD'){echo "selected";}?> >Fiji Dollars</option>
									<option value="FIM"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'FIM'){echo "selected";}}elseif(old('purchase_currency') == 'FIM'){echo "selected";}?> >Finland Markka</option>
									<option value="FRF"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'FRF'){echo "selected";}}elseif(old('purchase_currency') == 'FRF'){echo "selected";}?> >France Francs</option>
									<option value="DEM"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'DEM'){echo "selected";}}elseif(old('purchase_currency') == 'DEM'){echo "selected";}?> >Germany Deutsche Marks</option>
									<option value="XAU"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XAU'){echo "selected";}}elseif(old('purchase_currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="GRD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'GRD'){echo "selected";}}elseif(old('purchase_currency') == 'GRD'){echo "selected";}?> >Greece Drachmas</option>
									<option value="HKD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'HKD'){echo "selected";}}elseif(old('purchase_currency') == 'HKD'){echo "selected";}?> >Hong Kong Dollars</option>
									<option value="HUF"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'HUF'){echo "selected";}}elseif(old('purchase_currency') == 'HUF'){echo "selected";}?> >Hungary Forint</option>
									<option value="ISK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ISK'){echo "selected";}}elseif(old('purchase_currency') == 'ISK'){echo "selected";}?> >Iceland Krona</option>
									
									<option value="IDR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'IDR'){echo "selected";}}elseif(old('purchase_currency') == 'IDR'){echo "selected";}?> >Indonesia Rupiah</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JPY'){echo "selected";}}elseif(old('purchase_currency') == 'JPY'){echo "selected";}?> >Ireland Punt</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JPY'){echo "selected";}}elseif(old('purchase_currency') == 'JPY'){echo "selected";}?> >Israel New Shekels</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JPY'){echo "selected";}}elseif(old('purchase_currency') == 'JPY'){echo "selected";}?> >Italy Lira</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JPY'){echo "selected";}}elseif(old('purchase_currency') == 'JPY'){echo "selected";}?> >Jamaica Dollars</option>
									<option value="JPY"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JPY'){echo "selected";}}elseif(old('purchase_currency') == 'JPY'){echo "selected";}?> >Japan Yen</option>
									<option value="JOD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'JOD'){echo "selected";}}elseif(old('purchase_currency') == 'JOD'){echo "selected";}?> >Jordan Dinar</option>
									<option value="KRW"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'KRW'){echo "selected";}}elseif(old('purchase_currency') == 'KRW'){echo "selected";}?> >Korea (South) Won</option>
									<option value="LBP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'LBP'){echo "selected";}}elseif(old('purchase_currency') == 'LBP'){echo "selected";}?> >Lebanon Pounds</option>
									<option value="LUF"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'LUF'){echo "selected";}}elseif(old('purchase_currency') == 'LUF'){echo "selected";}?> >Luxembourg Francs</option>
									<option value="MYR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'MYR'){echo "selected";}}elseif(old('purchase_currency') == 'MYR'){echo "selected";}?> >Malaysia Ringgit</option>
									<option value="MXP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'MXP'){echo "selected";}}elseif(old('purchase_currency') == 'MXP'){echo "selected";}?> >Mexico Pesos</option>
									<option value="NLG"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'NLG'){echo "selected";}}elseif(old('purchase_currency') == 'NLG'){echo "selected";}?> >Netherlands Guilders</option>
									<option value="NZD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'NZD'){echo "selected";}}elseif(old('purchase_currency') == 'NZD'){echo "selected";}?> >New Zealand Dollars</option>
									<option value="NOK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'NOK'){echo "selected";}}elseif(old('purchase_currency') == 'NOK'){echo "selected";}?> >Norway Kroner</option>
									<option value="PKR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'PKR'){echo "selected";}}elseif(old('purchase_currency') == 'PKR'){echo "selected";}?> >Pakistan Rupees</option>
									<option value="XPD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XPD'){echo "selected";}}elseif(old('purchase_currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="PHP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'PHP'){echo "selected";}}elseif(old('purchase_currency') == 'PHP'){echo "selected";}?> >Philippines Pesos</option>
									<option value="XPT"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XPT'){echo "selected";}}elseif(old('purchase_currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
									<option value="PLZ"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'PLZ'){echo "selected";}}elseif(old('purchase_currency') == 'PLZ'){echo "selected";}?> >Poland Zloty</option>
									<option value="PTE"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'PTE'){echo "selected";}}elseif(old('purchase_currency') == 'PTE'){echo "selected";}?> >Portugal Escudo</option>
									<option value="ROL"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ROL'){echo "selected";}}elseif(old('purchase_currency') == 'ROL'){echo "selected";}?> >Romania Leu</option>
									<option value="RUR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'RUR'){echo "selected";}}elseif(old('purchase_currency') == 'RUR'){echo "selected";}?> >Russia Rubles</option>
									<option value="SAR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'SAR'){echo "selected";}}elseif(old('purchase_currency') == 'SAR'){echo "selected";}?> >Saudi Arabia Riyal</option>
									<option value="XAG"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XAG'){echo "selected";}}elseif(old('purchase_currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="SGD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'SGD'){echo "selected";}}elseif(old('purchase_currency') == 'SGD'){echo "selected";}?> >Singapore Dollars</option>
									<option value="SKK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'SKK'){echo "selected";}}elseif(old('purchase_currency') == 'SKK'){echo "selected";}?> >Slovakia Koruna</option>
									<option value="ZAR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ZAR'){echo "selected";}}elseif(old('purchase_currency') == 'ZAR'){echo "selected";}?> >South Africa Rand</option>
									<option value="KRW"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'KRW'){echo "selected";}}elseif(old('purchase_currency') == 'KRW'){echo "selected";}?> >South Korea Won</option>
									<option value="ESP"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ESP'){echo "selected";}}elseif(old('purchase_currency') == 'ESP'){echo "selected";}?> >Spain Pesetas</option>
									<option value="XDR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XDR'){echo "selected";}}elseif(old('purchase_currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="SDD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'SDD'){echo "selected";}}elseif(old('purchase_currency') == 'SDD'){echo "selected";}?> >Sudan Dinar</option>
									<option value="SEK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'SEK'){echo "selected";}}elseif(old('purchase_currency') == 'SEK'){echo "selected";}?> >Sweden Krona</option>
									<option value="CHF"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'CHF'){echo "selected";}}elseif(old('purchase_currency') == 'CHF'){echo "selected";}?> >Switzerland Francs</option>
									<option value="TWD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'TWD'){echo "selected";}}elseif(old('purchase_currency') == 'TWD'){echo "selected";}?> >Taiwan Dollars</option>
									<option value="THB"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'THB'){echo "selected";}}elseif(old('purchase_currency') == 'THB'){echo "selected";}?> >Thailand Baht</option>
									<option value="TTD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'TTD'){echo "selected";}}elseif(old('purchase_currency') == 'TTD'){echo "selected";}?> >Trinidad and Tobago Dollars</option>
									<option value="TRL"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'TRL'){echo "selected";}}elseif(old('purchase_currency') == 'TRL'){echo "selected";}?> >Turkey Lira</option>
									<option value="VEB"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'VEB'){echo "selected";}}elseif(old('purchase_currency') == 'VEB'){echo "selected";}?> >Venezuela Bolivar</option>
									<option value="ZMK"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'ZMK'){echo "selected";}}elseif(old('purchase_currency') == 'ZMK'){echo "selected";}?> >Zambia Kwacha</option>
									<option value="EUR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'EUR'){echo "selected";}}elseif(old('purchase_currency') == 'EUR'){echo "selected";}?> >Euro</option>
									<option value="XCD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XCD'){echo "selected";}}elseif(old('purchase_currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="XDR"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XDR'){echo "selected";}}elseif(old('purchase_currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="XAG"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XAG'){echo "selected";}}elseif(old('purchase_currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="XAU"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XAU'){echo "selected";}}elseif(old('purchase_currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="XPD"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XPD'){echo "selected";}}elseif(old('purchase_currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="XPT"<?php if(isset($Tbl_product)){if($Tbl_product->purchase_currency == 'XPT'){echo "selected";}}elseif(old('purchase_currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
								</select>
								</div>
							</div>

							<!-- <div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Purchase CESS %') }}</label>
								<input type="text"  class="form-control" name="purchase_cess_per"  value="@if(isset($Tbl_product)){{ $Tbl_product->purchase_cess_per }}@else{{old('purchase_cess_per')}}@endif" style="border-color: @if ($errors->get('purchase_cess_per')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('purchase_cess_per'))
									@foreach ($errors->get('purchase_cess_per') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 33.33%;">{{ trans('app.Purchase CESS +') }}</label>
								<input type="text"  class="form-control" name="purchase_cess_pluse"  value="@if(isset($Tbl_product)){{ $Tbl_product->purchase_cess_pluse }}@else{{old('purchase_cess_pluse')}}@endif" style="border-color: @if ($errors->get('purchase_cess_pluse')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('purchase_cess_pluse'))
									@foreach ($errors->get('purchase_cess_pluse') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div> -->

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
		<!-- /.row -->
	</section>
</div>
@endsection
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>
	function image_readURL(input) {
		if (input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#image').show();
				$('#image').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}}

	function check_address(value)
	{
		alert(value);
	}

	$(function () {
	$(".select2").select2();
		});
</script>
