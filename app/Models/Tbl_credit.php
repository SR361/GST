<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_credit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'user_id', 'client_id', 'invoice_id', 'credit_number', 'reason', 'invoice_date', 'date', 'total_amount_credit','total_amount', 'charge','status'
    ];
}
