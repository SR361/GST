<?php

namespace App\Http\Controllers;

use App\Models\Tbl_invoice;
use App\Models\Tbl_client;
use App\Models\Tbl_invoice_product;
use App\Models\Tbl_product;
use App\Models\Table_visible;
use App\Models\Tbl_tab;
use App\Models\Tbl_tab_visible;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use View;

class SupplybillController extends Controller
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
        $check = Table_visible::where('user_id', '=', $this->auth_id)->where('name','=','Supplybilllist')->first();
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
        return view('dashboard.supplybilllist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
    }


public function getlist(Request $request){

    $columns = array(
        0 =>  'id',
        1 =>  'invoice_number',
        4 =>  'invoice_date',
        5 =>  'due_date',
        6 =>  'net_amount',
        7 =>  'created_at'
    );

    $totalData = Tbl_invoice::where('user_id', '=', $this->auth_id)->Where('bill_type', '=', '1')->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    // DB::enableQueryLog();
    if(empty($request->input('search.value'))){
        $posts = Tbl_invoice::where('user_id', '=', $this->auth_id)
        ->Where('bill_type', '=', '1')
        ->offset($start)
        ->limit($limit)
        ->orderBy($order,$dir)
        ->get();
        $totalFiltered = Tbl_invoice::where('user_id', '=', $this->auth_id)->Where('bill_type', '=', '1')->count();
    }else{
        $search = $request->input('search.value');
        $company_name = Tbl_client::Where('company_name','like',"%{$search}%")->pluck('id')->all();
        $posts = Tbl_invoice::where('user_id', '=', $this->auth_id)
        ->Where('bill_type', '=', '1')
        ->where(function ($query)  use ($search) {
            $query->orWhere('invoice_number','like',"%{$search}%");
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('invoice_date','like',"%{$search}%");
            $query->orWhere('due_date','like',"%{$search}%");
            $query->orWhere('net_amount','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
        $totalFiltered = Tbl_invoice::where('user_id', '=', $this->auth_id)
        ->Where('bill_type', '=', '0')
        ->where(function ($query)  use ($search) {
            $query->orWhere('invoice_number','like',"%{$search}%");
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('invoice_date','like',"%{$search}%");
            $query->orWhere('due_date','like',"%{$search}%");
            $query->orWhere('net_amount','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
        })
        ->count();
    }
    // $query = DB::getQueryLog();
    // dd($query);


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
                $update_delete = '<a href="'.route('supplybills.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
            }
            else
            {
                $update_delete = '<a href="'.route('supplybills.edit',[app()->getLocale(),$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
            }

            $client_data  = Tbl_client::where('id', '=', $r->client_id)->first();
            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->invoice_number;
            $nestedData[] = $client_data['company_name'];
            $nestedData[] = '<div class="row"><span class="btn-sm btn-info btn-xs mr-1" onclick="check_info('.$r->id.')"><i class="fas fa-info"></i></span><a href="'.route('supplybill',[app()->getLocale(),$r->id]).'" class="btn-sm btn-primary btn-xs" onclick="check_info('.$r->id.')"><i class="fas fa-file-invoice"></i></a></div>';
            $nestedData[] = $r->invoice_date;
            $nestedData[] = $r->due_date;
            $nestedData[] = $r->net_amount.' <i class="fas fa-rupee"></i>';
            $nestedData[] = date(Auth::user()->datetime_formate,strtotime($r->created_at));
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

public function supplybill($prefix,$id){
    $user_id = $this->auth_id;
    $user  = User::where('id', '=', $user_id)->get();
    $invoice = Tbl_invoice::where('id', '=', $id)->first();
    $invoice_product = Tbl_invoice_product::where('invoice_id', '=', $id)->get();
    return view('dashboard.supplybill',compact('invoice','invoice_product','user'));
}


public function data($prefix,Request $request){
    $data = Tbl_invoice_product::where('invoice_id', '=',$request->input('id'))->get();
    $main_invoice = Tbl_invoice::where('id', '=',$request->input('id'))->first();
    $tabl_info = '';

    foreach ($data as $key) {
        $tabl_info .= '<tr>
        <td>'.$key['product_name'].'</td>
        <td>'.$key['product_description'].'</td>
        <td>'.$key['hsn'].'</td>
        <td>'.$key['qty'].'</td>
        <td>'.$key['price'].'<i class="fas fa-rupee"></i></td>
        <td>'.$key['discount_amount'].'</td>
        <td>'.$key['total_amount'].' <i class="fas fa-rupee"></i></td>
        </tr>';
    }

    return '<div class="col-12">
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">'.trans('app.Supply Bill Info').'</h3>
    </div>
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
    <tbody><tr>
    <th>'.trans('app.Product Name').'</th>
    <th>'.trans('app.Description').'</th>
    <th>'.trans('app.HSN').'</th>
    <th>'.trans('app.QTY').'</th>
    <th>'.trans('app.Price').'</th>
    <th>'.trans('app.Discount').'</th>
    <th>'.trans('app.Total Amount').'</th>
    </tr>
    '.$tabl_info.'
    <tr>
    <td colspan="6" style="text-align:right;">'.trans('app.Net Amount').'</td>
    <td>'.$main_invoice['net_amount'].' <i class="fas fa-rupee"></i></td>
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
        $product_data  = Tbl_product::where('user_id', '=', $id)->get();
        return view('dashboard.addsupplybill',compact('client_data','product_data'));
    }else{
        return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
    }
}


public function store(Request $request)
{
    $data = $request->all();

    $invoicedata['user_id'] = $this->auth_id;
    $invoicedata['client_id'] = $data['client_id'];
    $invoicedata['invoice_number'] = '';
    $invoicedata['invoice_date'] = date('Y-m-d',strtotime($data['invoice_date']));
    $invoicedata['payment_terms'] = $data['payment_terms'];
    $invoicedata['due_date'] = date('Y-m-d',strtotime($data['due_date']));
    // $invoicedata['po_no'] = $data['po_no'];
    $invoicedata['place_supply'] = $data['place_supply'];
    $invoicedata['total_amount'] = $data['total_total'];
    $invoicedata['other_charge_type'] = $data['extra_charge'];
    $invoicedata['charge_amount'] = $data['extra_charge_amount'];
    $invoicedata['total_sgst'] = '0';
    $invoicedata['total_cgst'] = '0';
    $invoicedata['total_igst'] = '0';
    $invoicedata['net_amount'] = $data['final_netamount'];
    $invoicedata['note'] = $data['note'];
    $invoicedata['bill_type'] = '1';

    $invoice = Tbl_invoice::create($invoicedata);
    $invoice_id = $invoice->id;

    $no_type = Auth::user()->supply_no;
    $no_date_type = Auth::user()->supply_no_date;

    if($no_date_type == 0)
    {
        $yearnow= date("y");
        $yearnext = $yearnow+1;
        $update_invoice_data['invoice_number'] = $no_type."/".date("y")."-".$yearnext."/".$invoice_id;
    }
    else if($no_date_type == 0)
    {
        $yearnow= date("y");
        $update_invoice_data['invoice_number'] = $no_type."/".$yearnow."/".$invoice_id;
    }
    else
    {
        $yearnow= date("Y");
        $update_invoice_data['invoice_number'] = $no_type."/".$yearnow."/".$invoice_id;
    }

    Tbl_invoice::find($invoice_id)->update($update_invoice_data);

    $total_product_add = $data['total_product_add'];

    for ($i=1; $i <= $total_product_add ; $i++) {
        if($data['remove_product'.$i] == '1')
        {
            $product_details = Tbl_product::where('id', '=',$data['product_id'.$i])->first();
            $productdata['invoice_id'] = $invoice_id;
            $productdata['product_id'] = $data['product_id'.$i];
            $productdata['product_name'] = $product_details['name'];
            $productdata['product_description'] = $product_details['description'];
            $productdata['hsn'] = $product_details['hsn'];
            $productdata['qty'] = $data['qty'.$i];
            $productdata['price'] = $data['price'.$i];
            $productdata['discount'] = $data['discount'.$i];
            $productdata['discount_amount'] = $data['discount'.$i];
            $productdata['cgst'] = '0';
            $productdata['sgst'] = '0';
            $productdata['igst'] = '0';
            $productdata['total_amount'] = $data['total'.$i];
            Tbl_invoice_product::create($productdata);
        }
    }

    $clientdata['company_name'] = $data['clientcompany_name'];
    $clientdata['contact_phone'] = $data['client_number'];
    $clientdata['gstin'] = $data['client_gst'];
    $clientdata['email'] = $data['client_email'];
    $clientdata['address'] = $data['client_address'];

    Tbl_client::find($request->input('client_id'))->update($clientdata);

    return redirect()->route('supplybills.index',app()->getLocale())
     ->with('success','Supply Bill created successfully.');
}

public function edit($prefix,$id)
{
    $update_row = $this->update_row;
    if($update_row == '1')
    {
        $user_id = $this->auth_id;
        $client_data  = Tbl_client::where('user_id', '=', $user_id)->where('type', '!=', '1')->get();
        $product_data  = Tbl_product::where('user_id', '=', $user_id)->get();
        $Tbl_invoice = Tbl_invoice::findOrFail($id);
        $Tbl_invoice_product = Tbl_invoice_product::where('invoice_id', '=', $id)->get();
        return view('dashboard.addsupplybill',compact('Tbl_invoice','Tbl_invoice_product','client_data','product_data'));
    }
    else
    {
        return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
    }
}


public function update(Request $request,Tbl_product $Tbl_product)
{
   $data = $request->all();
   $invoicedata['client_id'] = $data['client_id'];
   // $invoicedata['invoice_number'] = $data['invoice_number'];
   $invoicedata['invoice_date'] = date('Y-m-d',strtotime($data['invoice_date']));
   $invoicedata['payment_terms'] = $data['payment_terms'];
   $invoicedata['due_date'] = date('Y-m-d',strtotime($data['due_date']));
   // $invoicedata['po_no'] = $data['po_no'];
   $invoicedata['place_supply'] = $data['place_supply'];
   $invoicedata['total_amount'] = $data['total_total'];
   $invoicedata['total_sgst'] = '0';
    $invoicedata['total_cgst'] = '0';
    $invoicedata['total_igst'] = '0';
   $invoicedata['other_charge_type'] = $data['extra_charge'];
   $invoicedata['charge_amount'] = $data['extra_charge_amount'];
   $invoicedata['net_amount'] = $data['final_netamount'];
   $invoicedata['note'] = $data['note'];

   Tbl_invoice::find($request->input('id'))->update($invoicedata);

   Tbl_invoice_product::where('invoice_id', '=', $request->input('id'))->delete();

   $total_product_add = $data['total_product_add'];

    for ($i=1; $i <= $total_product_add ; $i++) {
        if($data['remove_product'.$i] == '1')
        {
            $product_details = Tbl_product::where('id', '=',$data['product_id'.$i])->first();
            $productdata['invoice_id'] = $request->input('id');
            $productdata['product_id'] = $data['product_id'.$i];
            $productdata['product_name'] = $product_details['name'];
            $productdata['product_description'] = $product_details['description'];
            $productdata['hsn'] = $product_details['hsn'];
            $productdata['qty'] = $data['qty'.$i];
            $productdata['price'] = $data['price'.$i];
            $productdata['discount'] = $data['discount'.$i];
            $productdata['discount_amount'] = $data['discount'.$i];
            $productdata['cgst'] = '0';
            $productdata['sgst'] = '0';
            $productdata['igst'] = '0';
            $productdata['total_amount'] = $data['total'.$i];
            Tbl_invoice_product::create($productdata);
        }
    }

    $clientdata['company_name'] = $data['clientcompany_name'];
    $clientdata['contact_phone'] = $data['client_number'];
    $clientdata['gstin'] = $data['client_gst'];
    $clientdata['email'] = $data['client_email'];
    $clientdata['address'] = $data['client_address'];

    Tbl_client::find($request->input('client_id'))->update($clientdata);

    return redirect()->route('supplybills.index',app()->getLocale())
     ->with('success','Supply Bill Update successfully.');
}


public function destroy($prefix,$id)
{
    Tbl_invoice_product::where('invoice_id', '=', $id)->delete();
    Tbl_invoice::find($id)->delete($id);
}

public function multydestroy($prefix,Request $request)
{
    $delid = $request->input('checkid');

    foreach ($delid as $id) {
        Tbl_invoice_product::where('invoice_id', '=', $id)->delete();
         Tbl_invoice::find($id)->delete($id);
    }

    return redirect()->route('supplybills.index',app()->getLocale())
    ->with('success','Supply Bill delete successfully.');
}
}
