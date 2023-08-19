@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{ trans('app.Add Client') }}</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/clients') }}">{{ trans('app.Client List') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('app.Add Client') }}</li>
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
				@if(isset($Tbl_client))        
				<form action="{{ route('clients.update',[app()->getLocale(),$Tbl_client->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data">
				<input type="hidden" value="{{ $Tbl_client->id }}" name="id"> 
				 @method('PUT')      
					@else
					<form action="{{ route('clients.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data">     
						@endif
						@csrf
				
					<div class="card">
						<div class="card-body">
							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.User Type') }}<span style="color: red;">*</span></label>
								<select class="form-control"  name="type">
									<option value="0"<?php if(isset($Tbl_client)){if($Tbl_client->type == '0'){echo "selected";}}elseif(old('type') == '0'){echo "selected";}?> >{{ trans('app.Client') }}</option>
									<option value="1"<?php if(isset($Tbl_client)){if($Tbl_client->type == '1'){echo "selected";}}elseif(old('type') == '1'){echo "selected";}?> >{{ trans('app.Vendor') }}</option>
									<option value="2"<?php if(isset($Tbl_client)){if($Tbl_client->type == '2'){echo "selected";}}elseif(old('type') == '2'){echo "selected";}?> >{{ trans('app.Both') }}</option>
								</select>
							</div>


							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Company Name') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="company_name"  value="@if(isset($Tbl_client)){{ $Tbl_client->company_name }}@else{{old('company_name')}}@endif" style="border-color: @if ($errors->get('company_name')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('company_name'))
									@foreach ($errors->get('company_name') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>


							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Phone') }}<span style="color: red;">*</span></label>
								<input type="tel"  class="form-control" name="phone"  value="@if(isset($Tbl_client)){{ $Tbl_client->phone }}@else{{old('phone')}}@endif"  style="border-color: @if ($errors->get('phone')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('phone'))
									@foreach ($errors->get('phone') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Email') }}<span style="color: red;">*</span></label>
								<input type="email" class="form-control" name="email" value="@if(isset($Tbl_client)){{ $Tbl_client->email }}@else{{old('email')}}@endif"  style="border-color: @if ($errors->get('email')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('email'))
									@foreach ($errors->get('email') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.GSTIN') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="gstin"  value="@if(isset($Tbl_client)){{ $Tbl_client->gstin }}@else{{old('gstin')}}@endif"  style="border-color: @if ($errors->get('gstin')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('gstin'))
									@foreach ($errors->get('gstin') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.PAN') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="pan" value="@if(isset($Tbl_client)){{ $Tbl_client->pan }}@else{{old('pan')}}@endif"  style="border-color: @if ($errors->get('pan')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('pan'))
									@foreach ($errors->get('pan') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.TIN') }}</label>
								<input type="text"  class="form-control" name="tin"  value="@if(isset($Tbl_client)){{ $Tbl_client->tin }}@else{{old('tin')}}@endif"  style="border-color: @if ($errors->get('tin')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('tin'))
									@foreach ($errors->get('tin') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.VAT') }}</label>
								<input type="text"  class="form-control" name="vat"  value="@if(isset($Tbl_client)){{ $Tbl_client->vat }}@else{{old('vat')}}@endif"  style="border-color: @if ($errors->get('vat')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('vat'))
									@foreach ($errors->get('vat') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Website') }}</label>
								<input type="text"  class="form-control" name="website"  value="@if(isset($Tbl_client)){{ $Tbl_client->website }}@else{{old('website')}}@endif"  style="border-color: @if ($errors->get('website')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('website'))
									@foreach ($errors->get('website') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group row">
								<div class="col-md-3" style="color: #212529;"><b>{{ trans('app.Currency') }}</b><span style="color: red;">*</span></div>
								<div class="col-md-9">
								<select class="form-control select2"  name="currency">
									<option value="INR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'INR'){echo "selected";}}elseif(old('currency') == 'INR'){echo "selected";}?> >India Rupees</option>

									<option value="USD" <?php if(isset($Tbl_client)){if($Tbl_client->currency == 'USD'){echo "selected";}}elseif(old('currency') == 'USD'){echo "selected";}?>>United States Dollars</option>

									<option value="EUR" <?php if(isset($Tbl_client)){if($Tbl_client->currency == 'EUR'){echo "selected";}}elseif(old('currency') == 'EUR'){echo "selected";}?> >Euro</option>

									<option value="GBP" <?php if(isset($Tbl_client)){if($Tbl_client->currency == 'GBP'){echo "selected";}}elseif(old('currency') == 'GBP'){echo "selected";}?> >United Kingdom Pounds</option>

									<option value="DZD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'DZD'){echo "selected";}}elseif(old('currency') == 'DZD'){echo "selected";}?> >Algeria Dinars</option>

									<option value="ARP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ARP'){echo "selected";}}elseif(old('currency') == 'ARP'){echo "selected";}?> >Argentina Pesos</option>

									<option value="AUD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'AUD'){echo "selected";}}elseif(old('currency') == 'AUD'){echo "selected";}?> >Australia Dollars</option>

									<option value="ATS"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ATS'){echo "selected";}}elseif(old('currency') == 'ATS'){echo "selected";}?> >Austria Schillings</option>

									<option value="BSD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'EUR'){echo "selected";}}elseif(old('currency') == 'EUR'){echo "selected";}?> >Bahamas Dollars</option>

									<option value="BBD" <?php if(isset($Tbl_client)){if($Tbl_client->currency == 'BBD'){echo "selected";}}elseif(old('currency') == 'BBD'){echo "selected";}?> >Barbados Dollars</option>

									<option value="BEF"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'BEF'){echo "selected";}}elseif(old('currency') == 'BEF'){echo "selected";}?> >Belgium Francs</option>

									<option value="BMD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'BMD'){echo "selected";}}elseif(old('currency') == 'BMD'){echo "selected";}?> >Bermuda Dollars</option>

									<option value="BRR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'BRR'){echo "selected";}}elseif(old('currency') == 'BRR'){echo "selected";}?> >Brazil Real</option>

									<option value="BGL"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'BGL'){echo "selected";}}elseif(old('currency') == 'BGL'){echo "selected";}?> >Bulgaria Lev</option>

									<option value="CAD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CAD'){echo "selected";}}elseif(old('currency') == 'CAD'){echo "selected";}?> >Canada Dollars</option>

									<option value="CLP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CLP'){echo "selected";}}elseif(old('currency') == 'CLP'){echo "selected";}?> >Chile Pesos</option>

									<option value="CNY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CNY'){echo "selected";}}elseif(old('currency') == 'CNY'){echo "selected";}?> >China Yuan Renmimbi</option>

									<option value="CYP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CYP'){echo "selected";}}elseif(old('currency') == 'CYP'){echo "selected";}?> >Cyprus Pounds</option>

									<option value="CSK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CSK'){echo "selected";}}elseif(old('currency') == 'CSK'){echo "selected";}?> >Czech Republic Koruna</option>

									<option value="DKK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'DKK'){echo "selected";}}elseif(old('currency') == 'DKK'){echo "selected";}?> >Denmark Kroner</option>

									<option value="NLG"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'NLG'){echo "selected";}}elseif(old('currency') == 'NLG'){echo "selected";}?> >Dutch Guilders</option>
									<option value="XCD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XCD'){echo "selected";}}elseif(old('currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="EGP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'EGP'){echo "selected";}}elseif(old('currency') == 'EGP'){echo "selected";}?> >Egypt Pounds</option>
									<option value="FJD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'FJD'){echo "selected";}}elseif(old('currency') == 'FJD'){echo "selected";}?> >Fiji Dollars</option>
									<option value="FIM"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'FIM'){echo "selected";}}elseif(old('currency') == 'FIM'){echo "selected";}?> >Finland Markka</option>
									<option value="FRF"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'FRF'){echo "selected";}}elseif(old('currency') == 'FRF'){echo "selected";}?> >France Francs</option>
									<option value="DEM"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'DEM'){echo "selected";}}elseif(old('currency') == 'DEM'){echo "selected";}?> >Germany Deutsche Marks</option>
									<option value="XAU"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XAU'){echo "selected";}}elseif(old('currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="GRD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'GRD'){echo "selected";}}elseif(old('currency') == 'GRD'){echo "selected";}?> >Greece Drachmas</option>
									<option value="HKD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'HKD'){echo "selected";}}elseif(old('currency') == 'HKD'){echo "selected";}?> >Hong Kong Dollars</option>
									<option value="HUF"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'HUF'){echo "selected";}}elseif(old('currency') == 'HUF'){echo "selected";}?> >Hungary Forint</option>
									<option value="ISK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ISK'){echo "selected";}}elseif(old('currency') == 'ISK'){echo "selected";}?> >Iceland Krona</option>
									
									<option value="IDR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'IDR'){echo "selected";}}elseif(old('currency') == 'IDR'){echo "selected";}?> >Indonesia Rupiah</option>
									<option value="JPY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JPY'){echo "selected";}}elseif(old('currency') == 'JPY'){echo "selected";}?> >Ireland Punt</option>
									<option value="JPY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JPY'){echo "selected";}}elseif(old('currency') == 'JPY'){echo "selected";}?> >Israel New Shekels</option>
									<option value="JPY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JPY'){echo "selected";}}elseif(old('currency') == 'JPY'){echo "selected";}?> >Italy Lira</option>
									<option value="JPY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JPY'){echo "selected";}}elseif(old('currency') == 'JPY'){echo "selected";}?> >Jamaica Dollars</option>
									<option value="JPY"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JPY'){echo "selected";}}elseif(old('currency') == 'JPY'){echo "selected";}?> >Japan Yen</option>
									<option value="JOD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'JOD'){echo "selected";}}elseif(old('currency') == 'JOD'){echo "selected";}?> >Jordan Dinar</option>
									<option value="KRW"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'KRW'){echo "selected";}}elseif(old('currency') == 'KRW'){echo "selected";}?> >Korea (South) Won</option>
									<option value="LBP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'LBP'){echo "selected";}}elseif(old('currency') == 'LBP'){echo "selected";}?> >Lebanon Pounds</option>
									<option value="LUF"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'LUF'){echo "selected";}}elseif(old('currency') == 'LUF'){echo "selected";}?> >Luxembourg Francs</option>
									<option value="MYR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'MYR'){echo "selected";}}elseif(old('currency') == 'MYR'){echo "selected";}?> >Malaysia Ringgit</option>
									<option value="MXP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'MXP'){echo "selected";}}elseif(old('currency') == 'MXP'){echo "selected";}?> >Mexico Pesos</option>
									<option value="NLG"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'NLG'){echo "selected";}}elseif(old('currency') == 'NLG'){echo "selected";}?> >Netherlands Guilders</option>
									<option value="NZD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'NZD'){echo "selected";}}elseif(old('currency') == 'NZD'){echo "selected";}?> >New Zealand Dollars</option>
									<option value="NOK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'NOK'){echo "selected";}}elseif(old('currency') == 'NOK'){echo "selected";}?> >Norway Kroner</option>
									<option value="PKR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'PKR'){echo "selected";}}elseif(old('currency') == 'PKR'){echo "selected";}?> >Pakistan Rupees</option>
									<option value="XPD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XPD'){echo "selected";}}elseif(old('currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="PHP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'PHP'){echo "selected";}}elseif(old('currency') == 'PHP'){echo "selected";}?> >Philippines Pesos</option>
									<option value="XPT"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XPT'){echo "selected";}}elseif(old('currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
									<option value="PLZ"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'PLZ'){echo "selected";}}elseif(old('currency') == 'PLZ'){echo "selected";}?> >Poland Zloty</option>
									<option value="PTE"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'PTE'){echo "selected";}}elseif(old('currency') == 'PTE'){echo "selected";}?> >Portugal Escudo</option>
									<option value="ROL"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ROL'){echo "selected";}}elseif(old('currency') == 'ROL'){echo "selected";}?> >Romania Leu</option>
									<option value="RUR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'RUR'){echo "selected";}}elseif(old('currency') == 'RUR'){echo "selected";}?> >Russia Rubles</option>
									<option value="SAR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'SAR'){echo "selected";}}elseif(old('currency') == 'SAR'){echo "selected";}?> >Saudi Arabia Riyal</option>
									<option value="XAG"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XAG'){echo "selected";}}elseif(old('currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="SGD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'SGD'){echo "selected";}}elseif(old('currency') == 'SGD'){echo "selected";}?> >Singapore Dollars</option>
									<option value="SKK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'SKK'){echo "selected";}}elseif(old('currency') == 'SKK'){echo "selected";}?> >Slovakia Koruna</option>
									<option value="ZAR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ZAR'){echo "selected";}}elseif(old('currency') == 'ZAR'){echo "selected";}?> >South Africa Rand</option>
									<option value="KRW"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'KRW'){echo "selected";}}elseif(old('currency') == 'KRW'){echo "selected";}?> >South Korea Won</option>
									<option value="ESP"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ESP'){echo "selected";}}elseif(old('currency') == 'ESP'){echo "selected";}?> >Spain Pesetas</option>
									<option value="XDR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XDR'){echo "selected";}}elseif(old('currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="SDD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'SDD'){echo "selected";}}elseif(old('currency') == 'SDD'){echo "selected";}?> >Sudan Dinar</option>
									<option value="SEK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'SEK'){echo "selected";}}elseif(old('currency') == 'SEK'){echo "selected";}?> >Sweden Krona</option>
									<option value="CHF"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'CHF'){echo "selected";}}elseif(old('currency') == 'CHF'){echo "selected";}?> >Switzerland Francs</option>
									<option value="TWD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'TWD'){echo "selected";}}elseif(old('currency') == 'TWD'){echo "selected";}?> >Taiwan Dollars</option>
									<option value="THB"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'THB'){echo "selected";}}elseif(old('currency') == 'THB'){echo "selected";}?> >Thailand Baht</option>
									<option value="TTD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'TTD'){echo "selected";}}elseif(old('currency') == 'TTD'){echo "selected";}?> >Trinidad and Tobago Dollars</option>
									<option value="TRL"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'TRL'){echo "selected";}}elseif(old('currency') == 'TRL'){echo "selected";}?> >Turkey Lira</option>
									<option value="VEB"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'VEB'){echo "selected";}}elseif(old('currency') == 'VEB'){echo "selected";}?> >Venezuela Bolivar</option>
									<option value="ZMK"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'ZMK'){echo "selected";}}elseif(old('currency') == 'ZMK'){echo "selected";}?> >Zambia Kwacha</option>
									<option value="EUR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'EUR'){echo "selected";}}elseif(old('currency') == 'EUR'){echo "selected";}?> >Euro</option>
									<option value="XCD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XCD'){echo "selected";}}elseif(old('currency') == 'XCD'){echo "selected";}?> >Eastern Caribbean Dollars</option>
									<option value="XDR"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XDR'){echo "selected";}}elseif(old('currency') == 'XDR'){echo "selected";}?> >Special Drawing Right (IMF)</option>
									<option value="XAG"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XAG'){echo "selected";}}elseif(old('currency') == 'XAG'){echo "selected";}?> >Silver Ounces</option>
									<option value="XAU"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XAU'){echo "selected";}}elseif(old('currency') == 'XAU'){echo "selected";}?> >Gold Ounces</option>
									<option value="XPD"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XPD'){echo "selected";}}elseif(old('currency') == 'XPD'){echo "selected";}?> >Palladium Ounces</option>
									<option value="XPT"<?php if(isset($Tbl_client)){if($Tbl_client->currency == 'XPT'){echo "selected";}}elseif(old('currency') == 'XPT'){echo "selected";}?> >Platinum Ounces</option>
								</select>
							</div>
							</div>


							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Contact Person') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="contact_person"  value="@if(isset($Tbl_client)){{ $Tbl_client->contact_person }}  @else{{old('contact_person')}}@endif"  style="border-color: @if ($errors->get('contact_person')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('contact_person'))
									@foreach ($errors->get('contact_person') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Contact Phone') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="contact_phone"  value="@if(isset($Tbl_client)){{ $Tbl_client->contact_phone }}@else{{old('contact_phone')}}@endif"  style="border-color: @if ($errors->get('contact_phone')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('contact_phone'))
									@foreach ($errors->get('contact_phone') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Contact Name') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="contact_name"  value="@if(isset($Tbl_client)){{ $Tbl_client->contact_name }}@else{{old('contact_name')}}@endif"  style="border-color: @if ($errors->get('contact_name')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('contact_name'))
									@foreach ($errors->get('contact_name') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							
							<!-- <div class="card-footer">

								<button type="submit" name="submit" class="btn btn-primary">{{ trans('app.Submit') }}</button>
								<button type="button" name="back" onClick="javascript:history.go(-1);" class="btn btn-secondary"><i
									class="fa fa-chevron-circle-left"> &nbsp;</i>{{ trans('app.Back') }}
								</button>
							</div> -->
						</div>
					</div>
			</div>
			<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							{{ trans('app.Billing Address') }}
							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.Address') }}<span style="color: red;">*</span></label>
								<textarea class="form-control" name="address" style="border-color: @if ($errors->get('address')){{ '#e74c3c' }}@endif">@if(isset($Tbl_client)){{ $Tbl_client->address }}@else{{old('address')}}@endif</textarea>
								<div class="error_style_msg">@if ($errors->get('address'))
									@foreach ($errors->get('address') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group row">
								<div class="col-md-3" style="color: #212529;"><b>{{ trans('app.State') }}</b><span style="color: red;">*</span></div>
								<div class="col-md-9">
								<select name="state" class="form-control select2" id="stateId" style="border-color: @if ($errors->get('state')){{ '#e74c3c' }}@endif">
									<option value="Gujarat" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Gujarat'){echo "selected";}}elseif(old('state') == 'Gujarat'){echo "selected";}?> >Gujarat</option>

									<option value="Andaman and Nicobar Islands" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Andaman and Nicobar Islands'){echo "selected";}}elseif(old('state') == 'Andaman and Nicobar Islands'){echo "selected";}?> >Andaman and Nicobar Islands</option>

									<option value="Andhra Pradesh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Andhra Pradesh'){echo "selected";}}elseif(old('state') == 'Andhra Pradesh'){echo "selected";}?>>Andhra Pradesh</option>

									<option value="Arunachal Pradesh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Arunachal Pradesh'){echo "selected";}}elseif(old('state') == 'Arunachal Pradesh'){echo "selected";}?>>Arunachal Pradesh</option>

									<option value="Assam" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Assam'){echo "selected";}}elseif(old('state') == 'Assam'){echo "selected";}?>>Assam</option>

									<option value="Bihar" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Bihar'){echo "selected";}}elseif(old('state') == 'Bihar'){echo "selected";}?> >Bihar</option>

									<option value="Chandigarh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Chandigarh'){echo "selected";}}elseif(old('state') == 'Chandigarh'){echo "selected";}?> >Chandigarh</option>

									<option value="Chhattisgarh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Chhattisgarh'){echo "selected";}}elseif(old('state') == 'Chhattisgarh'){echo "selected";}?> >Chhattisgarh</option>

									<option value="Dadra and Nagar Haveli"  <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Dadra and Nagar Haveli'){echo "selected";}}elseif(old('state') == 'Dadra and Nagar Haveli'){echo "selected";}?> >Dadra and Nagar Haveli</option>

									<option value="Daman and Diu" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Daman and Diu'){echo "selected";}}elseif(old('state') == 'Daman and Diu'){echo "selected";}?> >Daman and Diu</option>

									<option value="Delhi" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Delhi'){echo "selected";}}elseif(old('state') == 'Delhi'){echo "selected";}?> >Delhi</option>

									<option value="Goa" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Goa'){echo "selected";}}elseif(old('state') == 'Goa'){echo "selected";}?> >Goa</option>

									<option value="Haryana" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Haryana'){echo "selected";}}elseif(old('state') == 'Haryana'){echo "selected";}?> >Haryana</option>

									<option value="Himachal Pradesh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Himachal Pradesh'){echo "selected";}}elseif(old('state') == 'Himachal Pradesh'){echo "selected";}?> >Himachal Pradesh</option>

									<option value="Jammu and Kashmir" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Jammu and Kashmir'){echo "selected";}}elseif(old('state') == 'Jammu and Kashmir'){echo "selected";}?> >Jammu and Kashmir</option>

									<option value="Jharkhand" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Jharkhand'){echo "selected";}}elseif(old('state') == 'Jharkhand'){echo "selected";}?> >Jharkhand</option>

									<option value="Karnataka" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Karnataka'){echo "selected";}}elseif(old('state') == 'Karnataka'){echo "selected";}?> >Karnataka</option>

									<option value="Kerala" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Kerala'){echo "selected";}}elseif(old('state') == 'Kerala'){echo "selected";}?> >Kerala</option>

									<option value="Lakshadweep" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Lakshadweep'){echo "selected";}}elseif(old('state') == 'Lakshadweep'){echo "selected";}?> >Lakshadweep</option>

									<option value="Madhya Pradesh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Madhya Pradesh'){echo "selected";}}elseif(old('state') == 'Madhya Pradesh'){echo "selected";}?> >Madhya Pradesh</option>

									<option value="Maharashtra" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Maharashtra'){echo "selected";}}elseif(old('state') == 'Maharashtra'){echo "selected";}?> >Maharashtra</option>

									<option value="Manipur" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Manipur'){echo "selected";}}elseif(old('state') == 'Manipur'){echo "selected";}?> >Manipur</option>

									<option value="Meghalaya" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Meghalaya'){echo "selected";}}elseif(old('state') == 'Meghalaya'){echo "selected";}?> >Meghalaya</option>

									<option value="Mizoram" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Mizoram'){echo "selected";}}elseif(old('state') == 'Mizoram'){echo "selected";}?> >Mizoram</option>

									<option value="Nagaland" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Nagaland'){echo "selected";}}elseif(old('state') == 'Nagaland'){echo "selected";}?> >Nagaland</option>

									<option value="Orissa" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Orissa'){echo "selected";}}elseif(old('state') == 'Orissa'){echo "selected";}?> >Orissa</option>

									<option value="Pondicherry" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Pondicherry'){echo "selected";}}elseif(old('state') == 'Pondicherry'){echo "selected";}?> >Pondicherry</option>

									<option value="Punjab" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Punjab'){echo "selected";}}elseif(old('state') == 'Punjab'){echo "selected";}?> >Punjab</option>

									<option value="Rajasthan" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Rajasthan'){echo "selected";}}elseif(old('state') == 'Rajasthan'){echo "selected";}?> >Rajasthan</option>

									<option value="Sikkim" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Sikkim'){echo "selected";}}elseif(old('state') == 'Sikkim'){echo "selected";}?> >Sikkim</option>

									<option value="Tamil Nadu" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Tamil Nadu'){echo "selected";}}elseif(old('state') == 'Tamil Nadu'){echo "selected";}?> >Tamil Nadu</option>

									<option value="Tripura" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Tripura'){echo "selected";}}elseif(old('state') == 'Tripura'){echo "selected";}?> >Tripura</option>

									<option value="Uttaranchal" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Uttaranchal'){echo "selected";}}elseif(old('state') == 'Uttaranchal'){echo "selected";}?> >Uttaranchal</option>

									<option value="Uttar Pradesh" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'Uttar Pradesh'){echo "selected";}}elseif(old('state') == 'Uttar Pradesh'){echo "selected";}?> >Uttar Pradesh</option>

									<option value="West Bengal" <?php if(isset($Tbl_client)){if($Tbl_client->state == 'West Bengal'){echo "selected";}}elseif(old('state') == 'West Bengal'){echo "selected";}?> >West Bengal</option>
								</select>
								<div class="error_style_msg">@if ($errors->get('state'))
									@foreach ($errors->get('state') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 26%;">{{ trans('app.PIN') }}<span style="color: red;">*</span></label>
								<input type="text"  class="form-control" name="pin"  value="@if(isset($Tbl_client)){{ $Tbl_client->pin }}@else{{old('pin')}}@endif" style="border-color: @if ($errors->get('pin')){{ '#e74c3c' }}@endif">
								<div class="error_style_msg">@if ($errors->get('pin'))
									@foreach ($errors->get('pin') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
							</div>

							<div class="form-group"><label for="exampleInputFile">{{ trans('app.Profile') }}<span style="color: red;">*</span></label>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-xs-4">
										<span class="btn btn-primary btn-file" style="border-color: @if ($errors->get('logo')){{ '#e74c3c' }}@endif"> {{ trans('app.Browse') }}
											<input type="file" class="form-control btn" accept="image/png,image/jpg,image/jpeg" name="logo" onchange="image_readURL(this);" id="exampleInputFile"/ value="{{old('logo')}}">
										</span>
										<div class="error_style_msg">@if ($errors->get('logo'))
									@foreach ($errors->get('logo') as $error)
									{{ $error }}
									@endforeach
								@endif</div>
									</div>
									<div class="col-lg-4 col-md-4 col-xs-4">
										@if(isset($Tbl_client))  
										<img id="image" src="{{ asset('/public/images/client/'.$Tbl_client->logo) }}" alt="" height="160" width="160" />                    
										@else
										<img id="image" src="{{old('logo')}}" alt="" height="160" width="160" style="display: none;" />   
										@endif
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
