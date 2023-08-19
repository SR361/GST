@extends('layouts.master') 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ trans('app.Settings') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ trans('app.Home') }}</a></li>
              <li class="breadcrumb-item active">{{ trans('app.Settings') }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
       <div class="row">

        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ trans('app.Settings') }}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a class="nav-link active" href="#Profile_tab" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.Profile') }}`);"><i class="fa fa-user mr-2"></i>{{ trans('app.Profile') }}</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#general" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.General') }}`);"><i class="fa fa-gear fa-spin mr-2"></i>{{ trans('app.General') }}</a>
                </li>

                <li class="nav-item">
                 <a class="nav-link" href="#invoice" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.Invoice') }}`);"><i class="fas fa-file-invoice mr-2"></i>{{ trans('app.Invoice') }}</a>
               </li>

                <li class="nav-item">
                 <a class="nav-link" href="#supply_bill" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.Supply Bill') }}`);"><i class="fa fa-files-o mr-2"></i>{{ trans('app.Supply Bill') }}</a>
               </li>

                <li class="nav-item">
                 <a class="nav-link" href="#quote_bill" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.Quote Bill') }}`);"><i class="fas fa-money-bill-alt mr-2"></i>{{ trans('app.Quote Bill') }}</a>
               </li>    

                <li class="nav-item">
                 <a class="nav-link" href="#purchase_orders" data-toggle="tab" onclick="change_tab_name(`{{ trans('app.Purchase Orders') }}`);"><i class="fa fa-shopping-cart mr-2"></i>{{ trans('app.Purchase Orders') }}</a>
               </li>

             </ul>
           </div>
           
         </div>
         
       </div>



       <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><span id="chnage_tab_name">Profile</span></h3>
          </div>

          <div class="tab-content">
            <div class="card-body tab-pane active" id="Profile_tab">
              <form action="{{ route('setting_update_user',app()->getLocale()) }}" method="POST"  id="form_data" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" value="{{ $user->id }}" name="id"> 
                @csrf  
              <div class="col-md-12 row">
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="exampleInputFile">{{ trans('app.Profile') }}</label>
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-xs-4">
                        <span class="btn btn-primary btn-file"> {{ trans('app.Browse') }}
                          <input type="file" class="form-control btn" accept="image/png,image/jpg,image/jpeg" name="logo" onchange="image_readURL(this);" id="exampleInputFile" <?php if($user->logo == ''){ echo 'required'; } ?>>
                        </span>
                      </div>
                      <div class="col-lg-4 col-md-4 col-xs-4">
                        @if(isset($user))  
                        <img id="image" src="{{ asset('/public/images/users/'.$user->logo) }}" alt="" height="160" width="160" style="height: 100px;width: 100px;border-radius: 50%;"/>             
                        @else
                        <img id="image" src="" alt="" height="160" width="160" style="display: none;height: 100px;width: 100px;border-radius: 50%;" />   
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.Company Name') }}</label>
                    <input type="text"  class="form-control" name="company_name"  value="@if(isset($user)){{ $user->company_name }}@endif" required>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-4" style="color: #212529;"><b>{{ trans('app.State') }}</b></div>
                    <div class="col-md-8">
                      <select name="state" class="form-control select2" id="stateId" required>
                        <option value="Gujarat" <?php if(isset($user)){if($user->state == 'Gujarat'){echo "selected";}}?> >Gujarat</option>

                        <option value="Andaman and Nicobar Islands" <?php if(isset($user)){if($user->state == 'Andaman and Nicobar Islands'){echo "selected";}}?> >Andaman and Nicobar Islands</option>

                        <option value="Andhra Pradesh" <?php if(isset($user)){if($user->state == 'Andhra Pradesh'){echo "selected";}}?>>Andhra Pradesh</option>

                        <option value="Arunachal Pradesh" <?php if(isset($user)){if($user->state == 'Arunachal Pradesh'){echo "selected";}}?>>Arunachal Pradesh</option>

                        <option value="Assam" <?php if(isset($user)){if($user->state == 'Assam'){echo "selected";}}?>>Assam</option>

                        <option value="Bihar" <?php if(isset($user)){if($user->state == 'Bihar'){echo "selected";}}?> >Bihar</option>

                        <option value="Chandigarh" <?php if(isset($user)){if($user->state == 'Chandigarh'){echo "selected";}}?> >Chandigarh</option>

                        <option value="Chhattisgarh" <?php if(isset($user)){if($user->state == 'Chhattisgarh'){echo "selected";}}?> >Chhattisgarh</option>

                        <option value="Dadra and Nagar Haveli"  <?php if(isset($user)){if($user->state == 'Dadra and Nagar Haveli'){echo "selected";}}?> >Dadra and Nagar Haveli</option>

                        <option value="Daman and Diu" <?php if(isset($user)){if($user->state == 'Daman and Diu'){echo "selected";}}?> >Daman and Diu</option>

                        <option value="Delhi" <?php if(isset($user)){if($user->state == 'Delhi'){echo "selected";}}?> >Delhi</option>

                        <option value="Goa" <?php if(isset($user)){if($user->state == 'Goa'){echo "selected";}}?> >Goa</option>

                        <option value="Haryana" <?php if(isset($user)){if($user->state == 'Haryana'){echo "selected";}}?> >Haryana</option>

                        <option value="Himachal Pradesh" <?php if(isset($user)){if($user->state == 'Himachal Pradesh'){echo "selected";}}?> >Himachal Pradesh</option>

                        <option value="Jammu and Kashmir" <?php if(isset($user)){if($user->state == 'Jammu and Kashmir'){echo "selected";}}?> >Jammu and Kashmir</option>

                        <option value="Jharkhand" <?php if(isset($user)){if($user->state == 'Jharkhand'){echo "selected";}}?> >Jharkhand</option>

                        <option value="Karnataka" <?php if(isset($user)){if($user->state == 'Karnataka'){echo "selected";}}?> >Karnataka</option>

                        <option value="Kerala" <?php if(isset($user)){if($user->state == 'Kerala'){echo "selected";}}?> >Kerala</option>

                        <option value="Lakshadweep" <?php if(isset($user)){if($user->state == 'Lakshadweep'){echo "selected";}}?> >Lakshadweep</option>

                        <option value="Madhya Pradesh" <?php if(isset($user)){if($user->state == 'Madhya Pradesh'){echo "selected";}}?>>Madhya Pradesh</option>

                        <option value="Maharashtra" <?php if(isset($user)){if($user->state == 'Maharashtra'){echo "selected";}}?> >Maharashtra</option>

                        <option value="Manipur" <?php if(isset($user)){if($user->state == 'Manipur'){echo "selected";}}?> >Manipur</option>

                        <option value="Meghalaya" <?php if(isset($user)){if($user->state == 'Meghalaya'){echo "selected";}}?> >Meghalaya</option>

                        <option value="Mizoram" <?php if(isset($user)){if($user->state == 'Mizoram'){echo "selected";}}?> >Mizoram</option>

                        <option value="Nagaland" <?php if(isset($user)){if($user->state == 'Nagaland'){echo "selected";}}?> >Nagaland</option>

                        <option value="Orissa" <?php if(isset($user)){if($user->state == 'Orissa'){echo "selected";}}?> >Orissa</option>

                        <option value="Pondicherry" <?php if(isset($user)){if($user->state == 'Pondicherry'){echo "selected";}}?> >Pondicherry</option>

                        <option value="Punjab" <?php if(isset($user)){if($user->state == 'Punjab'){echo "selected";}}?> >Punjab</option>

                        <option value="Rajasthan" <?php if(isset($user)){if($user->state == 'Rajasthan'){echo "selected";}}?> >Rajasthan</option>

                        <option value="Sikkim" <?php if(isset($user)){if($user->state == 'Sikkim'){echo "selected";}}?> >Sikkim</option>

                        <option value="Tamil Nadu" <?php if(isset($user)){if($user->state == 'Tamil Nadu'){echo "selected";}}?> >Tamil Nadu</option>

                        <option value="Tripura" <?php if(isset($user)){if($user->state == 'Tripura'){echo "selected";}}?> >Tripura</option>

                        <option value="Uttaranchal" <?php if(isset($user)){if($user->state == 'Uttaranchal'){echo "selected";}}?> >Uttaranchal</option>

                        <option value="Uttar Pradesh" <?php if(isset($user)){if($user->state == 'Uttar Pradesh'){echo "selected";}}?> >Uttar Pradesh</option>

                        <option value="West Bengal" <?php if(isset($user)){if($user->state == 'West Bengal'){echo "selected";}}?> >West Bengal</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.PIN') }}</label>
                    <input type="text"  class="form-control" name="pin"  value="@if(isset($user)){{ $user->pin }}@endif" required>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.GSTIN') }}</label>
                    <input type="text"  class="form-control" name="gstin"  value="@if(isset($user)){{ $user->gstin }}@endif" required>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group input-group">
                    <label class="mt-1" style="width: 33.33%;">{{ trans('app.Address') }}</label>
                    <textarea class="form-control" name="address" required>@if(isset($user)){{ $user->address }}@endif</textarea>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.Email') }}</label>
                    <input type="email"  class="form-control" name="email"  value="@if(isset($user)){{ $user->email }}@endif" required disabled>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.Phone') }}</label>
                    <input type="tel"  class="form-control" name="phone"  value="@if(isset($user)){{ $user->phone }}@endif" required>
                  </div>

                  <div class="form-group input-group">
                    <label class="mr-1" style="width: 33.33%;">{{ trans('app.Contact Name') }}</label>
                    <input type="tel"  class="form-control" name="name"  value="@if(isset($user)){{ $user->name }}@endif" required>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-4" style="color: #212529;"><b>{{ trans('app.Currency') }}</b></div>
                    <div class="col-md-8">
                      <select class="form-control select2"  name="currency">
                        <option value="INR"<?php if(isset($user)){if($user->currency == 'INR'){echo "selected";}}?> >India Rupees</option>

                        <option value="USD" <?php if(isset($user)){if($user->currency == 'USD'){echo "selected";}}?>>United States Dollars</option>

                        <option value="EUR" <?php if(isset($user)){if($user->currency == 'EUR'){echo "selected";}}?> >Euro</option>

                        <option value="GBP" <?php if(isset($user)){if($user->currency == 'GBP'){echo "selected";}}?> >United Kingdom Pounds</option>

                        <option value="DZD"<?php if(isset($user)){if($user->currency == 'DZD'){echo "selected";}}?> >Algeria Dinars</option>

                        <option value="ARP"<?php if(isset($user)){if($user->currency == 'ARP'){echo "selected";}}?> >Argentina Pesos</option>

                        <option value="AUD"<?php if(isset($user)){if($user->currency == 'AUD'){echo "selected";}}?> >Australia Dollars</option>

                        <option value="ATS"<?php if(isset($user)){if($user->currency == 'ATS'){echo "selected";}}?> >Austria Schillings</option>

                        <option value="BSD"<?php if(isset($user)){if($user->currency == 'EUR'){echo "selected";}}?> >Bahamas Dollars</option>

                        <option value="BBD" <?php if(isset($user)){if($user->currency == 'BBD'){echo "selected";}}?> >Barbados Dollars</option>

                        <option value="BEF"<?php if(isset($user)){if($user->currency == 'BEF'){echo "selected";}}?> >Belgium Francs</option>

                        <option value="BMD"<?php if(isset($user)){if($user->currency == 'BMD'){echo "selected";}}?> >Bermuda Dollars</option>

                        <option value="BRR"<?php if(isset($user)){if($user->currency == 'BRR'){echo "selected";}}?> >Brazil Real</option>

                        <option value="BGL"<?php if(isset($user)){if($user->currency == 'BGL'){echo "selected";}}?> >Bulgaria Lev</option>

                        <option value="CAD"<?php if(isset($user)){if($user->currency == 'CAD'){echo "selected";}}?> >Canada Dollars</option>

                        <option value="CLP"<?php if(isset($user)){if($user->currency == 'CLP'){echo "selected";}}?> >Chile Pesos</option>

                        <option value="CNY"<?php if(isset($user)){if($user->currency == 'CNY'){echo "selected";}}?> >China Yuan Renmimbi</option>

                        <option value="CYP"<?php if(isset($user)){if($user->currency == 'CYP'){echo "selected";}}?> >Cyprus Pounds</option>

                        <option value="CSK"<?php if(isset($user)){if($user->currency == 'CSK'){echo "selected";}}?> >Czech Republic Koruna</option>

                        <option value="DKK"<?php if(isset($user)){if($user->currency == 'DKK'){echo "selected";}}?> >Denmark Kroner</option>

                        <option value="NLG"<?php if(isset($user)){if($user->currency == 'NLG'){echo "selected";}}?> >Dutch Guilders</option>
                        <option value="XCD"<?php if(isset($user)){if($user->currency == 'XCD'){echo "selected";}}?> >Eastern Caribbean Dollars</option>
                        <option value="EGP"<?php if(isset($user)){if($user->currency == 'EGP'){echo "selected";}}?> >Egypt Pounds</option>
                        <option value="FJD"<?php if(isset($user)){if($user->currency == 'FJD'){echo "selected";}}?> >Fiji Dollars</option>
                        <option value="FIM"<?php if(isset($user)){if($user->currency == 'FIM'){echo "selected";}}?> >Finland Markka</option>
                        <option value="FRF"<?php if(isset($user)){if($user->currency == 'FRF'){echo "selected";}}?> >France Francs</option>
                        <option value="DEM"<?php if(isset($user)){if($user->currency == 'DEM'){echo "selected";}}?> >Germany Deutsche Marks</option>
                        <option value="XAU"<?php if(isset($user)){if($user->currency == 'XAU'){echo "selected";}}?> >Gold Ounces</option>
                        <option value="GRD"<?php if(isset($user)){if($user->currency == 'GRD'){echo "selected";}}?> >Greece Drachmas</option>
                        <option value="HKD"<?php if(isset($user)){if($user->currency == 'HKD'){echo "selected";}}?> >Hong Kong Dollars</option>
                        <option value="HUF"<?php if(isset($user)){if($user->currency == 'HUF'){echo "selected";}}?> >Hungary Forint</option>
                        <option value="ISK"<?php if(isset($user)){if($user->currency == 'ISK'){echo "selected";}}?> >Iceland Krona</option>

                        <option value="IDR"<?php if(isset($user)){if($user->currency == 'IDR'){echo "selected";}}?> >Indonesia Rupiah</option>
                        <option value="JPY"<?php if(isset($user)){if($user->currency == 'JPY'){echo "selected";}}?> >Ireland Punt</option>
                        <option value="JPY"<?php if(isset($user)){if($user->currency == 'JPY'){echo "selected";}}?> >Israel New Shekels</option>
                        <option value="JPY"<?php if(isset($user)){if($user->currency == 'JPY'){echo "selected";}}?> >Italy Lira</option>
                        <option value="JPY"<?php if(isset($user)){if($user->currency == 'JPY'){echo "selected";}}?> >Jamaica Dollars</option>
                        <option value="JPY"<?php if(isset($user)){if($user->currency == 'JPY'){echo "selected";}}?> >Japan Yen</option>
                        <option value="JOD"<?php if(isset($user)){if($user->currency == 'JOD'){echo "selected";}}?> >Jordan Dinar</option>
                        <option value="KRW"<?php if(isset($user)){if($user->currency == 'KRW'){echo "selected";}}?> >Korea (South) Won</option>
                        <option value="LBP"<?php if(isset($user)){if($user->currency == 'LBP'){echo "selected";}}?> >Lebanon Pounds</option>
                        <option value="LUF"<?php if(isset($user)){if($user->currency == 'LUF'){echo "selected";}}?> >Luxembourg Francs</option>
                        <option value="MYR"<?php if(isset($user)){if($user->currency == 'MYR'){echo "selected";}}?> >Malaysia Ringgit</option>
                        <option value="MXP"<?php if(isset($user)){if($user->currency == 'MXP'){echo "selected";}}?> >Mexico Pesos</option>
                        <option value="NLG"<?php if(isset($user)){if($user->currency == 'NLG'){echo "selected";}}?> >Netherlands Guilders</option>
                        <option value="NZD"<?php if(isset($user)){if($user->currency == 'NZD'){echo "selected";}}?> >New Zealand Dollars</option>
                        <option value="NOK"<?php if(isset($user)){if($user->currency == 'NOK'){echo "selected";}}?> >Norway Kroner</option>
                        <option value="PKR"<?php if(isset($user)){if($user->currency == 'PKR'){echo "selected";}}?> >Pakistan Rupees</option>
                        <option value="XPD"<?php if(isset($user)){if($user->currency == 'XPD'){echo "selected";}}?> >Palladium Ounces</option>
                        <option value="PHP"<?php if(isset($user)){if($user->currency == 'PHP'){echo "selected";}}?> >Philippines Pesos</option>
                        <option value="XPT"<?php if(isset($user)){if($user->currency == 'XPT'){echo "selected";}}?> >Platinum Ounces</option>
                        <option value="PLZ"<?php if(isset($user)){if($user->currency == 'PLZ'){echo "selected";}}?> >Poland Zloty</option>
                        <option value="PTE"<?php if(isset($user)){if($user->currency == 'PTE'){echo "selected";}}?> >Portugal Escudo</option>
                        <option value="ROL"<?php if(isset($user)){if($user->currency == 'ROL'){echo "selected";}}?> >Romania Leu</option>
                        <option value="RUR"<?php if(isset($user)){if($user->currency == 'RUR'){echo "selected";}}?> >Russia Rubles</option>
                        <option value="SAR"<?php if(isset($user)){if($user->currency == 'SAR'){echo "selected";}}?> >Saudi Arabia Riyal</option>
                        <option value="XAG"<?php if(isset($user)){if($user->currency == 'XAG'){echo "selected";}}?> >Silver Ounces</option>
                        <option value="SGD"<?php if(isset($user)){if($user->currency == 'SGD'){echo "selected";}}?> >Singapore Dollars</option>
                        <option value="SKK"<?php if(isset($user)){if($user->currency == 'SKK'){echo "selected";}}?> >Slovakia Koruna</option>
                        <option value="ZAR"<?php if(isset($user)){if($user->currency == 'ZAR'){echo "selected";}}?> >South Africa Rand</option>
                        <option value="KRW"<?php if(isset($user)){if($user->currency == 'KRW'){echo "selected";}}?> >South Korea Won</option>
                        <option value="ESP"<?php if(isset($user)){if($user->currency == 'ESP'){echo "selected";}}?> >Spain Pesetas</option>
                        <option value="XDR"<?php if(isset($user)){if($user->currency == 'XDR'){echo "selected";}}?> >Special Drawing Right (IMF)</option>
                        <option value="SDD"<?php if(isset($user)){if($user->currency == 'SDD'){echo "selected";}}?> >Sudan Dinar</option>
                        <option value="SEK"<?php if(isset($user)){if($user->currency == 'SEK'){echo "selected";}}?> >Sweden Krona</option>
                        <option value="CHF"<?php if(isset($user)){if($user->currency == 'CHF'){echo "selected";}}?> >Switzerland Francs</option>
                        <option value="TWD"<?php if(isset($user)){if($user->currency == 'TWD'){echo "selected";}}?> >Taiwan Dollars</option>
                        <option value="THB"<?php if(isset($user)){if($user->currency == 'THB'){echo "selected";}}?> >Thailand Baht</option>
                        <option value="TTD"<?php if(isset($user)){if($user->currency == 'TTD'){echo "selected";}}?> >Trinidad and Tobago Dollars</option>
                        <option value="TRL"<?php if(isset($user)){if($user->currency == 'TRL'){echo "selected";}}?> >Turkey Lira</option>
                        <option value="VEB"<?php if(isset($user)){if($user->currency == 'VEB'){echo "selected";}}?> >Venezuela Bolivar</option>
                        <option value="ZMK"<?php if(isset($user)){if($user->currency == 'ZMK'){echo "selected";}}?> >Zambia Kwacha</option>
                        <option value="EUR"<?php if(isset($user)){if($user->currency == 'EUR'){echo "selected";}}?> >Euro</option>
                        <option value="XCD"<?php if(isset($user)){if($user->currency == 'XCD'){echo "selected";}}?> >Eastern Caribbean Dollars</option>
                        <option value="XDR"<?php if(isset($user)){if($user->currency == 'XDR'){echo "selected";}}?> >Special Drawing Right (IMF)</option>
                        <option value="XAG"<?php if(isset($user)){if($user->currency == 'XAG'){echo "selected";}}?> >Silver Ounces</option>
                        <option value="XAU"<?php if(isset($user)){if($user->currency == 'XAU'){echo "selected";}}?> >Gold Ounces</option>
                        <option value="XPD"<?php if(isset($user)){if($user->currency == 'XPD'){echo "selected";}}?> >Palladium Ounces</option>
                        <option value="XPT"<?php if(isset($user)){if($user->currency == 'XPT'){echo "selected";}}?> >Platinum Ounces</option>
                      </select>
                    </div>
                  </div>

                </div>
              </div>
              <div class="col-md-12 row">
                <div class="col-md-12 p-3">Bank Details</div>

                <div class="col-md-6">

                 <div class="form-group input-group">
                  <label class="mr-1" style="width: 33.33%;">{{ trans('app.Bank Name') }}</label>
                  <input type="tel"  class="form-control" name="bank_name"  value="@if(isset($user)){{ $user->bank_name }}@endif" required>
                </div>

                <div class="form-group input-group">
                  <label class="mr-1" style="width: 33.33%;">{{ trans('app.Branch Name') }}</label>
                  <input type="tel"  class="form-control" name="branch_name"  value="@if(isset($user)){{ $user->branch_name }}@endif" required>
                </div>

              </div>
              <div class="col-md-6">

               <div class="form-group input-group">
                <label class="mr-1" style="width: 33.33%;">{{ trans('app.AC No') }}</label>
                <input type="tel"  class="form-control" name="account_no"  value="@if(isset($user)){{ $user->account_no }}@endif" required>
              </div>

              <div class="form-group input-group">
                <label class="mr-1" style="width: 33.33%;">{{ trans('app.IFSC No') }}</label>
                <input type="tel"  class="form-control" name="ifsc_no"  value="@if(isset($user)){{ $user->ifsc_no }}@endif" required>
              </div>
            </div>
          </div>
          <div>
            <center><button type="submit" name="submit" class="btn btn-primary">{{ trans('app.Save') }}</button></center>
          </div>
          </form>
        </div>


        <div class="card-body tab-pane" id="general">
          <form action="{{ route('setting_update_user_general',app()->getLocale()) }}" method="POST"  id="general_form" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" value="{{ $user->id }}" name="id"> 
            @csrf

            <div class="form-group row">
              <div class="col-md-4" style="color: #212529;"><b>{{ trans('app.Date Time Format') }}</b></div>
              <div class="col-md-8">
                <select class="form-control select2" style="width: 50%;" name="datetime_formate">
                 <option value="d-m-Y H:i:s" <?php if($user->datetime_formate == 'd-m-Y H:i:s'){ echo "selected"; } ?>>d-m-Y H:i:s</option>
                 <option value="d-m-Y h:i A" <?php if($user->datetime_formate == 'd-m-Y h:i A'){ echo "selected"; } ?>>d-m-Y h:i A</option>
                 <option value="d-F-Y h:i A" <?php if($user->datetime_formate == 'd-F-Y h:i A'){ echo "selected"; } ?>>d-F-Y h:i A</option>
               </select> 
             </div>
            </div> 

            <div class="form-group row">
              <div class="col-md-4" style="color: #212529;"><b>{{ trans('app.Date Format') }}</b></div>
              <div class="col-md-8">
                <select class="form-control select2" style="width: 50%;"  name="date_formate">
                 <option value="d-m-Y" <?php if($user->date_formate == 'd-m-Y'){ echo "selected"; } ?>>d-m-Y</option>
                 <option value="d M y" <?php if($user->date_formate == 'd M y'){ echo "selected"; } ?>>d M y</option>
                 <option value="D d-m-Y" <?php if($user->date_formate == 'D d-m-Y'){ echo "selected"; } ?>>D d-m-Y</option>
               </select> 
             </div>
            </div> 

            <div class="form-group row">
              <div class="col-md-4" style="color: #212529;"><b>{{ trans('app.Decimal places') }}</b></div>
              <div class="col-md-8">
                <select class="form-control select2" style="width: 50%;"  name="decimal_places">
                  <option value="0" <?php if($user->decimal_places == '0'){ echo "selected"; } ?>>0 ₹12</option>
                 <option value="1" <?php if($user->decimal_places == '1'){ echo "selected"; } ?>>1 ₹12.3</option>
                 <option value="2" <?php if($user->decimal_places == '2'){ echo "selected"; } ?>>2 ₹12.34</option>
                 <option value="3" <?php if($user->decimal_places == '3'){ echo "selected"; } ?>>3 ₹12.345</option>
               </select> 
             </div>
            </div> 

            <div class="form-group input-group">
              <label class="mr-1" style="width: 33.33%;">{{ trans('app.Total (Round Off Amount)') }}</label>
              <input type="checkbox" <?php if($user->total_round_off == '1'){ echo 'checked'; } ?> name="total_round_off" data-toggle="toggle" value="1">
            </div> 

            <div class="form-group input-group">
              <label class="mr-1" style="width: 33.33%;">{{ trans('app.Track current stock of products') }}</label>
              <input type="checkbox" <?php if($user->track_stock_product == '1'){ echo 'checked'; } ?> name="track_stock_product" data-toggle="toggle" value="1">
            </div> 

            <div class="form-group input-group">
              <label class="mr-1" style="width: 33.33%;">{{ trans('app.Show Other Costs') }}</label>
              <input type="checkbox" <?php if($user->show_other_cost == '1'){ echo 'checked'; } ?> name="show_other_cost" data-toggle="toggle" value="1" >
            </div> 

            <div class="form-group input-group">
              <label class="mr-1" style="width: 33.33%;">{{ trans('app.Show Bank Details') }}</label>
              <input type="checkbox" <?php if($user->show_bank_details == '1'){ echo 'checked'; } ?> name="show_bank_details" data-toggle="toggle" value="1">
            </div> 

            <div class="form-group input-group">
              <label class="mr-1" style="width: 33.33%;">{{ trans('app.Show Signature') }}</label>
              <input type="checkbox" <?php if($user->show_signature == '1'){ echo 'checked'; } ?> name="show_signature" data-toggle="toggle" value="1">
            </div>

            <div class="form-group">
                    <label>{{ trans('app.Your Signature') }}</label>
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-xs-4">
                        <span class="btn btn-primary btn-file"> {{ trans('app.Browse') }}
                          <input type="file" class="form-control btn" accept="image/png,image/jpg,image/jpeg" name="signature_logo" onchange="image_readURL_signature(this);" <?php if($user->signature_logo == ''){ echo 'required'; } ?>>
                        </span>
                      </div>
                      <div class="col-lg-4 col-md-4 col-xs-4">
                        @if(isset($user))  
                        <img id="signatureimage" src="{{ asset('/public/images/signature/'.$user->signature_logo) }}" alt="" height="160" width="160"/>             
                        @else
                        <img id="signatureimage" src="" alt="" height="160" width="160" style="display: none;" />   
                        @endif
                      </div>
                    </div>
                  </div>

             <div>
              <center><button type="submit" name="submit" class="btn btn-primary">{{ trans('app.Save') }}</button></center>
            </div>
            </form>
          </div>

          <div class="card-body tab-pane" id="invoice">
            <form action="{{ route('settingsupdatothers',app()->getLocale()) }}" method="POST"  id="general_form" enctype="multipart/form-data" autocomplete="off">
              <input type="hidden" value="{{ $user->id }}" name="id"> 
              @csrf

              <div class="form-group row">
                <div class="col-md-3">
                 <label class="mr-1">{{ trans('app.Invoice No') }}</label>
               </div>
               <div class="col-md-1">
                <input type="text" maxlength="3"  class="form-control" name="invoice_no"  value="@if(isset($user)){{ $user->invoice_no }}@endif" required onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <div class="col-md-2">
                <select class="form-control" name="invoice_no_date">
                  <option value="0" <?php if($user->invoice_no_date == '0'){ echo "selected"; } ?>>YY-YY</option>
                 <option value="1" <?php if($user->invoice_no_date == '1'){ echo "selected"; } ?>>YY</option>
                 <option value="2" <?php if($user->invoice_no_date == '2'){ echo "selected"; } ?>>YYYY</option>
               </select> 
             </div>
               <div class="col-md-6">
                <p style="color: red;">Ex: GST/19-20/001</p> 
               </div>
              </div>

              <div>
                <center><button type="submit" name="submit"  value="invoice" class="btn btn-primary">{{ trans('app.Save') }}</button></center>
              </div>

          </div>

        <div class="card-body tab-pane" id="supply_bill">

          <div class="form-group row">
                <div class="col-md-3">
                 <label class="mr-1">{{ trans('app.Supply Bill No') }}</label>
               </div>
               <div class="col-md-1">
                <input type="text" maxlength="3"  class="form-control" name="supply_no"  value="@if(isset($user)){{ $user->supply_no }}@endif" required onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <div class="col-md-2">
                <select class="form-control" name="supply_no_date">
                  <option value="0" <?php if($user->supply_no_date == '0'){ echo "selected"; } ?>>YY-YY</option>
                 <option value="1" <?php if($user->supply_no_date == '1'){ echo "selected"; } ?>>YY</option>
                 <option value="2" <?php if($user->supply_no_date == '2'){ echo "selected"; } ?>>YYYY</option>
               </select> 
             </div>
               <div class="col-md-6">
                <p style="color: red;">Ex: SUP/19-20/001</p> 
               </div>
              </div>

           <div>
              <center><button type="submit"  name="submit"   value="supply_bill"  class="btn btn-primary">{{ trans('app.Save') }}</button></center>
            </div>
        </div>

        <div class="card-body tab-pane" id="quote_bill">

           <div class="form-group row">
                <div class="col-md-3">
                 <label class="mr-1">{{ trans('app.Quote Bill No') }}</label>
               </div>
               <div class="col-md-1">
                <input type="text" maxlength="3"  class="form-control" name="quote_no"  value="@if(isset($user)){{ $user->quote_no }}@endif" required onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <div class="col-md-2">
                <select class="form-control" name="quote_no_date">
                  <option value="0" <?php if($user->quote_no_date == '0'){ echo "selected"; } ?>>YY-YY</option>
                 <option value="1" <?php if($user->quote_no_date == '1'){ echo "selected"; } ?>>YY</option>
                 <option value="2" <?php if($user->quote_no_date == '2'){ echo "selected"; } ?>>YYYY</option>
               </select> 
             </div>
               <div class="col-md-6">
                <p style="color: red;">Ex: SUP/19-20/001</p> 
               </div>
              </div>
           <div>
              <center><button type="submit" name="submit"   value="quote_bill" class="btn btn-primary">{{ trans('app.Save') }}</button></center>
            </div>
        </div>

        <div class="card-body tab-pane" id="purchase_orders">

           <div class="form-group row">
                <div class="col-md-3">
                 <label class="mr-1">{{ trans('app.Purchase Orders No') }}</label>
               </div>
               <div class="col-md-1">
                <input type="text" maxlength="3"  class="form-control" name="purchse_no"  value="@if(isset($user)){{ $user->purchse_no }}@endif" required onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <div class="col-md-2">
                <select class="form-control" name="purchse_no_date">
                  <option value="0" <?php if($user->purchse_no_date == '0'){ echo "selected"; } ?>>YY-YY</option>
                 <option value="1" <?php if($user->purchse_no_date == '1'){ echo "selected"; } ?>>YY</option>
                 <option value="2" <?php if($user->purchse_no_date == '2'){ echo "selected"; } ?>>YYYY</option>
               </select> 
             </div>
               <div class="col-md-6">
                <p style="color: red;">Ex: SUP/19-20/001</p> 
               </div>
              </div>
          <div>
              <center><button type="submit" name="submit"   value="purchase_orders" class="btn btn-primary">{{ trans('app.Save') }}</button></center>
            </div>
           </form>
        </div>


      </div>
    </div>
  </div>
</div>
</div>
</section>
    </div>

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

    function image_readURL_signature(input) {
    if (input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#signatureimage').show();
        $('#signatureimage').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }}

    
  function change_tab_name(name)
  {
    $("#chnage_tab_name").html(name);
  }
  $(function () {
  $(".select2").select2();
});
</script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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

