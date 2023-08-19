<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payment_detail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'payment_id', 'invoice_id', 'amount'
    ];

}
