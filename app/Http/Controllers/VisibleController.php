<?php

namespace App\Http\Controllers;

use App\Models\Table_visible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class VisibleController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($prefix,Request $request)
    {
        $data = $request->all();
        $check = Table_visible::where('name','=',$request->input('name'))->where('user_id', '=', Auth::id())->first();
        if(empty($check))
        {
            $data1['notvisible'] = $request->input('notvisible');
            $data1['name'] = $request->input('name');
            $data1['_token'] = $request->input('_token');
            $data1['user_id'] = Auth::id();
            Table_visible::create($data1);
        }
        else
        {
            $notvisi_array = explode(',',$check->notvisible);
            if($request->input('notvisible') != '') // && !in_array($request->input('notvisible'), $notvisi_array)
            {
                $val = $request->input('val');

                if($val == '1')
                {
                   foreach (array_keys($notvisi_array, $request->input('notvisible')) as $key) {
                      unset($notvisi_array[$key]);
                   }
                   $new_arry = $notvisi_array;

                   $data1['notvisible'] = implode(',', $new_arry);
                }
                else
                {
                    if(!empty($check->notvisible))
                    {
                        $data1['notvisible'] = $check->notvisible.",".$request->input('notvisible');
                    }
                    else
                    {
                        $data1['notvisible'] = $request->input('notvisible');
                    }

                }

            }
            else
            {
                $data1['notvisible'] = $check->notvisible;
            }
            Table_visible::where('name', '=',$request->input('name'))->where('user_id', '=', Auth::id())->update($data1);
        }
    }
}
