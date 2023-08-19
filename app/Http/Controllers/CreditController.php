<?php

namespace App\Http\Controllers;

use App\Models\Tbl_invoice;
use App\Models\Tbl_credit;
use App\Models\Tbl_credit_product;
use App\Models\Tbl_client;
use App\Models\Tbl_invoice_product;
use App\Models\Tbl_product;
use App\Models\Table_visible;
use App\Models\User;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use View;

class CreditController extends Controller
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
        $check = Table_visible::where('user_id', '=', $this->auth_id)->where('name','=','Creditlist')->first();
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
        return view('dashboard.Creditlist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
    }


public function getlist(Request $request){

    $columns = array(
        0 =>  'id',
        1 =>  'credit_number',
        5 =>  'total_amount_credit',
        6 =>  'date',
    );

    $totalData = Tbl_credit::where('user_id', '=', $this->auth_id)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if(empty($request->input('search.value'))){
        $posts = Tbl_credit::where('user_id', '=', $this->auth_id)
        ->offset($start)
        ->limit($limit)
        ->orderBy($order,$dir)
        ->get();
        $totalFiltered = Tbl_credit::where('user_id', '=', $this->auth_id)->count();
    }else{
        $search = $request->input('search.value');
        $posts = Tbl_credit::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('credit_number','like',"%{$search}%");
            $query->orWhere('total_amount_credit','like',"%{$search}%");
            $query->orWhere('date','like',"%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $totalFiltered = Tbl_credit::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('credit_number','like',"%{$search}%");
            $query->orWhere('total_amount_credit','like',"%{$search}%");
            $query->orWhere('date','like',"%{$search}%");
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
                $update_delete = '<a href="'.route('credits.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
            }
            else
            {
                $update_delete = '<a href="'.route('credits.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
            }

            $client_data  = Tbl_client::where('id', '=', $r->client_id)->first();
            $invoice_data  = Tbl_invoice::where('id', '=', $r->invoice_id)->first();
            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->credit_number;
            $nestedData[] = $invoice_data['invoice_number'];
            $nestedData[] = $client_data['company_name'];
            $nestedData[] = '<div class="row"><span class="btn-sm btn-info btn-xs mr-1" onclick="check_info('.$r->id.')"><i class="fas fa-info"></i></span><a href="'.route('invoice',[app()->getLocale(),$r->id]).'" class="btn-sm btn-primary btn-xs" onclick="check_info('.$r->id.')"><i class="fas fa-file-invoice"></i></a></div>';
            $nestedData[] = $r->total_amount_credit;
            $nestedData[] = date(Auth::user()->date_formate,strtotime($r->date));
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

public function clientinvoiceinfo($prefix,Request $request)
{
  $data = Tbl_invoice::where("client_id","=",$request->input('id'))->get();
  $main_data = array();
  foreach ($data as $key) {
    $new = array();
    $new['id'] = $key['id'];
    $new['text'] = $key['invoice_number'];
    $main_data[] = $new;
  }
  return json_encode($main_data);
}

public function invoiceproductinfo($prefix,Request $request)
{
    $invoice_id = $_POST['id'];
    $data = Tbl_invoice_product::where('invoice_id', '=',$invoice_id)->get();

    $info['total_invoice_product'] = count($data);

    $info['tabl_info'] = '';
    $i = 1;
    foreach ($data as $key) {
        $info['tabl_info'] .= '<tr>
        <td><input type="hidden" value="'.$key['id'].'" id="invoice_product_id'.$i.'" name="invoice_product_id'.$i.'">'.$key['product_name'].'</td>
        <td>'.$key['product_description'].'</td>
        <td><input type="hidden" value="'.$key['total_amount'].'" id="total_amount'.$i.'" name="total_amount'.$i.'" >'.$key['total_amount'].'</td>
        <td><input type="hidden" value="'.$key['qty'].'" id="total_qty'.$i.'" name="total_qty'.$i.'" >'.$key['qty'].'</td>
        <td><input type="number" onkeyup="final_result();" max="'.$key['qty'].'" min="0" class="form-control" value="0" id="total_return_qty'.$i.'" name="total_return_qty'.$i.'"></td>
        <td><input type="hidden" id="total_credit'.$i.'" name="total_credit'.$i.'"><p id="showtotal_credit'.$i.'">0</p></td>
        </tr>';
        $i ++;
    }

    return json_encode($info);
}

public function data($prefix,Request $request){
    $data = Tbl_credit_product::where('credit_id', '=',$request->input('id'))->get();
    $credit = Tbl_credit::where('id', '=',$request->input('id'))->first();
    $tabl_info = '';

    foreach ($data as $key) {
        $product = Tbl_invoice_product::where('id', '=',$key['invoice_product_id'])->first();
        $tabl_info .= '<tr>
        <td>'.$product['product_name'].'</td>
        <td>'.$product['product_description'].'</td>
        <td>'.$key['qty'].'</td>
        <td>'.$key['total_amount'].'<i class="fas fa-rupee"></i></td>
        </tr>';
    }

    return '<div class="col-12">
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">'.trans('app.Invoice Info').'</h3>
    </div>
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
    <tbody><tr>
    <th>'.trans('app.Product Name').'</th>
    <th>'.trans('app.Description').'</th>
    <th>'.trans('app.QTY').'</th>
    <th>'.trans('app.Total Amount').'</th>
    </tr>
    '.$tabl_info.'
    <tr>
    <td colspan="3" style="text-align:right;">'.trans('app.Total Amount').'</td>
    <td>'.$credit['total_amount'].' <i class="fas fa-rupee"></i></td>
    </tr>
     <td colspan="3" style="text-align:right;">'.trans('app.Charge').'</td>
    <td>'.$credit['charge'].' <i class="fas fa-rupee"></i></td>
    </tr>
    <td colspan="3" style="text-align:right;">'.trans('app.Net Amount').'</td>
    <td>'.$credit['total_amount_credit'].' <i class="fas fa-rupee"></i></td>
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
        $id = $this->auth_id;
        $client_data  = Tbl_client::where('user_id', '=', $id)->where('type', '!=', '1')->get();
        return view('dashboard.addcredit',compact('client_data'));
    }else{
        return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
    }
}


public function store(Request $request)
{
    $data = $request->all();
    $invoice_data = Tbl_invoice::where('id','=',$data['invoice_id'])->first();

    $add_credit['user_id'] = $this->auth_id;
    $add_credit['client_id'] = $data['client_id'];
    $add_credit['invoice_id'] = $data['invoice_id'];
    $add_credit['credit_number'] = $data['credit_number'];
    $add_credit['reason'] = $data['reason'];
    $add_credit['invoice_date'] = date('Y-m-d',strtotime($invoice_data['invoice_date']));
    $add_credit['date'] = date('Y-m-d',strtotime($data['date']));
    $add_credit['total_amount_credit'] = $data['total_amount_credit'];
    $add_credit['total_amount'] = $data['total_amount'];
    $add_credit['charge'] = $data['charge'];
    $add_credit['status'] = '0';

    $credit = Tbl_credit::create($add_credit);
    $credit_id = $credit->id;

    $total_credit_product = $data['total_credit_product'];

    for ($i=1; $i <= $total_credit_product; $i++) {

       $credit_pro['credit_id'] = $credit_id;
       $credit_pro['invoice_product_id'] = $data['invoice_product_id'.$i];
       $credit_pro['qty'] = $data['total_return_qty'.$i];
       $credit_pro['total_amount'] = $data['total_credit'.$i];
       Tbl_credit_product::create($credit_pro);
    }

    return redirect()->route('credits.index',app()->getLocale())
     ->with('success','Credit add successfully.');
}

public function edit($prefix,$id)
{
    $update_row = $this->update_row;
    if($update_row == '1')
    {
        $user_id = $this->auth_id;
        $client_data  = Tbl_client::where('user_id', '=', $user_id)->where('type', '!=', '1')->get();
        $credit = Tbl_credit::where('id','=',$id)->first();
        $credit_pro = Tbl_credit_product::where('credit_id','=',$id)->get();
        $credit_product = array();
        foreach ($credit_pro as $key) {
            $invoice_product = tbl_invoice_product::where('id','=',$key['invoice_product_id'])->first();
            $new = array();
            $new['credit_id'] = $key['credit_id'];
            $new['invoice_product_id'] = $key['invoice_product_id'];
            $new['qty'] = $key['qty'];
            $new['total_amount'] = $key['total_amount'];
            $new['product_name'] = $invoice_product['product_name'];
            $new['product_description'] = $invoice_product['product_description'];
            $new['total_qty'] = $invoice_product['qty'];
            $new['product_total_amount'] = $invoice_product['total_amount'];
            $credit_product[] = $new;
        }
        return view('dashboard.addcredit',compact('client_data','credit','credit_product'));
    }
    else
    {
        return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
    }
}


public function update(Request $request,Tbl_product $Tbl_product)
{
    $data = $request->all();
    $update_credit['credit_number'] = $data['credit_number'];
    $update_credit['reason'] = $data['reason'];
    $update_credit['date'] = date('Y-m-d',strtotime($data['date']));
    $update_credit['total_amount_credit'] = $data['total_amount_credit'];
    $update_credit['total_amount'] = $data['total_amount'];
    $update_credit['charge'] = $data['charge'];

   Tbl_credit::find($request->input('id'))->update($update_credit);

   Tbl_credit_product::where('credit_id', '=', $request->input('id'))->delete();

   $total_credit_product = $data['total_credit_product'];

    for ($i=1; $i <= $total_credit_product; $i++) {

       $credit_pro['credit_id'] = $request->input('id');
       $credit_pro['invoice_product_id'] = $data['invoice_product_id'.$i];
       $credit_pro['qty'] = $data['total_return_qty'.$i];
       $credit_pro['total_amount'] = $data['total_credit'.$i];
       Tbl_credit_product::create($credit_pro);
    }

    return redirect()->route('credits.index',app()->getLocale())
     ->with('success','Credit Update successfully.');
}


    public function destroy($prefix,$id)
    {
        Tbl_credit::find($id)->delete($id);
    }

    public function multydestroy($prefix,Request $request)
    {
        $delid = $request->input('checkid');

        foreach ($delid as $id) {
             Tbl_credit::find($id)->delete($id);
        }

        return redirect()->route('credits.index',app()->getLocale())
        ->with('success','Credits delete successfully.');
    }
}
