<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard_admin.v1');
    }

     public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        $data = $request->all();

        $user = Admin::find(auth()->user()->id);
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
