<?php

namespace App\Http\Controllers;

use App\Models\Tbl_client;
use App\Models\Table_visible;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ClientController  extends Controller
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
        $check = Table_visible::where('user_id', '=', $this->auth_id)->where('name','=','Clientlist')->first();
        if(!empty($check))
        {
            $array_check = explode(',', $check->notvisible);
        }
        else
        {
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
        return view('dashboard.clientlist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
    }


    public function getlist(Request $request){
        // print_r($request->all());
        $columns = array(
            0 =>  'id',
            1 =>  'company_name',
            3 =>  'phone',
            4 =>  'email',
            5 =>  'gstin',
            7 =>  'state',
            8 =>  'created_at'
        );

        $totalData = Tbl_client::where('user_id', '=', $this->auth_id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = Tbl_client::where('user_id', '=', $this->auth_id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = Tbl_client::where('user_id', '=', $this->auth_id)->count();
        }else{
            $search = $request->input('search.value');
            $posts = Tbl_client::where('user_id', '=', $this->auth_id)
            ->where(function ($query)  use ($search) {
                $query->Where('company_name', 'like', "%{$search}%");
                $query->orWhere('phone','like',"%{$search}%");
                $query->orWhere('email','like',"%{$search}%");
                $query->orWhere('gstin','like',"%{$search}%");
                $query->orWhere('state','like',"%{$search}%");
                $query->orWhere('created_at','like',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
            $totalFiltered = Tbl_client::where('user_id', '=', $this->auth_id)
            ->where(function ($query)  use ($search) {
                $query->Where('company_name', 'like', "%{$search}%");
                $query->orWhere('phone','like',"%{$search}%");
                $query->orWhere('email','like',"%{$search}%");
                $query->orWhere('gstin','like',"%{$search}%");
                $query->orWhere('state','like',"%{$search}%");
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
                $update_delete = '<a href="'.route('clients.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
            }
            else
            {
                $update_delete = '<a href="'.route('clients.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
            }
            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->company_name;
            $nestedData[] = '<div class="btn-sm btn-info btn-xs" onclick="check_info('.$r->id.')">'.trans('app.Info').'</div>';
            $nestedData[] = $r->phone;
            $nestedData[] = $r->email;
            $nestedData[] = $r->gstin;
            $nestedData[] = "<img src='".asset('/public/images/client/'.$r->logo)."'class='img-bordered-sm' style='height:100px; width:100px; border-radius: 50%;' />";
            $nestedData[] = $r->state;
            $nestedData[] = date(Auth::user()->datetime_formate,strtotime($r->created_at));
            $nestedData[] = '<a href="'.route('clients.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
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


public function data($prefix,Request $request){
    $data = Tbl_client::where('id', '=',$request->input('id'))->first();


    return '<div class="col-12">
    <div class="card">
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
    <tbody>
    <tr>
    <th>'.trans('app.Contact Person').'</th>
    <td>'.$data['contact_person'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Contact Phone').'</th>
    <td>'.$data['contact_phone'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Contact Name').'</th>
    <td>'.$data['contact_name'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Address').'</th>
    <td>'.$data['address'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.State').'</th>
    <td>'.$data['state'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.PIN').'</th>
    <td>'.$data['pin'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Website').'</th>
    <td>'.$data['website'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.PAN').'</th>
    <td>'.$data['pan'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.TIN').'</th>
    <td>'.$data['tin'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.VAT').'</th>
    <td>'.$data['vat'].'</td>
    </tr>
    </tbody></table>
    </div>
    </div>
    </div>';
}



public function create()
{
  $add_row = $this->add_row;
  if($add_row == '1')
  {
    return view('dashboard.addclient');
  }else{
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function store(Request $request)
{
    $request->validate([
        'type' => 'required',
        'company_name' => 'required|string|max:255',
        'phone' => 'required|numeric|min:10',
        'email' => 'required|string|email|max:255',
        'gstin' => 'required|string|min:12',
        'pan' => 'required|string|min:12',
        // 'tin' => 'required|numeric|min:2',
        // 'vat' => 'required|numeric|min:2',
        // 'website' =>  "required|url",
        'currency' => 'required',
        'contact_person' => 'required|string|max:255',
        'contact_phone' => 'required|numeric|min:10',
        'contact_name' => 'required|string|max:255',
        'address' => 'required|string',
        'state' => 'required',
        'pin' => 'required|numeric|min:5',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    $data['user_id'] = $this->auth_id;

    $image = $request->file('logo');
    $data['logo'] = time().'.'.$image->getClientOriginalExtension();
    $destinationPath = public_path('/images/client');
    $image->move($destinationPath, $data['logo']);

    Tbl_client::create($data);

    return redirect()->route('clients.index',app()->getLocale())
    ->with('success','client created successfully.');
}

public function edit($prefix,$id)
{
  $update_row = $this->update_row;
  if($update_row == '1')
  {
    $Tbl_client = Tbl_client::findOrFail($id);
    return view('dashboard.addclient',compact('Tbl_client'));
  }
  else
  {
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function update(Request $request,Tbl_client $tbl_client)
{
   $request->validate([
    'type' => 'required',
    'company_name' => 'required|string|max:255',
    'phone' => 'required|numeric|min:10',
    'email' => 'required|string|email',
    'gstin' => 'required|string|min:12',
    'pan' => 'required|string|min:12',
    // 'tin' => 'required|numeric|min:2',
    // 'vat' => 'required|numeric|min:2',
    // 'website' =>  "required|url",
    'currency' => 'required',
    'contact_person' => 'required|string|max:255',
    'contact_phone' => 'required|numeric|min:10',
    'contact_name' => 'required|string|max:255',
    'address' => 'required|string',
    'state' => 'required',
    'pin' => 'required|numeric|min:5',
]);
   $data = $request->all();

   if(!empty( $request->file('logo')))
   {
    $data_check = Tbl_client::where('id','=',$request->input('id'))->first();
    $image = $data_check->logo;
    $image_path = public_path('/images/client'.$image);
    if(file_exists($image_path)){
        @unlink($image_path);
    }

    $image = $request->file('logo');
    $data['logo'] = time().'.'.$image->getClientOriginalExtension();
    $destinationPath = public_path('/images');
    $image->move($destinationPath, $data['logo']);
}
Tbl_client::find($request->input('id'))->update($data);

return redirect()->route('clients.index',app()->getLocale())
->with('success','client updated successfully.');
}


public function destroy($prefix,$id)
{
    $data = Tbl_client::where('id', '=',$id)->first();
    $image = $data->logo;
    $image_path = public_path('/images/client/'.$image);
    if(file_exists($image_path)){
        @unlink($image_path);
    }
    Tbl_client::find($id)->delete($id);
}

public function multydestroy($prefix,Request $request)
{
    $delid = $request->input('checkid');

    foreach ($delid as $id) {
       $data = Tbl_client::where('id', '=',$id)->first();
       $image = $data->logo;
       $image_path = public_path('/images/client/'.$image);
       if(file_exists($image_path)){
        @unlink($image_path);
    }
    Tbl_client::find($id)->delete($id);
}

return redirect()->route('clients.index',app()->getLocale())
->with('success','client deleted successfully.');
}

}
