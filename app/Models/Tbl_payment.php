<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'user_id', 'client_id', 'number', 'date', 'method', 'amount', 'refrence','bank_charge','amount_used','amount_excess','payment_type','note'
    ];

}
