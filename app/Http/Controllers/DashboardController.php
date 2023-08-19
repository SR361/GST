<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Tbl_product;
use App\Models\Tbl_client;
use App\Models\Tbl_invoice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function __construct(){
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
      $role_type = Auth::user()->role_type;
      if(is_null($role_type)){
        $this->auth_id =  Auth::user()->id;
      }else{
        $this->auth_id = Auth::user()->user_id;
      }
      return $next($request);
    });
  }

  public function versionone(){
    $total_product = Tbl_product::where('user_id',$this->auth_id)->count();
    $total_client = Tbl_client::where('user_id',$this->auth_id)
                                ->Where(function ($query) {
                                  $query->orwhere('type', '=', '0')
                                        ->orwhere('type', '=', '2');
                                })
                                ->count();
    $total_vendor = Tbl_client::where('user_id',$this->auth_id)
                                ->Where(function ($query) {
                                  $query->orwhere('type', '=', '1')
                                        ->orwhere('type', '=', '2');
                                })
                                ->count();
    $invoice  =  Tbl_invoice::where('user_id', '=',$this->auth_id)
                            ->Where('bill_type', '=', '0')
                            ->orderby('net_amount','DESC')
                            ->limit(5)
                            ->get();
    $purchase = Tbl_invoice::Where('user_id', '=', $this->auth_id)
                            ->Where(function ($query) {
                              $query->orwhere('bill_type', '=', '3')
                                    ->orwhere('bill_type', '=', '4');
                            })
                            ->orderby('net_amount','DESC')
                            ->limit(5)
                            ->get();
    $payment = Tbl_invoice::where('user_id', '=',$this->auth_id)
                            ->Where('bill_type', '=', '0')
                            ->where('payment_check','0')
                            ->Where(function ($query) {
                              $query->orwhereDate('due_date',date("Y-m-d"))
                                    ->orwhereDate('due_date','<',date("Y-m-d"));
                            })
                            ->orderby('due_date','ASC')
                            ->get();
    return view('dashboard.v1',compact('total_product','total_client', 'total_vendor','invoice','purchase','payment'));
  }

  public function plan_expire(){
    return view('dashboard.expire');
  }

  public function updatePassword(Request $request){
    $this->validate($request, [
      'old_password'     => 'required',
      'new_password'     => 'required|min:6',
      'confirm_password' => 'required|same:new_password',
    ]);
    $data = $request->all();
    $user = User::find(auth()->user()->id);
    if(!Hash::check($data['old_password'], $user->password)){
      // return back()
      // ->with('error','The specified password does not match the database password');
      return "The specified password does not match the database password";
    }else{
      $user->forceFill([
        'password' => bcrypt($data['new_password']),
        'remember_token' => Str::random(60),
      ])->save();
      return "update done";
    }
  }
}
