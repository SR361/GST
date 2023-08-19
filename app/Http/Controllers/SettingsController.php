<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use View;

class SettingsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
  	// echo "DATA".Config('constants.COLOR');
    $user = User::where('id', '=', Auth::id())->first();
    return view('dashboard.setting',compact('user'));
  }

  public function updateuser($prefix,Request $request)
  {
      $data = $request->all();
	  $userdata['company_name'] = $data['company_name'];
	  $userdata['state'] = $data['state'];
	  $userdata['pin'] = $data['pin'];
	  $userdata['gstin'] = $data['gstin'];
	  $userdata['address'] = $data['address'];
	  $userdata['phone'] = $data['phone'];
	  $userdata['name'] = $data['name'];
	  $userdata['currency'] = $data['currency'];
	  $userdata['bank_name'] = $data['bank_name'];
	  $userdata['branch_name'] = $data['branch_name'];
	  $userdata['account_no'] = $data['account_no'];
	  $userdata['ifsc_no'] = $data['ifsc_no'];

	  $image = $request->file('logo');
	  if(!empty($image))
	  {
	  	$data_check = User::where('id', '=',$data['id'])->first();
	  	$image_check = $data_check->logo;
	  	if($image_check != '' && $image_check != null)
	  	{
	  		$image_path = public_path('/images/users/'.$image_check);
	  		if(file_exists($image_path)){
	  			@unlink($image_path);
	  		}
	  	}


	  	$userdata['logo'] = time().'.'.$image->getClientOriginalExtension();
	  	$destinationPath = public_path('/images/users/');
	  	$image->move($destinationPath, $userdata['logo']);
	  }

	  User::find($request->input('id'))->update($userdata);

      return redirect()->route('settings.index',app()->getLocale())
     ->with('success','Profile Update successfully.');
  }


  public function updateusergeneral($prefix,Request $request)
  {
      $data = $request->all();

      if(isset($data['show_signature'])){
      	$userdata['show_signature'] = $data['show_signature'];
      }else{
      	$userdata['show_signature'] = '0';
      }

	  if(isset($data['show_bank_details'])){
      	$userdata['show_bank_details'] = $data['show_bank_details'];
      }else{
      	$userdata['show_bank_details'] = '0';
      }

	  if(isset($data['track_stock_product'])){
      	$userdata['track_stock_product'] = $data['track_stock_product'];
      }else{
      	$userdata['track_stock_product'] = '0';
      }

	  if(isset($data['show_other_cost'])){
      	$userdata['show_other_cost'] = $data['show_other_cost'];
      }else{
      	$userdata['show_other_cost'] = '0';
      }

	  if(isset($data['total_round_off'])){
      	$userdata['total_round_off'] = $data['total_round_off'];
      }else{
      	$userdata['total_round_off'] = '0';
      }


	  $userdata['decimal_places'] = $data['decimal_places'];
	  $userdata['date_formate'] = $data['date_formate'];
	  $userdata['datetime_formate'] = $data['datetime_formate'];

	  $image = $request->file('signature_logo');
	  if(!empty($image))
	  {
	  	$data_check = User::where('id', '=',$data['id'])->first();
	  	$image_check = $data_check->signature_logo;
	  	if($image_check != '' && $image_check != null)
	  	{
	  		$image_path = public_path('/images/signature/'.$image_check);
	  		if(file_exists($image_path)){
	  			@unlink($image_path);
	  		}
	  	}


	  	$userdata['signature_logo'] = time().'.'.$image->getClientOriginalExtension();
	  	$destinationPath = public_path('/images/signature/');
	  	$image->move($destinationPath, $userdata['signature_logo']);
	  }

	  User::find($request->input('id'))->update($userdata);

      return redirect()->route('settings.index',app()->getLocale())
     ->with('success','General Update successfully.');
  }


  public function settingsupdatothers($prefix,Request $request)
  {
  	$data = $request->all();
  	// DB::enableQueryLog(); // Enable query log
  	switch ($request->input('submit')) {
  		case 'supply_bill':
  				$userdata['supply_no'] = $data['supply_no'];
  				$userdata['supply_no_date'] = $data['supply_no_date'];
  				User::where('id', $request->input('id'))->update($userdata);
  		break;
  		case 'purchase_orders':
  				$userdata['purchse_no'] = $data['purchse_no'];
  				$userdata['purchse_no_date'] = $data['purchse_no_date'];
  				User::where('id', $request->input('id'))->update($userdata);
  		break;
  		case 'invoice':
  				$userdata['invoice_no'] = $data['invoice_no'];
  				$userdata['invoice_no_date'] = $data['invoice_no_date'];
  				User::where('id', $request->input('id'))->update($userdata);
  		break;
  		case 'quote_bill':
  				$userdata['quote_no'] = $data['quote_no'];
  				$userdata['quote_no_date'] = $data['quote_no_date'];
  				User::where('id', $request->input('id'))->update($userdata);
  		break;
  	}
  	// dd(DB::getQueryLog()); // Show results of log

  	return redirect()->route('settings.index',app()->getLocale())
  	->with('success','Settings updated successfully.');
  }
}
