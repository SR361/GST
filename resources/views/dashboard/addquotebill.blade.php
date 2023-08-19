@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">{{ trans('app.Add Quote Bill') }}</h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
					<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/invoices') }}">{{ trans('app.Quote Bill List') }}</a></li>
					<li class="breadcrumb-item active">{{ trans('app.Add Quote Bill') }}</li>
				</ol>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>


<div id="Add_client_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">{{ trans('app.Add Client') }}</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            	<form method="POST" id="form_client" action="<?= route('invoicesadd_client',app()->getLocale()) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            		@csrf
                 <div class="form-group input-group">
                  <label class="mt-1" style="width: 22%;">{{ trans('app.User Type') }}</label>
                  <select class="form-control"  name="type" required>
                    <option value="0">{{ trans('app.Client') }}</option>
                    <option value="1">{{ trans('app.Vendor') }}</option>
                    <option value="2">{{ trans('app.Both') }}</option>
                  </select>
                </div>
              	<div class="form-group  input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Company Name') }}</label>
              		<input type="text"  class="form-control" name="company_name" required>
              	</div>
              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Phone') }}</label>
              		<input type="number" min="0"  class="form-control" name="phone" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Email') }}</label>
              		<input type="email" class="form-control" name="email" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.GSTIN') }}</label>
              		<input type="text"  class="form-control" name="gstin" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.PAN') }}</label>
              		<input type="text"  class="form-control" name="pan" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.TIN') }}</label>
              		<input type="number"  class="form-control" name="tin" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.VAT') }}</label>
              		<input type="number"  class="form-control" name="vat" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Website') }}</label>
              		<input type="url"  class="form-control" name="website" required>
              	</div>

              	<div class="form-group row">
              		<label class="mt-1 ml-2" style="width: 21%;">{{ trans('app.Currency') }}</label>
              		<select class="form-control select2"  name="currency" required>
              			<option value="INR" >India Rupees</option>
              			<option value="USD" >United States Dollars</option>
              			<option value="EUR"  >Euro</option>
              			<option value="GBP"  >United Kingdom Pounds</option>
              			<option value="DZD" >Algeria Dinars</option>
              			<option value="ARP" >Argentina Pesos</option>
              			<option value="AUD" >Australia Dollars</option>
              			<option value="ATS" >Austria Schillings</option>
              			<option value="BSD" >Bahamas Dollars</option>
              			<option value="BBD"  >Barbados Dollars</option>
              			<option value="BEF" >Belgium Francs</option>
              			<option value="BMD" >Bermuda Dollars</option>
              			<option value="BRR" >Brazil Real</option>
              			<option value="BGL" >Bulgaria Lev</option>
              			<option value="CAD" >Canada Dollars</option>
              			<option value="CLP" >Chile Pesos</option>
              			<option value="CNY" >China Yuan Renmimbi</option>
              			<option value="CYP" >Cyprus Pounds</option>
              			<option value="CSK" >Czech Republic Koruna</option>
              			<option value="DKK" >Denmark Kroner</option>
              			<option value="NLG" >Dutch Guilders</option>
              			<option value="XCD" >Eastern Caribbean Dollars</option>
              			<option value="EGP" >Egypt Pounds</option>
              			<option value="FJD" >Fiji Dollars</option>
              			<option value="FIM" >Finland Markka</option>
              			<option value="FRF" >France Francs</option>
              			<option value="DEM" >Germany Deutsche Marks</option>
              			<option value="XAU" >Gold Ounces</option>
              			<option value="GRD" >Greece Drachmas</option>
              			<option value="HKD" >Hong Kong Dollars</option>
              			<option value="HUF" >Hungary Forint</option>
              			<option value="ISK" >Iceland Krona</option>
              			<option value="IDR" >Indonesia Rupiah</option>
              			<option value="JPY" >Ireland Punt</option>
              			<option value="JPY" >Israel New Shekels</option>
              			<option value="JPY" >Italy Lira</option>
              			<option value="JPY" >Jamaica Dollars</option>
              			<option value="JPY" >Japan Yen</option>
              			<option value="JOD" >Jordan Dinar</option>
              			<option value="KRW" >Korea (South) Won</option>
              			<option value="LBP" >Lebanon Pounds</option>
              			<option value="LUF" >Luxembourg Francs</option>
              			<option value="MYR" >Malaysia Ringgit</option>
              			<option value="MXP" >Mexico Pesos</option>
              			<option value="NLG" >Netherlands Guilders</option>
              			<option value="NZD" >New Zealand Dollars</option>
              			<option value="NOK" >Norway Kroner</option>
              			<option value="PKR" >Pakistan Rupees</option>
              			<option value="XPD" >Palladium Ounces</option>
              			<option value="PHP" >Philippines Pesos</option>
              			<option value="XPT" >Platinum Ounces</option>
              			<option value="PLZ" >Poland Zloty</option>
              			<option value="PTE" >Portugal Escudo</option>
              			<option value="ROL" >Romania Leu</option>
              			<option value="RUR" >Russia Rubles</option>
              			<option value="SAR" >Saudi Arabia Riyal</option>
              			<option value="XAG" >Silver Ounces</option>
              			<option value="SGD" >Singapore Dollars</option>
              			<option value="SKK" >Slovakia Koruna</option>
              			<option value="ZAR" >South Africa Rand</option>
              			<option value="KRW" >South Korea Won</option>
              			<option value="ESP" >Spain Pesetas</option>
              			<option value="XDR" >Special Drawing Right (IMF)</option>
              			<option value="SDD" >Sudan Dinar</option>
              			<option value="SEK" >Sweden Krona</option>
              			<option value="CHF" >Switzerland Francs</option>
              			<option value="TWD" >Taiwan Dollars</option>
              			<option value="THB" >Thailand Baht</option>
              			<option value="TTD" >Trinidad and Tobago Dollars</option>
              			<option value="TRL" >Turkey Lira</option>
              			<option value="VEB" >Venezuela Bolivar</option>
              			<option value="ZMK" >Zambia Kwacha</option>
              			<option value="EUR" >Euro</option>
              			<option value="XCD" >Eastern Caribbean Dollars</option>
              			<option value="XDR">Special Drawing Right (IMF)</option>
              			<option value="XAG">Silver Ounces</option>
              			<option value="XAU">Gold Ounces</option>
              			<option value="XPD">Palladium Ounces</option>
              			<option value="XPT">Platinum Ounces</option>
              		</select>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Contact Person') }}</label>
              		<input type="text"  class="form-control" name="contact_person" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Contact Phone') }}</label>
              		<input type="number"  class="form-control" name="contact_phone" required>
              	</div>

              	<div class="form-group input-group">
              		<label class="mt-1" style="width: 22%;">{{ trans('app.Contact Name') }}</label>
              		<input type="text"  class="form-control" name="contact_name" required>
              	</div>
              	{{ trans('app.Billing Address') }}
							<div class="form-group input-group">
								<label class="mt-1" style="width: 22%;">{{ trans('app.Address') }}</label>
								<textarea class="form-control" name="address"></textarea>
								
							</div>

							<div class="form-group">
								<label class="mt-1 ml-2" style="width: 21%;">{{ trans('app.State') }}</label>
								<select name="state" class="form-control Select2">
									<option value="">{{ trans('app.Select State') }}</option>
                  <option value="Gujarat">Gujarat</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                            <option value="Daman and Diu">Daman and Diu</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Goa">Goa</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Orissa">Orissa</option>
                            <option value="Pondicherry">Pondicherry</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttaranchal">Uttaranchal</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="West Bengal">West Bengal</option>
								</select>
							</div>

							<div class="form-group input-group">
								<label class="mt-1" style="width: 22%;">{{ trans('app.PIN') }}</label>
								<input type="number"  class="form-control" name="pin">
							</div>

							<div class="form-group"><label for="exampleInputFile">{{ trans('app.Profile') }}</label>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-xs-4">
										<span class="btn btn-primary btn-file"> {{ trans('app.Browse') }}
											<input type="file" class="form-control btn" accept="image/png,image/jpg,image/jpeg" name="logo" onchange="image_readURL(this);" id="exampleInputFile" required>
										</span>
									</div>
									<div class="col-lg-4 col-md-4 col-xs-4">
										<img id="image" src="" alt="" height="160" width="160" style="display: none;" />   
									</div>
								</div>
							</div>

                <center><input type="submit" id="upload_client_data" value="{{ trans('app.Submit') }}" class="btn btn-default" /></center>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="Add_product_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title">{{ trans('app.Add Product') }}</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body">
      <form method="POST" id="form_product" action="<?= route('invoicesadd_product',app()->getLocale()) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Name') }}</label>
          <input type="text"  class="form-control" name="name" required>
        </div>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Description') }}</label>
          <textarea class="form-control" name="description" required></textarea>
        </div>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Quantity') }}</label>
          <input type="number"  class="form-control" name="quantity" required>
        </div>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.HSN') }}</label>
          <input type="text"  class="form-control" name="hsn" required>
        </div>


        <center><strong>{{ trans('app.Sale') }}</strong></center>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Sale Price') }}</label>
          <input type="number"  class="form-control" name="sale_price" required>
        </div>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Sale Currency') }}</label>
          <select class="form-control"  name="sale_currency" required>
            <option value="INR" >India Rupees</option>
            <option value="USD" >United States Dollars</option>
            <option value="EUR"  >Euro</option>
            <option value="GBP"  >United Kingdom Pounds</option>
            <option value="DZD" >Algeria Dinars</option>
            <option value="ARP" >Argentina Pesos</option>
            <option value="AUD" >Australia Dollars</option>
            <option value="ATS" >Austria Schillings</option>
            <option value="BSD" >Bahamas Dollars</option>
            <option value="BBD"  >Barbados Dollars</option>
            <option value="BEF" >Belgium Francs</option>
            <option value="BMD" >Bermuda Dollars</option>
            <option value="BRR" >Brazil Real</option>
            <option value="BGL" >Bulgaria Lev</option>
            <option value="CAD" >Canada Dollars</option>
            <option value="CLP" >Chile Pesos</option>
            <option value="CNY" >China Yuan Renmimbi</option>
            <option value="CYP" >Cyprus Pounds</option>
            <option value="CSK" >Czech Republic Koruna</option>
            <option value="DKK" >Denmark Kroner</option>
            <option value="NLG" >Dutch Guilders</option>
            <option value="XCD" >Eastern Caribbean Dollars</option>
            <option value="EGP" >Egypt Pounds</option>
            <option value="FJD" >Fiji Dollars</option>
            <option value="FIM" >Finland Markka</option>
            <option value="FRF" >France Francs</option>
            <option value="DEM" >Germany Deutsche Marks</option>
            <option value="XAU" >Gold Ounces</option>
            <option value="GRD" >Greece Drachmas</option>
            <option value="HKD" >Hong Kong Dollars</option>
            <option value="HUF" >Hungary Forint</option>
            <option value="ISK" >Iceland Krona</option>     
            <option value="IDR" >Indonesia Rupiah</option>
            <option value="JPY" >Ireland Punt</option>
            <option value="JPY" >Israel New Shekels</option>
            <option value="JPY" >Italy Lira</option>
            <option value="JPY" >Jamaica Dollars</option>
            <option value="JPY" >Japan Yen</option>
            <option value="JOD" >Jordan Dinar</option>
            <option value="KRW" >Korea (South) Won</option>
            <option value="LBP" >Lebanon Pounds</option>
            <option value="LUF" >Luxembourg Francs</option>
            <option value="MYR" >Malaysia Ringgit</option>
            <option value="MXP" >Mexico Pesos</option>
            <option value="NLG" >Netherlands Guilders</option>
            <option value="NZD" >New Zealand Dollars</option>
            <option value="NOK" >Norway Kroner</option>
            <option value="PKR" >Pakistan Rupees</option>
            <option value="XPD" >Palladium Ounces</option>
            <option value="PHP" >Philippines Pesos</option>
            <option value="XPT" >Platinum Ounces</option>
            <option value="PLZ" >Poland Zloty</option>
            <option value="PTE" >Portugal Escudo</option>
            <option value="ROL" >Romania Leu</option>
            <option value="RUR">Russia Rubles</option>
            <option value="SAR">Saudi Arabia Riyal</option>
            <option value="XAG">Silver Ounces</option>
            <option value="SGD">Singapore Dollars</option>
            <option value="SKK">Slovakia Koruna</option>
            <option value="ZAR">South Africa Rand</option>
            <option value="KRW">South Korea Won</option>
            <option value="ESP">Spain Pesetas</option>
            <option value="XDR">Special Drawing Right (IMF)</option>
            <option value="SDD">Sudan Dinar</option>
            <option value="SEK">Sweden Krona</option>
            <option value="CHF">Switzerland Francs</option>
            <option value="TWD">Taiwan Dollars</option>
            <option value="THB">Thailand Baht</option>
            <option value="TTD">Trinidad and Tobago Dollars</option>
            <option value="TRL">Turkey Lira</option>
            <option value="VEB">Venezuela Bolivar</option>
            <option value="ZMK">Zambia Kwacha</option>
            <option value="EUR">Euro</option>
            <option value="XCD">Eastern Caribbean Dollars</option>
            <option value="XDR">Special Drawing Right (IMF)</option>
            <option value="XAG">Silver Ounces</option>
            <option value="XAU">Gold Ounces</option>
            <option value="XPD">Palladium Ounces</option>
            <option value="XPT">Platinum Ounces</option>
          </select>
        </div>

        <center><strong>{{ trans('app.Purchase') }}</strong></center>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 22%;">{{ trans('app.Purchase Price') }}</label>
          <input type="number"  class="form-control" name="purchase_price" required>
        </div>

        <div class="form-group input-group">
          <label class="mt-1" style="width: 21%;">{{ trans('app.Purchase Currency') }}</label>
          <select class="form-control"  name="purchase_currency" required>
            <option value="INR" >India Rupees</option>
            <option value="USD" >United States Dollars</option>
            <option value="EUR"  >Euro</option>
            <option value="GBP"  >United Kingdom Pounds</option>
            <option value="DZD" >Algeria Dinars</option>
            <option value="ARP" >Argentina Pesos</option>
            <option value="AUD" >Australia Dollars</option>
            <option value="ATS" >Austria Schillings</option>
            <option value="BSD" >Bahamas Dollars</option>
            <option value="BBD"  >Barbados Dollars</option>
            <option value="BEF" >Belgium Francs</option>
            <option value="BMD" >Bermuda Dollars</option>
            <option value="BRR" >Brazil Real</option>
            <option value="BGL" >Bulgaria Lev</option>
            <option value="CAD" >Canada Dollars</option>
            <option value="CLP" >Chile Pesos</option>
            <option value="CNY" >China Yuan Renmimbi</option>
            <option value="CYP" >Cyprus Pounds</option>
            <option value="CSK" >Czech Republic Koruna</option>
            <option value="DKK" >Denmark Kroner</option>
            <option value="NLG" >Dutch Guilders</option>
            <option value="XCD" >Eastern Caribbean Dollars</option>
            <option value="EGP" >Egypt Pounds</option>
            <option value="FJD" >Fiji Dollars</option>
            <option value="FIM" >Finland Markka</option>
            <option value="FRF" >France Francs</option>
            <option value="DEM" >Germany Deutsche Marks</option>
            <option value="XAU" >Gold Ounces</option>
            <option value="GRD" >Greece Drachmas</option>
            <option value="HKD" >Hong Kong Dollars</option>
            <option value="HUF" >Hungary Forint</option>
            <option value="ISK" >Iceland Krona</option>     
            <option value="IDR" >Indonesia Rupiah</option>
            <option value="JPY" >Ireland Punt</option>
            <option value="JPY" >Israel New Shekels</option>
            <option value="JPY" >Italy Lira</option>
            <option value="JPY" >Jamaica Dollars</option>
            <option value="JPY" >Japan Yen</option>
            <option value="JOD" >Jordan Dinar</option>
            <option value="KRW" >Korea (South) Won</option>
            <option value="LBP" >Lebanon Pounds</option>
            <option value="LUF" >Luxembourg Francs</option>
            <option value="MYR" >Malaysia Ringgit</option>
            <option value="MXP" >Mexico Pesos</option>
            <option value="NLG" >Netherlands Guilders</option>
            <option value="NZD" >New Zealand Dollars</option>
            <option value="NOK" >Norway Kroner</option>
            <option value="PKR" >Pakistan Rupees</option>
            <option value="XPD" >Palladium Ounces</option>
            <option value="PHP" >Philippines Pesos</option>
            <option value="XPT" >Platinum Ounces</option>
            <option value="PLZ" >Poland Zloty</option>
            <option value="PTE" >Portugal Escudo</option>
            <option value="ROL" >Romania Leu</option>
            <option value="RUR">Russia Rubles</option>
            <option value="SAR">Saudi Arabia Riyal</option>
            <option value="XAG">Silver Ounces</option>
            <option value="SGD">Singapore Dollars</option>
            <option value="SKK">Slovakia Koruna</option>
            <option value="ZAR">South Africa Rand</option>
            <option value="KRW">South Korea Won</option>
            <option value="ESP">Spain Pesetas</option>
            <option value="XDR">Special Drawing Right (IMF)</option>
            <option value="SDD">Sudan Dinar</option>
            <option value="SEK">Sweden Krona</option>
            <option value="CHF">Switzerland Francs</option>
            <option value="TWD">Taiwan Dollars</option>
            <option value="THB">Thailand Baht</option>
            <option value="TTD">Trinidad and Tobago Dollars</option>
            <option value="TRL">Turkey Lira</option>
            <option value="VEB">Venezuela Bolivar</option>
            <option value="ZMK">Zambia Kwacha</option>
            <option value="EUR">Euro</option>
            <option value="XCD">Eastern Caribbean Dollars</option>
            <option value="XDR">Special Drawing Right (IMF)</option>
            <option value="XAG">Silver Ounces</option>
            <option value="XAU">Gold Ounces</option>
            <option value="XPD">Palladium Ounces</option>
            <option value="XPT">Platinum Ounces</option>
          </select>
        </div>
        <center><input type="submit" id="upload_product_data" value="{{ trans('app.Submit') }}" class="btn btn-default" /></center>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>



<section class="content">
	<div class="col-md-12">
		<div class="col-md-12">
			@if(isset($Tbl_invoice))        
			<form action="{{ route('quotebills.update',[app()->getLocale(),$Tbl_invoice->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" value="{{ $Tbl_invoice->id }}" name="id"> 
				@method('PUT')      
				@else
				<form action="{{ route('quotebills.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data" autocomplete="off">     
					@endif
					@csrf
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-8 col-sm-12 col-xs-12">
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5">
											<label>{{ trans('app.Client') }}</label>
										</div>
										<div class="col-md-6 col-sm-8">
											<select class="form-control select2" required  name="client_id"  id="client_id" onchange="client_chanage(this.value)" >
												<option selected disabled value="">{{ trans('app.Select One') }}</option>
												@foreach($client_data as $client_val)
												<option value="{{ $client_val->id }}" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->client_id == $client_val->id){echo "selected";}} ?> >{{ $client_val->company_name }}-{{ $client_val->contact_person }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-2 m-t-5">
											<div class="btn btn-primary" data-toggle="modal" data-target="#Add_client_modal">{{ trans('app.Add Client') }}</div>
										</div>
									</div>

                  <?php if(isset($Tbl_invoice))
                  { 
                    $client_sel_data = \App\Tbl_client::where(['id' => $Tbl_invoice->client_id])->first();
                  }
                  ?>

                  <div id="show_client_details" style="display:<?php if(isset($Tbl_invoice)){ echo ''; }else{ echo 'none'; } ?>;">
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5">
											<label>{{ trans('app.Client Details') }}</label>
										</div>
										<div class="col-md-6 col-sm-8">
											<input type="text"  class="form-control" required name="clientcompany_name" id="clientcompany_name"  value="@if(isset($Tbl_invoice)){{ $client_sel_data->company_name }}@endif">
										</div>
										<div class="col-md-2 m-t-5">
                      <input type="hidden" id="client_state_val" value="@if(isset($Tbl_invoice)){{ $client_sel_data->state }}@endif" />
											<label id="client_state">@if(isset($Tbl_invoice)){{ $client_sel_data->state }}@endif</label>
										</div>
									</div>
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5">
											<label></label>
										</div>
										<div class="col-md-6 col-sm-8">
											<input type="email"  class="form-control" name="client_email" required id="client_email"  value="@if(isset($Tbl_invoice)){{ $client_sel_data->email }}@endif">
										</div>
									</div>
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5"></div>
										<div class="col-md-6 col-sm-8">
											<input type="number" min="0" required class="form-control" name="client_number" id="client_number" value="@if(isset($Tbl_invoice)){{ $client_sel_data->contact_phone }}@endif">
										</div>
									</div>
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5"></div>
										<div class="col-md-6 col-sm-8">
											<input type="text" required class="form-control" name="client_gst" id="client_gst"  value="@if(isset($Tbl_invoice)){{ $client_sel_data->gstin }}@endif">
										</div>
									</div>
									<div class="form-group input-group">
										<div class="col-md-2 m-t-5"></div>
										<div class="col-md-6 col-sm-8">
											<textarea class="form-control" name="client_address" id="client_address">@if(isset($Tbl_invoice)){{ $client_sel_data->address }}@endif</textarea>
										</div>
									</div>
                </div>

								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Quote Bill number') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="text" required class="form-control" name="invoice_number"  value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->invoice_number }}@endif">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Quote Bill Date') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="text" required id="invoice_date"  class="form-control datepicker" name="invoice_date"  value="@if(isset($Tbl_invoice)){{ date('d-m-Y',strtotime($Tbl_invoice->invoice_date)) }}@endif">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Payment Terms') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<select class="form-control select2" name="payment_terms" onchange="payment_due_date(this.value)" required>
														<option selected disabled value=''>{{ trans('app.Select Payment Terms') }}</option>
                            <option value="0" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '0'){echo "selected";}} ?> >{{ trans('app.On Receipt') }}</option>
														<option value="7" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '7'){echo "selected";}} ?>>7 {{ trans('app.Days') }}</option>
														<option value="15" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '15'){echo "selected";}} ?>>15 {{ trans('app.Days') }}</option>
														<option value="30" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '30'){echo "selected";}} ?>>30 {{ trans('app.Days') }}</option>
														<option value="45" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '45'){echo "selected";}} ?>>45 {{ trans('app.Days') }}</option>
														<option value="60" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '60'){echo "selected";}} ?>>60 {{ trans('app.Days') }}</option>
														<option value="90" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->payment_terms == '90'){echo "selected";}} ?>>90 {{ trans('app.Days') }}</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Due Date') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="text" readonly  required class="form-control datepicker" name="due_date" id="due_date"  value="@if(isset($Tbl_invoice)){{ date('d-m-Y',strtotime($Tbl_invoice->due_date)) }}@endif">
												</div>
											</div>
										</div>
									</div>
                  <?php /*
									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.PO No') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<input type="number" min="0" required class="form-control" name="po_no"  value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->po_no }}@endif">
												</div>
											</div>
										</div>
									</div>
                  */?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group input-group">
												<div class="col-md-4 m-t-5">
													<label>{{ trans('app.Place Supply') }}</label>
												</div>
												<div class="col-md-8 col-sm-8">
													<select name="place_supply" id="place_supply" class="select2" onchange="chnage_supply_state(this.value);">
														<option value="Gujarat" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Gujarat'){echo "selected";}} ?> >Gujarat</option>
														<option value="Andaman and Nicobar Islands" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Andaman and Nicobar Islands'){echo "selected";}} ?>>Andaman and Nicobar Islands</option>
														<option value="Andhra Pradesh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Andhra Pradesh'){echo "selected";}} ?>>Andhra Pradesh</option>
														<option value="Arunachal Pradesh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Arunachal Pradesh'){echo "selected";}} ?>>Arunachal Pradesh</option>
														<option value="Assam" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Assam'){echo "selected";}} ?>>Assam</option>
														<option value="Bihar" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Bihar'){echo "selected";}} ?>>Bihar</option>
														<option value="Chandigarh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Chandigarh'){echo "selected";}} ?>>Chandigarh</option>
														<option value="Chhattisgarh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Chhattisgarh'){echo "selected";}} ?>>Chhattisgarh</option>
														<option value="Dadra and Nagar Haveli" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Dadra and Nagar Haveli'){echo "selected";}} ?>>Dadra and Nagar Haveli</option>
														<option value="Daman and Diu" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Daman and Diu'){echo "selected";}} ?>>Daman and Diu</option>
														<option value="Delhi" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Delhi'){echo "selected";}} ?>>Delhi</option>
														<option value="Goa" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Goa'){echo "selected";}} ?>>Goa</option>
														<option value="Haryana" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Haryana'){echo "selected";}} ?>>Haryana</option>
														<option value="Himachal Pradesh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Himachal Pradesh'){echo "selected";}} ?>>Himachal Pradesh</option>
														<option value="Jammu and Kashmir" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Jammu and Kashmir'){echo "selected";}} ?>>Jammu and Kashmir</option>
														<option value="Jharkhand" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Jharkhand'){echo "selected";}} ?>>Jharkhand</option>
														<option value="Karnataka" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Karnataka'){echo "selected";}} ?>>Karnataka</option>
														<option value="Kerala" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Kerala'){echo "selected";}} ?>>Kerala</option>
														<option value="Lakshadweep" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Lakshadweep'){echo "selected";}} ?>>Lakshadweep</option>
														<option value="Madhya Pradesh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Madhya Pradesh'){echo "selected";}} ?>>Madhya Pradesh</option>
														<option value="Maharashtra" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Maharashtra'){echo "selected";}} ?>>Maharashtra</option>
														<option value="Manipur" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Manipur'){echo "selected";}} ?>>Manipur</option>
														<option value="Meghalaya" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Meghalaya'){echo "selected";}} ?>>Meghalaya</option>
														<option value="Mizoram" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Mizoram'){echo "selected";}} ?>>Mizoram</option>
														<option value="Nagaland" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Nagaland'){echo "selected";}} ?>>Nagaland</option>
														<option value="Orissa" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Orissa'){echo "selected";}} ?>>Orissa</option>
														<option value="Pondicherry" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Pondicherry'){echo "selected";}} ?>>Pondicherry</option>
														<option value="Punjab" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Punjab'){echo "selected";}} ?>>Punjab</option>
														<option value="Rajasthan" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Rajasthan'){echo "selected";}} ?>>Rajasthan</option>
														<option value="Sikkim" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Sikkim'){echo "selected";}} ?>>Sikkim</option>
														<option value="Tamil Nadu" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Tamil Nadu'){echo "selected";}} ?>>Tamil Nadu</option>
														<option value="Tripura" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Tripura'){echo "selected";}} ?>>Tripura</option>
														<option value="Uttaranchal" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Uttaranchal'){echo "selected";}} ?>>Uttaranchal</option>
														<option value="Uttar Pradesh" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'Uttar Pradesh'){echo "selected";}} ?>>Uttar Pradesh</option>
														<option value="West Bengal" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->place_supply == 'West Bengal'){echo "selected";}} ?>>West Bengal</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="card">
										<!-- /.card-header -->
										<input type="hidden" id="total_product_add" name="total_product_add" value="<?php if(isset($Tbl_invoice_product)){ echo count($Tbl_invoice_product); }else{ echo 0;} ?>">
										<div class="card-body table-responsive p-0">
											<table class="table table-hover" id="product_table">
												<tbody><tr style="background-color: #e9ecef;">
													<th>{{ trans('app.No') }}</th>
													<th style="width: 20%;">{{ trans('app.Item Name') }}</th>
													<th>{{ trans('app.HSN/SAC') }}</th>
													<th>{{ trans('app.QTY') }}</th>
													<th>{{ trans('app.Price') }}</th>
													<th>{{ trans('app.Discount') }} (%)</th>
													<th id="hide_cgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>" >{{ trans('app.CGST') }}</th>
													<th id="hide_sgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">{{ trans('app.SGST') }}</th>
													<th id="hide_igst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">{{ trans('app.IGST') }}</th>
													<th style="width: 10%;">{{ trans('app.Total') }}</th>
													<th>{{ trans('app.Option') }}</th>
												</tr>


                        <?php 
                        if(isset($Tbl_invoice_product)){
                          $i = '1';
                          foreach ($Tbl_invoice_product as $key) {
                        ?>
                            <tr id="check_remove_product1">
                                <td>{{ $i }}</td>
                                <td>
                                  <input type="hidden" name="remove_product{{ $i }}" id="remove_product{{ $i }}" value="1">
                                  <input type="hidden" class="form-control" name="product_id{{ $i }}" value="{{ $key->product_id }}">{{ $key->product_name }}
                                </td>
                                <td>
                                  <input type="hidden" class="form-control" name="hsn{{ $i }}" id="hsn{{ $i }}" value="{{ $key->hsn }}">{{ $key->hsn }}
                                </td>                 
                                <td>
                                  <input type="hidden" min="0" class="form-control" onkeyup="chnage_in_product_data_update('{{ $i }}')" id="qty{{ $i }}" name="qty{{ $i }}" value="{{ $key->qty }}"><div id="dis_qty{{ $i }}">{{ $key->qty }}</div>
                                </td>
                                <td>
                                  <input type="hidden" min="0" onkeyup="chnage_in_product_data_update('{{ $i }}')" class="form-control" id="price{{ $i }}" name="price{{ $i }}" value="{{ $key->price }}"><div id="dis_price{{ $i }}">{{ $key->price }}</div>
                                </td>
                                <td>
                                  <input type="hidden" min="0" class="form-control" onkeyup="chnage_in_product_data_update('{{ $i }}')" id="discount{{ $i }}" name="discount{{ $i }}" value="{{ $key->discount }}"><div id="dis_discount{{ $i }}">{{ $key->discount }}</div>
                                </td>
                                <td style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">
                                  <input type="hidden" min="0" class="form-control" onkeyup="chnage_in_product_data_update('{{ $i }}')" id="cgst{{ $i }}" name="cgst{{ $i }}" value="{{ $key->cgst }}"><div id="dis_cgst{{ $i }}">{{ $key->cgst }}</div>
                                </td>

                                <td style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>"><input type="hidden" min="0" onkeyup="chnage_in_product_data_update('{{ $i }}')" class="form-control" id="sgst{{ $i }}" name="sgst{{ $i }}" value="{{ $key->sgst }}"><div id="dis_sgst{{ $i }}">{{ $key->sgst }}</div>
                                </td>


                                <td style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">
                                  <input type="hidden" min="0" class="form-control" onkeyup="chnage_in_product_data_update('{{ $i }}')" id="igst{{ $i }}" name="igst{{ $i }}" value="{{ $key->igst }}"><div id="dis_igst{{ $i }}">{{ $key->igst }}</div>
                                </td>
                                <td>
                                  <input type="hidden" class="form-control" id="total{{ $i }}" name="total{{ $i }}" value="{{ $key->total_amount }}"><div id="dis_total{{ $i }}">{{ $key->total_amount }}</div>
                                </td>
                                <td class="row">
                                  <div class="btn-sm btn-primary btn-xs" id="up_btnedit{{ $i }}" onclick="chnage_for_update('{{ $i }}')"><i class="fa fa-edit"></i></div><div class="btn-sm btn-primary btn-xs" onclick="update_product('{{ $i }}')" style="display:none;" id="up_btnupdate{{ $i }}">Update</div><div class="btn-sm btn-danger btn-xs" id="up_btndelete{{ $i }}" onclick="remove_product('{{ $i }}')"><i class="fa fa-trash-o"></i></div>
                                </td>
                              </tr>
                          <?php $i++;}} ?>
                        

												<tr style="background-color: whitesmoke;">
													<td>{{ trans('app.No') }}</td>
													<td><select class="form-control select2" id="read_product_id" onchange="change_product(this.value);">
														<option selected disabled value="">{{ trans('app.Select One') }}</option>
														@foreach($product_data as $product_val)
														<option value="{{ $product_val->id }}"  >{{ $product_val->name }}</option>
														@endforeach
													</select>
                          <div class="btn-sm btn-primary mt-1" data-toggle="modal" data-target="#Add_product_modal" style="text-align: center;">{{ trans('app.Add Product') }}</div>
												</td>
												<td><input type="hidden" id="read_hsn" class="form-control"><div id="read_hsn_display" class="mt-2"></div></td>
												<td><input type="number" min="1" id="read_qty" class="form-control" onkeyup="chnage_in_product_data();"></td>
												<td><input type="number" min="0" id="read_price" class="form-control" onkeyup="chnage_in_product_data();"></td>
												<td><input type="number" min="0" id="read_discount" class="form-control" onkeyup="chnage_in_product_data();"></td>

												<td id="tdhide_cgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>"><input type="number" min="0" id="read_cgst" class="form-control" onkeyup="chnage_in_product_data();" value="0"></td>

												<td id="tdhide_sgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>"><input type="number" min="0" id="read_sgst" class="form-control" onkeyup="chnage_in_product_data();" value="0"></td>

												<td id="tdhide_igst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>"><input type="number" min="0" id="read_igst" class="form-control" onkeyup="chnage_in_product_data();" value="0"></td>

												<td><input type="hidden" id="read_total" class="form-control" value="0"><div id="read_total_display"  class="mt-2">0</div></td>
												<td><button class="btn-sm btn-primary mb-1" id="add" type="button" onclick="add_new_product();">{{ trans('app.ADD') }}</button></td>
											</tr>
										</tbody></table>
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.card -->
							</div>
              <div class="col-12 row">
                <div class="col-6">
                  <label>{{ trans('app.Notes') }}:</label>
                  <textarea class="form-control" name="note" required>@if(isset($Tbl_invoice)){{ $Tbl_invoice->note }}@endif</textarea>
                </div>
                <div class="col-6">
                  <p class="lead">{{ trans('app.Total Details') }}</p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th><b>{{ trans('app.Total') }}</b></th>
                        <td><input type="hidden" name="total_total" id="total_total" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_amount }}@else{{ 0 }}@endif"><div id="read_total_total">@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_amount }}@else{{ 0 }}@endif</div></td>
                      </tr>

                      <tr id="totalhide_cgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">
                        <th><b>{{ trans('app.CGST') }}</b></th>
                        <td><input type="hidden" name="totalcgst" id="totalcgst" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_cgst }}@else{{ 0 }}@endif"><div id="read_totalcgst">@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_cgst }}@else{{ 0 }}@endif</div></td>
                      </tr>

                      <tr id="totalhide_sgst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo '';}else{echo 'none'; } } ?>">
                        <th><b>{{ trans('app.SGST') }}</b></th>
                        <td><input type="hidden" name="totalsgst" id="totalsgst" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_sgst }}@else{{ 0 }}@endif"><div id="read_totalsgst">@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_sgst }}@else{{ 0 }}@endif</div></td>
                      </tr>

                      <tr id="totalhide_igst" style="display:<?php if(isset($Tbl_invoice)){ if($Tbl_invoice->place_supply == $client_sel_data->state){echo 'none';}else{echo ''; } } ?>">
                        <th><b>{{ trans('app.IGST') }}</b></th>
                        <td><input type="hidden" name="totaligst" id="totaligst" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_igst }}@else{{ 0 }}@endif"><div id="read_totaligst">@if(isset($Tbl_invoice)){{ $Tbl_invoice->total_igst }}@else{{ 0 }}@endif</div></td>
                      </tr>

                      <tr>
                        <th>
                          <select name="extra_charge" class="form-control" required>
                            <option value="Shipping Charges" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Shipping Charges'){echo "selected";}} ?> >Shipping Charges</option>
                            <option value="Convenience Fee" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Convenience Fee'){echo "selected";}} ?>>Convenience Fee</option>
                            <option value="Courier Charges" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Courier Charges'){echo "selected";}} ?>>Courier Charges</option>
                            <option value="Delivery Charges" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Delivery Charges'){echo "selected";}} ?>>Delivery Charges</option>
                            <option value="Gratuity" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Gratuity'){echo "selected";}} ?>>Gratuity</option>
                            <option value="Round Off" <?php if(isset($Tbl_invoice)){if($Tbl_invoice->other_charge_type == 'Round Off'){echo "selected";}} ?>>Round Off</option>
                          </select>
                        </th>
                        <td ><input type="number" min="0" required class="form-control" name="extra_charge_amount" id="extra_charge_amount" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->charge_amount }}@else{{ 0 }}@endif" onkeyup="final_result()"></td>
                      </tr>
                      <tr>
                        <th><b style="color: green;">{{ trans('app.Net Amount') }}</b></th>
                        <td><input type="hidden" id="final_netamount" name="final_netamount" value="@if(isset($Tbl_invoice)){{ $Tbl_invoice->net_amount }}@else{{ 0 }}@endif"><div id="read_final_netamount" style="color: green;">@if(isset($Tbl_invoice)){{ $Tbl_invoice->net_amount }}@else{{ 0 }}@endif</div></td>
                      </tr>
                    </tbody></table>
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
function image_readURL(input) {
	if (input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#image').show();
			$('#image').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}}

function client_chanage(id)
{
	$.ajax({  
		url: "<?= route('invoicesclientinfo',app()->getLocale()) ?>",
		type: 'POST',
		data: {id:id,"_token":"<?= csrf_token() ?>"},
		success:function(data)  
		{
			var new_data = JSON.parse(data);
			$("#client_state").html(new_data.state);
      $("#client_state_val").val(new_data.state);
      var supply_state = $('#place_supply :selected').val();
      if(new_data.state == supply_state)
      {
        $("#totalhide_igst").hide();
        $("#hide_igst").hide();
        $("#tdhide_igst").hide();
      }
      else
      {
        $("#totalhide_sgst").hide();
        $("#totalhide_cgst").hide();
        $("#tdhide_sgst").hide();
        $("#tdhide_cgst").hide();
        $("#hide_sgst").hide();
        $("#hide_cgst").hide();
      }
      $("#totaligst").val('0');
      $("#read_igst").val('0');
      $("#read_cgst").val('0');
      $("#read_sgst").val('0');
      $("#totalsgst").val('0');
      $("#totalcgst").val('0');
			$("#clientcompany_name").val(new_data.company_name);
			$("#client_number").val(new_data.phone);
			$("#client_gst").val(new_data.gstin);
			$("#client_address").val(new_data.address);
			$("#client_email").val(new_data.email);
      $("#show_client_details").show();
      final_result();
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
  			$("#read_price").val(new_data.sale_price);
  			$("#read_sgst").val('0');
  			$("#read_cgst").val('0');
  			$("#read_igst").val('0');
  			$("#read_discount").val('0');
  		}
  	});
  }
}

function chnage_in_product_data()
{
	var id = $('#read_product_id :selected').val();
	var hsn = $("#read_hsn").val();
	var price = $("#read_price").val();
	var qty = $("#read_qty").val();
	var discount = $("#read_discount").val();
	var sgst = $("#read_sgst").val();
	var cgst = $("#read_cgst").val();
	var igst = $("#read_igst").val();
	if(id == '')
	{

		swal("Please select Product first.", "", "error");
		$('#read_product_id').focus();
	}
	else
	{
		if(hsn != '' && price!= '' && qty!= '' && discount!= '')
		{
			var stax = ((sgst * price)/100);
			var ctax = ((cgst * price)/100);
			var itax = ((igst * price)/100);
			var total_tax = +stax + +ctax + +itax + +price;
			var amount = (total_tax * qty);
      var discount = $("#read_discount").val();
      var discount_amount = ((discount * amount)/100);
      var finalamount = (amount - discount_amount);
			$("#read_total").val(parseFloat(finalamount).toFixed(2));
      $("#read_total_display").html(parseFloat(finalamount).toFixed(2));
			
		}
	}
}

function add_new_product()
{
	var id = $('#read_product_id :selected').val();
	var no = $("#total_product_add").val();
	var hsn = $("#read_hsn").val();
	var price = $("#read_price").val();
	var qty = $("#read_qty").val();
	var discount = $("#read_discount").val();
	var sgst = $("#read_sgst").val();
	var cgst = $("#read_cgst").val();
	var igst = $("#read_igst").val();
	var total = $("#read_total").val();
	if(id == '')
	{
		swal("Please select Product first.", "", "error");
		$('#read_product_id').focus();
	}
	else
	{
		if(hsn != '' && price!= '' && qty!= '' && discount!= '' && sgst != '' && cgst != '' && igst != '')
		{
			$.ajax({  
				url: "<?= route('invoicesproductinfo',app()->getLocale()) ?>",
				type: 'POST',
				data: {id:id,"_token":"<?= csrf_token() ?>"},
				success:function(responce)  
				{
					var new_data = JSON.parse(responce);
					var check_qty = new_data.quantity;
					if(parseFloat(check_qty) < parseFloat(qty))
					{
						swal("QTY Only "+check_qty+" available right now.", "", "error");
						$("#read_qty").focus();
					}
					else
					{
						no++;
						$("#total_product_add").val(no);

            var client_state = $('#client_state_val').val();
            var supply_state = $('#place_supply :selected').val();
            if(client_state == supply_state)
            {
              var showigst = 'none';
              var showsgst = '';
              var showcgst = '';
            }
            else
            {
              var showigst = '';
              var showsgst = 'none';
              var showcgst = 'none';
            }

						var data = '<tr id="check_remove_product'+no+'"><td>'+no+'</td><td><input type="hidden" name="remove_product'+no+'" id="remove_product'+no+'" value="1"><input type="hidden" class="form-control" name="product_id'+no+'" value="'+id+'">'+new_data.name+'</td><td><input type="hidden" class="form-control" name="hsn'+no+'" id="hsn'+no+'" value="'+hsn+'">'+hsn+'</td><td><input type="hidden"  min="0" class="form-control" onkeyup="chnage_in_product_data_update('+no+')" id="qty'+no+'" name="qty'+no+'" value="'+qty+'"><div id="dis_qty'+no+'">'+qty+'</div></td><td><input type="hidden"  min="0" onkeyup="chnage_in_product_data_update('+no+')" class="form-control" id="price'+no+'" name="price'+no+'" value="'+price+'"><div id="dis_price'+no+'">'+price+'</div></td><td><input type="hidden"  min="0" class="form-control" onkeyup="chnage_in_product_data_update('+no+')"  id="discount'+no+'" name="discount'+no+'" value="'+discount+'"><div id="dis_discount'+no+'">'+discount+'</div></td><td style="display:'+showcgst+'"><input type="hidden"  min="0" class="form-control" onkeyup="chnage_in_product_data_update('+no+')" id="cgst'+no+'" name="cgst'+no+'"  value="'+cgst+'"><div id="dis_cgst'+no+'" >'+cgst+'</div></td><td style="display:'+showsgst+'"><input type="hidden"  min="0" onkeyup="chnage_in_product_data_update('+no+')" class="form-control" id="sgst'+no+'" name="sgst'+no+'"  value="'+sgst+'"><div id="dis_sgst'+no+'" >'+sgst+'<div></td><td style="display:'+showigst+'"><input type="hidden"  min="0" class="form-control" onkeyup="chnage_in_product_data_update('+no+')" id="igst'+no+'" name="igst'+no+'"  value="'+igst+'"><div id="dis_igst'+no+'" >'+igst+'</div></td><td><input type="hidden" class="form-control" id="total'+no+'" name="total'+no+'" value="'+total+'"><div id="dis_total'+no+'">'+total+'</div></td><td class="row"><div class="btn-sm btn-primary btn-xs" id="up_btnedit'+no+'" onclick="chnage_for_update('+no+')"><i class="fa fa-edit"></i></div><div class="btn-sm btn-primary btn-xs" onclick="update_product('+no+')" style="display:none;" id="up_btnupdate'+no+'">Update</div><div class="btn-sm btn-danger btn-xs" id="up_btndelete'+no+'" onclick="remove_product('+no+')"><i class="fa fa-trash-o"></i></div></td>';
						$('#product_table tr:last').prev().after(data);
						$('#read_product_id').prop('selectedIndex', 0);
						$("#read_hsn").val('');
            $("#read_hsn_display").html('');
						$("#read_price").val('');
						$("#read_qty").val('');
						$("#read_discount").val('');
						$("#read_sgst").val('');
						$("#read_cgst").val('');
						$("#read_igst").val('');
						$("#read_total").val('');
            $("#read_total_display").html('0');
            $("#place_supply").prop('readonly',true);
						final_result();
					}
				}
			});
		}
		else
		{
			swal("Please Fill all field before Add.", "", "error");
		}
	}
}


function final_result()
{
	var total_total = 0;
	var final_netamount = 0;
	var totalcgst = 0;
	var totalsgst = 0;
	var totaligst = 0;
	var total_product = $("#total_product_add").val();
	for (var i = 1; i <= total_product; i++) {
		if($("#remove_product"+i).val() == '1')
		{
			total_total += parseFloat($("#total"+i).val());
			totalcgst += parseFloat((($("#qty"+i).val() * $("#price"+i).val()) * $("#cgst"+i).val())/100);
			totalsgst += parseFloat((($("#qty"+i).val() * $("#price"+i).val()) * $("#sgst"+i).val())/100);
			totaligst += parseFloat((($("#qty"+i).val() * $("#price"+i).val()) * $("#igst"+i).val())/100);
		}
	}

	$("#total_total").val(parseFloat(total_total).toFixed(2));
	$("#read_total_total").html(parseFloat(total_total).toFixed(2));
	$("#totalcgst").val(parseFloat(totalcgst).toFixed(2));
	$("#read_totalcgst").html(parseFloat(totalcgst).toFixed(2));
	$("#totalsgst").val(parseFloat(totalsgst).toFixed(2));
	$("#read_totalsgst").html(parseFloat(totalsgst).toFixed(2));
	$("#totaligst").val(parseFloat(totaligst).toFixed(2));
	$("#read_totaligst").html(parseFloat(totaligst).toFixed(2));


	var final_amount = +$("#extra_charge_amount").val() + +total_total;
	$("#final_netamount").val(parseFloat(final_amount).toFixed(2));
	$("#read_final_netamount").html(parseFloat(final_amount).toFixed(2));
}

function chnage_for_update(no)
{
	$("#dis_qty"+no).html('');
	$("#dis_price"+no).html('');
	$("#dis_discount"+no).html('');
	$("#dis_sgst"+no).html('');
	$("#dis_cgst"+no).html('');
	$("#dis_igst"+no).html('');
	$("#qty"+no).prop("type", "number");
	$("#price"+no).prop("type", "number");
	$("#discount"+no).prop("type", "number");
	$("#cgst"+no).prop("type", "number");
	$("#sgst"+no).prop("type", "number");
	$("#igst"+no).prop("type", "number");
	$("#up_btnedit"+no).hide();
	$("#up_btndelete"+no).hide();
	$("#up_btnupdate"+no).show();
}

function update_product(no)
{
	var price = $("#price"+no).val();
	var qty = $("#qty"+no).val();
	var discount = $("#discount"+no).val();
	var sgst = $("#sgst"+no).val();
	var cgst = $("#cgst"+no).val();
	var igst = $("#igst"+no).val();
	var total = $("#total"+no).val();
	if(price != '' && qty != '' && discount != '' && sgst != '' && cgst != '' && igst != '')
	{
		$("#dis_qty"+no).html(qty);
		$("#dis_price"+no).html(price);
		$("#dis_discount"+no).html(discount);
		$("#dis_sgst"+no).html(sgst);
		$("#dis_cgst"+no).html(cgst);
		$("#dis_igst"+no).html(igst);
		$("#dis_total"+no).html(total);
		$("#qty"+no).prop("type", "hidden");
		$("#price"+no).prop("type", "hidden");
		$("#discount"+no).prop("type", "hidden");
		$("#cgst"+no).prop("type", "hidden");
		$("#sgst"+no).prop("type", "hidden");
		$("#igst"+no).prop("type", "hidden");
		$("#total"+no).prop("type", "hidden");
		$("#up_btnedit"+no).show();
		$("#up_btndelete"+no).show();
		$("#up_btnupdate"+no).hide();
	}
	else
	{
		swal("Please Fill all field before Update.", "", "error");
	}
}

function chnage_in_product_data_update(no)
{
	var id = $('#product_id'+no+' :selected').val();
	var hsn = $("#hsn"+no).val();
	var price = $("#price"+no).val();
	var qty = $("#qty"+no).val();
	var discount = $("#discount"+no).val();
	var sgst = $("#sgst"+no).val();
	var cgst = $("#cgst"+no).val();
	var igst = $("#igst"+no).val();
	if(hsn != '' && price!= '' && qty!= '' && discount!= '')
	{
		var stax = ((sgst * price)/100);
		var ctax = ((cgst * price)/100);
		var itax = ((igst * price)/100);
		var total_tax = +stax + +ctax + +itax + +price;
		var amount = (total_tax * qty);
    var discount = $("#discount"+no).val();
    var discount_amount = ((discount * amount)/100);
    var finalamount = (amount - discount_amount);
		$("#total"+no).val(parseFloat(finalamount).toFixed(2));
    $("#dis_total"+no).html(parseFloat(finalamount).toFixed(2));
		final_result();
	}
}

function remove_product(no)
{
	swal({
		title: "Are you sure remove product?",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$("#check_remove_product"+no).hide();
			$("#remove_product"+no).val('0');
			final_result();
			swal("product has been removed!", {
				icon: "success",
			});
		}
	});
}

function payment_due_date(val)
{  
if($("#invoice_date").val() == '')
{
  swal("Please Select invoice date!", {
        icon: "error",
      });
  $("#invoice_date").focus();
}
else
{
  var ds = $("#invoice_date").val().split("-");
  var startDate = new Date(ds[2], ds[1]-1, ds[0]); 
  var daysAhead = val;
  startDate.setTime(startDate.getTime()+(daysAhead*24*60*60*1000));
  var futureDate = startDate.getDate()+"-"+(startDate.getMonth()+1)+"-"+startDate.getFullYear();
  futureDate = futureDate.replace(/^(\d{1}\/)/,"0$1").replace(/(\d{2}\/)(\d{1}\/)/,"$10$2");
  $("#due_date").val(futureDate); 
} 

}


$(document).ready(function (e){
	$("#form_client").on('submit',(function(e) {
		e.preventDefault();
		var sdata = new FormData(this);
		console.log(sdata);
		$.ajax({
			url: "<?= route('invoicesadd_client',app()->getLocale()) ?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
            cache: false,
   			processData:false,
			success: function(data){
				var new_data = JSON.parse(data);
				var id = new_data.id;
				var name = new_data.company_name;
				var newState = new Option(name, id, false, false);
        		$("#client_id").append(newState).trigger('change');
        		$("#form_client")[0].reset();
        		$("#Add_client_modal").modal('hide');
        		swal("Client Added Done.", {
				icon: "success",
			});
			}        
		});
	}));
});

$(document).ready(function (e){
  $("#form_product").on('submit',(function(e) {
    e.preventDefault();
    var sdata = new FormData(this);
    console.log(sdata);
    $.ajax({
      url: "<?= route('invoicesadd_product',app()->getLocale()) ?>",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
            cache: false,
        processData:false,
      success: function(data){
        var new_data = JSON.parse(data);
        var id = new_data.id;
        var name = new_data.name;
        var newState = new Option(name, id, false, false);
            $("#read_product_id").append(newState).trigger('change');
            $("#form_product")[0].reset();
            $("#Add_product_modal").modal('hide');
            swal("Product Added Done.", {
        icon: "success",
      });
      }        
    });
  }));
});



function chnage_supply_state(state)
{
  var client_state = $('#client_state_val').val();
  var id = $('#client_id :selected').val();
  if(id == '')
  {
    swal("Please select Client first.", "", "error");
    $('#client_id').focus();
  }
  else
  {
    if(client_state == state)
    {
      $("#totalhide_igst").hide();
      $("#hide_igst").hide();
      $("#tdhide_igst").hide();
      $("#totalhide_sgst").show();
      $("#totalhide_cgst").show();
      $("#tdhide_sgst").show();
      $("#tdhide_cgst").show();
      $("#hide_sgst").show();
      $("#hide_cgst").show();
    }
    else
    {
     $("#totalhide_igst").show();
     $("#hide_igst").show();
     $("#tdhide_igst").show();

     $("#totalhide_sgst").hide();
     $("#totalhide_cgst").hide();
     $("#tdhide_sgst").hide();
     $("#tdhide_cgst").hide();
     $("#hide_sgst").hide();
     $("#hide_cgst").hide();
   }
   $("#totaligst").val('0');
   $("#read_igst").val('0');
   $("#read_cgst").val('0');
   $("#read_sgst").val('0');
   $("#totalsgst").val('0');
   $("#totalcgst").val('0');
 }
}

</script>


