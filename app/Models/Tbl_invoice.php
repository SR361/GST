<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'user_id','client_id', 'invoice_number', 'invoice_date', 'payment_terms', 'due_date', 'po_no', 'place_supply', 'total_amount', 'total_sgst', 'total_cgst', 'total_igst', 'other_charge_type', 'charge_amount', 'net_amount', 'note','bill_type','payment_amount','payment_check'
    ];
}
