<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    public function index()
    {
       return view('dashboard_admin.userslist');
    }


     public function getlist(Request $request){

            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'logo',
                4 => 'expire_date',
                5 => 'created_at',
            );

            $totalData = User::count();
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            if(is_null($dir)){
                $dir = 'DESC';
            }
            $posts = User::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
            $totalFiltered = User::count();
        }else{
            $search = $request->input('search.value');
            $posts = User::where('name', 'like', "%{$search}%")
            ->where(function ($query)  use ($search) {
                $query->orWhere('email','like',"%{$search}%");
                $query->orWhere('expire_date','like',"%{$search}%");
                $query->orWhere('created_at','like',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
            $totalFiltered = User::where('name', 'like', "%{$search}%")
            ->where(function ($query)  use ($search) {
                $query->orWhere('email','like',"%{$search}%");
                $query->orWhere('expire_date','like',"%{$search}%");
                $query->orWhere('created_at','like',"%{$search}%");
            })
            ->count();
        }


    $data = array();

    if($posts){
        foreach($posts as $r){
            $nestedData = array();
            $nestedData[] = "<input type='checkbox' name='checkid[]' class='icheckbox_flat-blue all_del' value='".$r->id."'>";
            $nestedData[] = $r->name;
            $nestedData[] = $r->email;
            $nestedData[] = "<img src='".asset('/public/images/users/'.$r->logo)."'class='img-bordered-sm' style='height:100px; width:100px; border-radius: 50%;' />";
            $nestedData[] = date('d F Y',strtotime($r->created_at)); //Auth::user()->datetime_formate
            $nestedData[] = date('d F Y',strtotime($r->expire_date)); //Auth::user()->date_formate
            $nestedData[] = '
            <a href="'.route('users.edit',$r->id).'" class="btn btn-info btn-xs"><i class="fas fa-edit"></i></a>
            <div class="btn btn-danger btn-xs" onclick="dlt_data('.$r->id.')"><i class="fas fa-trash-alt"></i></div>
            ';
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('dashboard_admin.adduser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'expire_date' => 'required'
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        $data['ch_pass'] = base64_encode($data['password']);
        $data['expire_date'] = date('Y-m-d',strtotime($data['expire_date']));

        $image = $request->file('logo');
        $data['logo'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images/users/');
        $image->move($destinationPath, $data['logo']);

        user::create($data);

        return redirect()->route('users.index')
        ->with('success','User created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        return view('dashboard_admin.adduser',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
       $request->validate([
            'name' => 'required|string|max:255',
            'expire_date' => 'required',
            'password' => 'required|string|min:6',
        ]);
        $data = $request->all();

         $data_update['password'] = Hash::make($data['password']);
         $data_update['name'] = $data['name'];
         $data_update['expire_date'] = date('Y-m-d',strtotime($data['expire_date']));

        if(!empty( $request->file('logo')))
        {
            $data_check = user::where('id','=',$request->input('id'))->first();
            $image = $data_check->logo;
            $image_path = public_path('/images/users/'.$image);
            if(file_exists($image_path)){
                @unlink($image_path);
            }

            $image = $request->file('logo');
            $data_update['logo'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $data_update['logo']);
        }
        $data_update['ch_pass'] = base64_encode($data['password']);
        $user->update($data_update);
        return redirect()->route('users.index')
        ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = user::where('id', '=',$id)->first();
        $image = $data->logo;
        $image_path = public_path('/images/users/'.$image);
        if(file_exists($image_path)){
            @unlink($image_path);
        }
        user::find($id)->delete($id);
    }

    public function multydestroy(Request $request)
    {
        $delid = $request->input('checkid');

        foreach ($delid as $id) {
           $data = user::where('id', '=',$id)->first();
           $image = $data->logo;
           $image_path = public_path('/images/users/'.$image);
           if(file_exists($image_path)){
            @unlink($image_path);
        }
        user::find($id)->delete($id);
    }

    return redirect()->route('users.index')
    ->with('success','Users deleted successfully.');
}

}
