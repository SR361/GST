<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_invoice_product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'invoice_id','product_id', 'product_name', 'product_description', 'hsn', 'qty', 'price', 'discount', 'discount_amount', 'cgst', 'sgst', 'igst', 'total_amount'
    ];
}
