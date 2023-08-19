<?php

namespace App\Http\Controllers;

use App\Models\Tbl_role;
use App\Models\Table_visible;
use App\Models\user;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class EmpController  extends Controller
{
  private $add_row;
  private $update_row;
  private $delete_row;
  private $excel;
  private $pdf;
  private $print;
  private $col_visible;
  private $show_row;
  private $auth_id;

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
      $role_type = Auth::user()->role_type;
      $url = $request->segment(2);

      if(is_null($role_type)){
            $this->auth_id =  Auth::user()->id;
          }else{
            $this->auth_id = Auth::user()->user_id;
          }

      $check_tab = Tbl_tab::where('url','=',$url)->first();
      if(!empty($check_tab))
      {
        $tab_id = $check_tab['id'];
        $check_tab_visible = Tbl_tab_visible::where('role_id','=',$role_type)->where('tab_id','=',$tab_id)->first();
        if(is_null($role_type)){
            $this->add_row = 1;
            $this->update_row = 1;
            $this->delete_row = 1;
            $this->excel = 1;
            $this->pdf = 1;
            $this->print = 1;
            $this->col_visible = 1;
            $this->show_row = 1;
        }else if(!empty($check_tab_visible)){
            $this->add_row = $check_tab_visible['add_row'];
            $this->update_row = $check_tab_visible['update_row'];
            $this->delete_row = $check_tab_visible['delete_row'];
            $this->excel = $check_tab_visible['excel'];
            $this->pdf = $check_tab_visible['pdf'];
            $this->print = $check_tab_visible['print'];
            $this->col_visible = $check_tab_visible['col_visible'];
            $this->show_row = $check_tab_visible['show_row'];
        }else{
            return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
        }
      }
      else
      {
        $this->add_row = 1;
        $this->update_row = 1;
        $this->delete_row = 1;
        $this->excel = 1;
        $this->pdf = 1;
        $this->print = 1;
        $this->col_visible = 1;
        $this->show_row = 1;
      }
      return $next($request);
    });
  }

  public function index()
  {
    $check = Table_visible::where('user_id', '=', Auth::user()->id)->where('name','=','Emplist')->first();
    if(!empty($check)){
      $array_check = explode(',', $check->notvisible);
    }else{
      $array_check = array();
    }

    $add_row = $this->add_row;
    $update_row = $this->update_row;
    $delete_row = $this->delete_row;
    $excel = $this->excel;
    $pdf = $this->pdf;
    $print = $this->print;
    $col_visible = $this->col_visible;
    $show_row = $this->show_row;

    return view('dashboard.emplist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
  }


public function getlist(Request $request){
  $columns = array(
    0 =>  'id',
    1 =>  'name',
    2 =>  'email',
    4 =>  'created_at'
  );

  $totalData = user::where('user_id', '=', $this->auth_id)->count();
  $limit = $request->input('length');
  $start = $request->input('start');
  $order = $columns[$request->input('order.0.column')];
  $dir = $request->input('order.0.dir');

  if(empty($request->input('search.value'))){
    $posts = user::where('user_id', '=', $this->auth_id)
    ->where('role_type', '!=', "null")
    ->offset($start)
    ->limit($limit)
    ->orderBy($order,$dir)
    ->get();
    $totalFiltered = user::where('role_type', '!=', "null")->count();
  }else{
    $search = $request->input('search.value');
    $posts = user::where('user_id', '=', $this->auth_id)
    ->where(function ($query)  use ($search) {
            $query->where('role_type', '!=', "null");
            $query->orWhere('name', 'like', "%{$search}%");
            $query->orWhere('email','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
    })
    ->offset($start)
    ->limit($limit)
    ->orderBy($order, $dir)
    ->get();
    $totalFiltered = user::where('user_id', '=', $this->auth_id)
    ->where(function ($query)  use ($search) {
            $query->where('role_type', '!=', "null");
            $query->orWhere('name', 'like', "%{$search}%");
            $query->orWhere('email','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
    })
    ->count();
  }

  $data = array();

  if($posts){
    foreach($posts as $r){
      $role = Tbl_role::where('id','=',$r->role_type)->first();

      $update_row = $this->update_row;
      $delete_row = $this->delete_row;
      if($update_row == '0' && $delete_row == '0')
      {
        $update_delete = '';
      }
      else if($update_row == '0')
      {
        $update_delete = '<span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
      }
      else if($delete_row == '0')
      {
        $update_delete = '<a href="'.route('employees.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
      }
      else
      {
        $update_delete = '<a href="'.route('employees.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
      }

      $nestedData = array();
      $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
      $nestedData[] = $r->name;
      $nestedData[] = $r->email;
      $nestedData[] = $role['name'];
      $nestedData[] = date(Config('constants.DATE_FORMATE'),strtotime($r->created_at));
      $nestedData[] = $update_delete;

      $data[] = $nestedData;
    }
  }

  $json_data = array(
    "draw"          => intval($request->input('draw')),
    "recordsTotal"  => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"          => $data
  );

  echo json_encode($json_data);
}

public function create()
{
  $add_row = $this->add_row;
  if($add_row == '1')
  {
    $role = Tbl_role::where('user_id', '=', $this->auth_id)->get();
    return view('dashboard.addemp',compact('role'));
  }else{
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }

}

public function store(Request $request)
{
  $data = $request->all();

  $request->validate([
    'role_id' => 'required',
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|min:6|required_with:repassword|same:repassword',
    'repassword' => 'required|min:6'
  ]);

  $add_data['name'] = $data['name'];
  $add_data['email'] = $data['email'];
  $add_data['user_id'] = $this->auth_id;
  $add_data['password'] = Hash::make($data['password']);
  $add_data['ch_pass'] = base64_encode($data['password']);
  $add_data['role_type'] = $data['role_id'];

  user::create($add_data);

  return redirect()->route('employees.index',app()->getLocale())
   ->with('success','Employee created successfully.');
}

public function edit($prefix,$id)
{
  $update_row = $this->update_row;
  if($update_row == '1')
  {
    $user = user::findOrFail($id);
    $role = Tbl_role::where('user_id', '=', $this->auth_id)->get();
    return view('dashboard.addemp',compact('user','role'));
  }
  else
  {
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function update(Request $request,user $user)
{
 $data = $request->all();

  $request->validate([
    'role_id' => 'required',
    'name' => 'required|string|max:255',
    'password' => 'required|min:6|required_with:repassword|same:repassword',
    'repassword' => 'required|min:6'
  ]);

  $add_data['name'] = $data['name'];
  $add_data['password'] = Hash::make($data['password']);
  $add_data['ch_pass'] = base64_encode($data['password']);
  $add_data['role_type'] = $data['role_id'];

   user::find($request->input('id'))->update($add_data);
   return redirect()->route('employees.index',app()->getLocale())
   ->with('success','Employee updated successfully.');
}


public function destroy($prefix,$id)
{
  $data = user::where('id', '=',$id)->first();
  user::find($id)->delete($id);
}

public function multydestroy($prefix,Request $request)
{
  $delid = $request->input('checkid');

  foreach ($delid as $id) {
   $data = user::where('id', '=',$id)->first();
   user::find($id)->delete($id);
  }

  return redirect()->route('employees.index',app()->getLocale())
  ->with('success','Employee deleted successfully.');
}

}
