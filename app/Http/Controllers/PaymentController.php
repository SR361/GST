<?php
namespace App\Http\Controllers;

use App\Models\Tbl_payment;
use App\Models\Tbl_payment_detail;
use App\Models\Tbl_invoice;
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
use View;

class PaymentController extends Controller
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
        $check = Table_visible::where('user_id', '=', $this->auth_id)->where('name','=','Paymentlist')->first();
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
        return view('dashboard.paymentlist',compact('array_check','add_row','update_row','delete_row','excel','pdf','print','col_visible','show_row'));
    }


public function getlist(Request $request){

    $columns = array(
        0 =>  'id',
        1 =>  'number',
        3 =>  'date',
        5 =>  'amount',
        6 =>  'type',
        7 =>  'created_at'
    );

    $totalData = Tbl_payment::where('user_id', '=', $this->auth_id)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    // DB::enableQueryLog();
    if(empty($request->input('search.value'))){
        $posts = Tbl_payment::where('user_id', '=', $this->auth_id)
        ->offset($start)
        ->limit($limit)
        ->orderBy($order,$dir)
        ->get();
        $totalFiltered = Tbl_payment::where('user_id', '=', $this->auth_id)->count();
    }else{
        $search = $request->input('search.value');
        $posts = Tbl_payment::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('number','like',"%{$search}%");
            $query->orWhere('date','like',"%{$search}%");
            $query->orWhere('amount','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
        $totalFiltered = Tbl_payment::where('user_id', '=', $this->auth_id)
        ->where(function ($query)  use ($search) {
            $query->orWhereIn('client_id', function($query) use ($search)
            {
                $query->select('id')
                ->from('tbl_clients')
                ->Where('company_name','like',"%{$search}%");
            });
            $query->orWhere('number','like',"%{$search}%");
            $query->orWhere('date','like',"%{$search}%");
            $query->orWhere('amount','like',"%{$search}%");
            $query->orWhere('created_at','like',"%{$search}%");
        })
        ->count();
    }
    // $query = DB::getQueryLog();
    // dd($query);

    $data = array();

    if($posts){
        foreach($posts as $r){
            if($r->payment_type == '1')
            {
                 $payment_type = '<p style="color:red;"><b>'.trans('app.Made').'</b></p>';
                 $payment = 'made';
            }
            else
            {
                $payment_type = '<p style="color:green;"><b>'.trans('app.Received').'</b></p>';
                $payment = 'received';
            }

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
                $update_delete = '<a href="'.route('paymentedit',[app()->getLocale(),$payment,$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a>';
            }
            else
            {
                $update_delete = '<a href="'.route('paymentedit',[app()->getLocale(),$payment,$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
            }

            $client_data  = Tbl_client::where('id', '=', $r->client_id)->first();
            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->number;
            $nestedData[] = $client_data['company_name'];
            $nestedData[] = date(Auth::user()->date_formate,strtotime($r->date));
            $nestedData[] = '<span class="btn-sm btn-info btn-xs mr-1" onclick="check_info('.$r->id.')"><i class="fas fa-info"></i></span><a href="'.route('payment',[app()->getLocale(),$r->id]).'" class="btn-sm btn-primary btn-xs" onclick="check_info('.$r->id.')"><i class="fas fa-file-invoice"></i></a>';
            $nestedData[] = $r->amount;
            $nestedData[] = $payment_type;
            $nestedData[] = date(Auth::user()->datetime_formate,strtotime($r->created_at));
            $nestedData[] = '<a href="'.route('paymentedit',[app()->getLocale(),$payment,$r->id]).'" class="btn-sm btn-info btn-xs"><i class="fas fa-edit"></i></a><span class="btn-sm btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></span>';
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

public function payment($prefix,$id){
    $user_id = $this->auth_id;
    $user  = User::where('id', '=', $user_id)->first();
    $payment = Tbl_payment::where('id', '=', $id)->first();
    $payment_data_array = Tbl_payment_detail::where('payment_id', '=', $id)->get();
    $payment_data = array();
    $count = '0';
    foreach ($payment_data_array as $key) {
        $data = Tbl_invoice::where('id', '=',$key['invoice_id'])->first();
        $new = array();
        $new['invoice_number'] = $data['invoice_number'];
        $new['date'] = $data['invoice_date'];
        $new['amount'] = $data['net_amount'];
        $new['payment_val'] = $key['amount'];
        $payment_data[$count++] = $new;
    }

    return view('dashboard.payment',compact('payment','payment_data','user'));
}

public function data($prefix,Request $request){
    $data = Tbl_payment_detail::where('payment_id', '=',$request->input('id'))->get();
    $tabl_info = '';

    foreach ($data as $key) {
        $check_invoice = Tbl_invoice::where('id', '=',$key['invoice_id'])->first();
        $tabl_info .= '<tr>
        <td>'.$check_invoice['invoice_number'].'</td>
        <td>'.$check_invoice['net_amount'].'</td>
        <td>'.$key['amount'].'</td>
        <td>'.date(Auth::user()->date_formate,strtotime($key['created_at'])).'</td>
        </tr>';
    }

    return '<div class="col-12">
    <div class="card">
    <div class="card-header">
    <h3 class="card-title">'.trans('app.Payment Info').'</h3>
    </div>
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
    <tbody><tr>
    <th>'.trans('app.Invoice Number').'</th>
    <th>'.trans('app.Invoice Net Amount').'</th>
    <th>'.trans('app.Payment Amount').'</th>
    <th>'.trans('app.Date').'</th>
    </tr>
    '.$tabl_info.'
    </tbody></table>
    </div>
    </div>
    </div>';
}



public function create($prefix,$type)
{
    $add_row = $this->add_row;
    if($add_row == '1')
    {
        if($type == 'made' || $type == 'received')
        {
            $id = $this->auth_id;
            $client_data = Tbl_client::where('user_id', '=', $id)->where('type', '!=', '1')->get();
            $vendor_data = Tbl_client::where('user_id', '=', $id)->where('type', '!=', '0')->get();

            return view('dashboard.addpayment',compact('client_data','type','vendor_data'));
        }
        else
        {
         return redirect()->route('home',app()->getLocale());
     }
    }else{
        return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
    }
}


public function clientpaymentinfo()
{
    $client_id = $_POST['id'];
    $bill_type = $_POST['bill_type'];
    $data = Tbl_invoice::where('client_id', '=',$client_id)->where('payment_check', '=','0')->where('bill_type', '=',$bill_type)->get();

    $info['total_invoice'] = count($data);

    $info['tabl_info'] = '';
    $i = 1;
    foreach ($data as $key) {
        if($key['payment_amount'] == 'null')
        {
             $payment_due = $key['net_amount'];
        }
        else
        {
            $payment_due = ($key['net_amount']-$key['payment_amount']);
        }
        $info['tabl_info'] .= '<tr>
        <td><input type="hidden" value="'.$key['id'].'" id="invoice_id'.$i.'" name="invoice_id'.$i.'">'.$key['invoice_date'].'</td>
        <td>'.$key['invoice_number'].'</td>
        <td>'.$key['net_amount'].'</td>
        <td>'.$payment_due.'</td>
        <td><input type="number" onkeyup="final_result();" max="'.$payment_due.'" min="0" class="form-control" value="0" id="payment_add'.$i.'" name="payment_add'.$i.'"></td>
        </tr>';
        $i ++;
    }

    return json_encode($info);
}


public function store(Request $request)
{
    $data = $request->all();
    $paymentdata['user_id'] = $this->auth_id;
    $paymentdata['client_id'] = $data['client_id'];
    $paymentdata['number'] = $data['number'];
    $paymentdata['date'] = date('Y-m-d',strtotime($data['date']));
    $paymentdata['method'] = $data['method'];
    $paymentdata['amount'] = $data['amount'];
    // $paymentdata['refrence'] = $data['refrence'];
    $paymentdata['bank_charge'] = $data['bank_charge'];
    $paymentdata['amount_used'] = $data['amount_used'];
    $paymentdata['amount_excess'] = $data['amount_excess'];
    $paymentdata['payment_type'] = $data['payment_type'];
    $paymentdata['note'] = $data['note'];

    $payment = Tbl_payment::create($paymentdata);
    $payment_id = $payment->id;

    $total_invoice = $data['total_invoice'];

    for ($i=1; $i <= $total_invoice ; $i++) {

        $paymentdetaildata['payment_id'] = $payment_id;
        $paymentdetaildata['invoice_id'] = $data['invoice_id'.$i];
        $paymentdetaildata['amount'] = $data['payment_add'.$i];
        Tbl_payment_detail::create($paymentdetaildata);

        $check_invoice = Tbl_invoice::where('id', '=',$data['invoice_id'.$i])->first();

        if($check_invoice['payment_amount'] == 'null')
        {
            $payment_due = $check_invoice['net_amount'];
            if($check_invoice['net_amount'] == $data['payment_add'.$i])
            {
                 $invoicedata['payment_check'] = '1';
            }
            $invoicedata['payment_amount'] = $data['payment_add'.$i];
            Tbl_invoice::find($data['invoice_id'.$i])->update($invoicedata);
        }
        else
        {
            $payment_due = ($check_invoice['net_amount']-$check_invoice['payment_amount']);
            if($payment_due == $data['payment_add'.$i])
            {
                 $invoicedata['payment_check'] = '1';
            }
            $invoicedata['payment_amount'] = $check_invoice['payment_amount'] + $data['payment_add'.$i];
            Tbl_invoice::find($data['invoice_id'.$i])->update($invoicedata);
        }
    }

    return redirect()->route('payments.index',app()->getLocale())
     ->with('success','Payment created successfully.');
}

public function edit($prefix,$type,$id)
{
  $update_row = $this->update_row;
  if($update_row == '1')
  {
    if($type == 'made' || $type == 'received')
    {
        $user_id = $this->auth_id;
        $client_data = Tbl_client::where('user_id', '=', $user_id)->where('type', '!=', '1')->get();
        $vendor_data = Tbl_client::where('user_id', '=', $user_id)->where('type', '!=', '0')->get();
        $payment = Tbl_payment::where('id', '=', $id)->first();
        $payment_d = Tbl_payment_detail::where('payment_id', '=', $id)->get();
        $payment_details = array();
        $count = '0';
        foreach ($payment_d as $key) {
            $data = Tbl_invoice::where('id', '=',$key['invoice_id'])->first();
            $new = array();
            $new['invoice_id'] = $key['invoice_id'];
            $new['date'] = $data['invoice_date'];
            $new['number'] = $data['invoice_number'];
            $new['amount'] = $data['net_amount'];
            $new['amount_due'] = ($data['net_amount']-$data['payment_amount']);
            $new['payment_val'] = $key['amount'];
            $payment_details[$count++] = $new;
        }
        return view('dashboard.addpayment',compact('client_data','type','vendor_data','payment','payment_details'));
    }
    else
    {
       return redirect()->route('home',app()->getLocale());
    }
  }
  else
  {
    return redirect()->route('home',app()->getLocale())->with('message', 'Not Found.');
  }
}


public function update(Request $request,Tbl_product $Tbl_product)
{
    $data = $request->all();

    $payment_data = Tbl_payment::where('id', '=',$data['id'])->first();

    $payment_amount = $payment_data['amount'];

    Tbl_payment::find($data['id'])->delete($data['id']);

    $paymentdata['user_id'] = $this->auth_id;
    $paymentdata['client_id'] = $data['client_id'];
    $paymentdata['number'] = $data['number'];
    $paymentdata['date'] = date('Y-m-d',strtotime($data['date']));
    $paymentdata['method'] = $data['method'];
    $paymentdata['amount'] = $data['amount'];
    // $paymentdata['refrence'] = $data['refrence'];
    $paymentdata['bank_charge'] = $data['bank_charge'];
    $paymentdata['amount_used'] = $data['amount_used'];
    $paymentdata['amount_excess'] = $data['amount_excess'];
    $paymentdata['payment_type'] = $data['payment_type'];
    $paymentdata['note'] = $data['note'];

    $payment = Tbl_payment::create($paymentdata);
    $payment_id = $payment->id;

    $total_invoice = $data['total_invoice'];

    for ($i=1; $i <= $total_invoice ; $i++) {

        $invoice_data = Tbl_invoice::where('id', '=',$data['invoice_id'.$i])->first();
        if($invoice_data != '')
        {
            $data_update['payment_amount'] = $invoice_data['payment_amount'] - $payment_amount;
            Tbl_invoice::find($data['invoice_id'.$i])->update($data_update);
        }


        $paymentdetaildata['payment_id'] = $payment_id;
        $paymentdetaildata['invoice_id'] = $data['invoice_id'.$i];
        $paymentdetaildata['amount'] = $data['payment_add'.$i];
        Tbl_payment_detail::create($paymentdetaildata);

        $check_invoice = Tbl_invoice::where('id', '=',$data['invoice_id'.$i])->first();

        if($check_invoice['payment_amount'] == 'null')
        {
            $payment_due = $check_invoice['net_amount'];
            if($check_invoice['net_amount'] == $data['payment_add'.$i])
            {
                 $invoicedata['payment_check'] = '1';
            }
            $invoicedata['payment_amount'] = $data['payment_add'.$i];
            Tbl_invoice::find($data['invoice_id'.$i])->update($invoicedata);
        }
        else
        {
            $payment_due = ($check_invoice['net_amount']-$check_invoice['payment_amount']);
            if($payment_due == $data['payment_add'.$i])
            {
                 $invoicedata['payment_check'] = '1';
            }
            $invoicedata['payment_amount'] = $check_invoice['payment_amount'] + $data['payment_add'.$i];
            Tbl_invoice::find($data['invoice_id'.$i])->update($invoicedata);
        }
    }

    return redirect()->route('payments.index',app()->getLocale())
     ->with('success','Payment Update successfully.');
}


public function destroy($prefix,$id)
{
    $payment_data = Tbl_payment_detail::where('payment_id','=',$id)->get();
    foreach ($payment_data as $key) {
        $invoice_data = Tbl_invoice::where('id', '=',$key['invoice_id'])->first();

        if($invoice_data != '')
        {
            $data_update['payment_amount'] = $invoice_data['payment_amount'] - $key['amount'];
            Tbl_invoice::find($key['invoice_id'])->update($data_update);
        }
    }
    Tbl_payment::find($id)->delete($id);

}

public function multydestroy($prefix,Request $request)
{
    $delid = $request->input('checkid');

    foreach ($delid as $id) {
        $payment_data = Tbl_payment_detail::where('payment_id','=',$id)->get();
    foreach ($payment_data as $key) {
        $invoice_data = Tbl_invoice::where('id', '=',$key['invoice_id'])->first();

        if($invoice_data != '')
        {
            $data_update['payment_amount'] = $invoice_data['payment_amount'] - $key['amount'];
            Tbl_invoice::find($key['invoice_id'])->update($data_update);
        }
    }
    Tbl_payment::find($id)->delete($id);
    }

    return redirect()->route('payments.index',app()->getLocale())
    ->with('success','Payment delete successfully.');
}
}
