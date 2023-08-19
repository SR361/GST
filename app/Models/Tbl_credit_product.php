<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_credit_product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'credit_id', 'invoice_product_id', 'qty', 'total_amount'
    ];
}
