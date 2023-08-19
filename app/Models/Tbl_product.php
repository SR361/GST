<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id','name', 'description', 'quantity', 'unit', 'tax', 'hsn', 'sale_price', 'sale_currency', 'sale_cess_per', 'sale_cess_pluse', 'purchase_price', 'purchase_currency', 'purchase_cess_per', 'purchase_cess_pluse'
    ];

}
