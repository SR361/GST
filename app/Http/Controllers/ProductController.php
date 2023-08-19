<?php

namespace App\Http\Controllers;

use App\Models\Tbl_product;
use App\Models\Table_visible;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController  extends Controller
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
        $check = Table_visible::where('user_id', '=', $this->auth_id)->where('name','=','Productlist')->first();
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
        return view('dashboard.productlist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
    }


public function getlist(Request $request){

    $columns = array(
        0 =>  'id',
        1 =>  'id',
        3 =>  'name',
        4 =>  'quantity',
        5 =>  'created_at'
    );

    $totalData = Tbl_product::where('user_id', '=', $this->auth_id)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if(empty($request->input('search.value'))){
        $posts = Tbl_product::where('user_id', '=', $this->auth_id)
        ->offset($start)
        ->limit($limit)
        ->orderBy($order,$dir)
        ->get();
        $totalFiltered = Tbl_product::where('user_id', '=', $this->auth_id)->count();
    }else{
        $search = $request->input('search.value');
        $posts = Tbl_product::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->where('id', 'like', "%{$search}%");
            $query->orWhere('name','like',"%{$search}%");
            $query->orWhere('quantity','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
        $totalFiltered = Tbl_product::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->where('id', 'like', "%{$search}%");
            $query->orWhere('name','like',"%{$search}%");
            $query->orWhere('quantity','like',"%{$search}%");
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
                $update_delete = '<a href="'.route('products.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
            }
            else
            {
                $update_delete = '<a href="'.route('products.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
            }

            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->id;
            $nestedData[] = '<div class="btn-sm btn-info btn-xs" onclick="check_info('.$r->id.')">'.trans('app.Info').'</div>';
            $nestedData[] = $r->name;
            $nestedData[] = $r->quantity;
            $nestedData[] = date(Auth::user()->datetime_formate,strtotime($r->created_at));
            $nestedData[] = '<a href="'.route('products.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
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
    $data = Tbl_product::where('id', '=',$request->input('id'))->first();

    return '<div class="col-12">
    <div class="card">
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
    <tbody>
    <tr>
    <th>'.trans('app.Name').'</th>
    <td>'.$data['name'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Description').'</th>
    <td>'.$data['description'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Sale Price').'</th>
    <td>'.$data['sale_price'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Sale Currency').'</th>
    <td>'.$data['sale_currency'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.HSN').'</th>
    <td>'.$data['hsn'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Purchase Price').'</th>
    <td>'.$data['purchase_price'].'</td>
    </tr>
    <tr>
    <th>'.trans('app.Purchase Currency').'</th>
    <td>'.$data['purchase_currency'].'</td>
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
    return view('dashboard.addproduct');
  }else{
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function store(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'quantity' => 'required|numeric',
        // 'unit' => 'required|numeric',
        // 'tax' => 'required|numeric',
        'hsn' => 'required|string',
        'sale_price' => 'required|numeric',
        'sale_currency' => 'required',
        // 'sale_cess_per' => 'required|numeric',
        // 'sale_cess_pluse' => 'required|numeric',
        'purchase_price' => 'required|numeric',
        'purchase_currency' => 'required',
        // 'purchase_cess_per' => 'required|numeric',
        // 'purchase_cess_pluse' => 'required|numeric'
    ]);

    $data = $request->all();
    $data['user_id'] = $this->auth_id;

    Tbl_product::create($data);

    return redirect()->route('products.index',app()->getLocale())
    ->with('success','Product created successfully.');
}

public function edit($prefix,$id)
{
  $update_row = $this->update_row;
  if($update_row == '1')
  {
    $Tbl_product = Tbl_product::findOrFail($id);
    return view('dashboard.addproduct',compact('Tbl_product'));
  }
  else
  {
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function update(Request $request,Tbl_product $Tbl_product)
{
   $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'required|string',
    'quantity' => 'required|numeric',
    // 'unit' => 'required|numeric',
    // 'tax' => 'required|numeric',
    'hsn' => 'required|string',
    'sale_price' => 'required|numeric',
    'sale_currency' => 'required',
    // 'sale_cess_per' => 'required|numeric',
    // 'sale_cess_pluse' => 'required|numeric',
    'purchase_price' => 'required|numeric',
    'purchase_currency' => 'required',
    // 'purchase_cess_per' => 'required|numeric',
    // 'purchase_cess_pluse' => 'required|numeric'
]);

   $data = $request->all();

   Tbl_product::find($request->input('id'))->update($data);

   return redirect()->route('products.index',app()->getLocale())
   ->with('success','Product updated successfully.');
}


public function destroy($prefix,$id)
{
    Tbl_product::find($id)->delete($id);
}

public function multydestroy($prefix,Request $request)
{
    $delid = $request->input('checkid');

    foreach ($delid as $id) {
        Tbl_product::find($id)->delete($id);
    }

    return redirect()->route('products.index',app()->getLocale())
    ->with('success','Product deleted successfully.');
}
}
