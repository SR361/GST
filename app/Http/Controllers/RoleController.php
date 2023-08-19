<?php

namespace App\Http\Controllers;

use App\Models\Tbl_role;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use App\Models\Table_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;

class RoleController  extends Controller
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
      $url = "roles";//$request->segment(2);

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
            return Redirect::route('home',app()->getLocale())->with('message', 'Not Found.');
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
    $check = Table_visible::where('user_id', '=', Auth::user()->id)->where('name','=','Rolelist')->first();
    if(!empty($check)){
      $array_check = explode(',', $check->notvisible);
    }else{
      $array_check = array();
    }

    $tab_list = Tbl_tab::where('status','=','1')->Where(function ($query){
            $query->where('type', '=', '0')
                  ->orwhere('type', '=', '2');
        })->get();

    $add_row = $this->add_row;
    $update_row = $this->update_row;
    $delete_row = $this->delete_row;
    $excel = $this->excel;
    $pdf = $this->pdf;
    $print = $this->print;
    $col_visible = $this->col_visible;
    $show_row = $this->show_row;
    return view('dashboard.rolelist',compact('array_check','tab_list','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
  }


public function getlist(Request $request){
  $columns = array(
    0 =>  'id',
    1 =>  'name',
    3 =>  'created_at'
  );

  $totalData = Tbl_role::where('user_id', '=', $this->auth_id)->count();
  $limit = $request->input('length');
  $start = $request->input('start');
  $order = $columns[$request->input('order.0.column')];
  $dir = $request->input('order.0.dir');

  if(empty($request->input('search.value'))){
    $posts = Tbl_role::where('user_id', '=', $this->auth_id)
    ->offset($start)
    ->limit($limit)
    ->orderBy($order,$dir)
    ->get();
    $totalFiltered = Tbl_role::count();
  }else{
    $search = $request->input('search.value');
    $posts = Tbl_role::where('user_id', '=', $this->auth_id)
    ->where(function ($query)  use ($search) {
      $query->orWhere('name','like',"%{$search}%");
      $query->orWhere('created_at','like',"%{$search}%");
    })
    ->offset($start)
    ->limit($limit)
    ->orderBy($order, $dir)
    ->get();
    $totalFiltered = Tbl_role::where('user_id', '=', $this->auth_id)
    ->where(function ($query)  use ($search) {
      $query->orWhere('name','like',"%{$search}%");
      $query->orWhere('created_at','like',"%{$search}%");
    })
    ->count();
  }


  $data = array();

  if($posts){
    foreach($posts as $r){
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
        $update_delete = '<a href="#" onclick="update_role_data(`'.$r->name.'`,'.$r->id.')" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
      }
      else
      {
        $update_delete = '<a href="#" onclick="update_role_data(`'.$r->name.'`,'.$r->id.')" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
      }

      $nestedData = array();
      $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
      $nestedData[] = ucfirst($r->name);
      $nestedData[] = '<span class="btn-sm btn-info btn-xs" onclick="update_visiblity('.$r->id.')">'.trans('app.Visible').'</span> ';
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

public function store(Request $request)
{
  $data = $request->all();
  $data['user_id'] = $this->auth_id;
  Tbl_role::create($data);
}

public function visible_data($prefix,Request $request)
{
  $data = $request->all();
  $tab_data = Tbl_tab_visible::where('role_id', '=',$data['id'])->get();
  return json_encode($tab_data);
}

public function update_visible($prefix,Request $request)
{
  $data = $request->all();
  $role_id = $data['role_id'];
  $tab_data = Tbl_tab::where('status', '=', "1")->get();
  DB::table('Tbl_tab_visibles')->where('role_id', $role_id)->delete();
  foreach ($tab_data as $key) {
    if(isset($data['check'.$key['id']]))
    {
      $add_data['role_id'] = $role_id;
      $add_data['visible'] = '1';
      $add_data['tab_id'] = $key['id'];
      if(isset($data['add'.$key['id']]))
      {
        $add_data['add_row'] = $data['add'.$key['id']];
      }else{
        $add_data['add_row'] = '0';
      }
      if(isset($data['update'.$key['id']]))
      {
        $add_data['update_row'] = $data['update'.$key['id']];
      }else{
        $add_data['update_row'] = '0';
      }
      if(isset($data['delete'.$key['id']]))
      {
        $add_data['delete_row'] = $data['delete'.$key['id']];
      }else{
        $add_data['delete_row'] = '0';
      }
      if(isset($data['excel'.$key['id']]))
      {
        $add_data['excel'] = $data['excel'.$key['id']];
      }else{
        $add_data['excel'] = '0';
      }
      if(isset($data['pdf'.$key['id']]))
      {
        $add_data['pdf'] = $data['pdf'.$key['id']];
      }else{
        $add_data['pdf'] = '0';
      }
      if(isset($data['print'.$key['id']]))
      {
        $add_data['print'] = $data['print'.$key['id']];
      }else{
        $add_data['print'] = '0';
      }
      if(isset($data['col_vis'.$key['id']]))
      {
        $add_data['col_visible'] = $data['col_vis'.$key['id']];
      }else{
        $add_data['col_visible'] = '0';
      }
      if(isset($data['col_show'.$key['id']]))
      {
        $add_data['show_row'] = $data['col_show'.$key['id']];
      }else{
        $add_data['show_row'] = '0';
      }
      Tbl_tab_visible::create($add_data);
    }
  }
  $sub_tab = Tbl_tab::where('status','=',"1")->where('type','=',"2")->get();
  foreach ($sub_tab as $key) {
    if (isset($data['check'.$key['id']])) {
      $check = Tbl_tab_visible::where('role_id','=',$role_id)
                                ->where('tab_id','=',$key['tab_id'])
                                ->first();
      if (empty($check)) {
        $sub_main_tab = Tbl_tab::where('status','=',"1")->where('id','=',$key['tab_id'])->first();
        if (!empty($sub_main_tab)) {
          $sub_data['role_id'] = $role_id;
          $sub_data['visible'] = '1';
          $sub_data['tab_id'] = $sub_main_tab['id'];
          $sub_data['add_row'] = '1';
          $sub_data['update_row'] = '1';
          $sub_data['delete_row'] = '1';
          $sub_data['excel'] = '1';
          $sub_data['pdf'] = '1';
          $sub_data['print'] = '1';
          $sub_data['col_visible'] = '1';
          $sub_data['show_row'] ='1';
          Tbl_tab_visible::create($sub_data);
        }
      }
    }
  }
}

public function update_data($prefix,Request $request)
{
  $data = $request->all();

  Tbl_role::find($request->input('id'))->update($data);
}


public function destroy($prefix,$id)
{
  $data = Tbl_role::where('id', '=',$id)->first();
  Tbl_role::find($id)->delete($id);
}

public function multydestroy($prefix,Request $request)
{
  $delid = $request->input('checkid');

  foreach ($delid as $id) {
   $data = Tbl_role::where('id', '=',$id)->first();
   Tbl_role::find($id)->delete($id);
 }

 return redirect()->route('roles.index',app()->getLocale())
 ->with('success','Role deleted successfully.');
}

}
