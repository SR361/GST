<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Route;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AdminLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function index()
    {
        return view('admin.dashboard');
    }


    public function showLoginForm()
    {
      return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      //dd($request);

      //Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

        //dd(redirect()->intended(route('admindashboard')));

        // if successful, then redirect to their intended location
         return redirect()->route('admin.dashboard');
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }

     public function showRegistartionForm()
    {
      return view('auth.passwords.admin_register');
    }

    protected function createAdmin(Request $request)
    {
        $this->validate($request, [
        'name'   => 'required',
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);


        $admin = Admin::create([
            'firstname' => $request['name'],
            'midname' =>  $request['name'],
            'lastname' =>  $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('admin.auth.login');
    }
}
