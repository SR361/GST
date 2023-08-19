<?php

namespace App\Http\Middleware;

use App;
use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

class CheckUserPlan
{
	public function handle($request, Closure $next)
	{
		$date = date('Y-m-d');
		$check = User::where('id', '=', Auth::id())->first();
		if($date >= $check['expire_date'])
		{
			if($check['role_type'] != 'null')
			{
				$check_new = User::where('id', '=', $check['user_id'])->first();
				if($date >= $check_new['expire_date'])
				{
					return redirect('/en/plan_expire');
				}
				else
				{
					return $next($request);
				}
			}
			else
			{
				return redirect('/en/plan_expire');
			}
		}
		else
		{
			return $next($request);
		}

    }
}
