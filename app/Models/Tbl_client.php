<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','company_name','phone','email','gstin','pan','tin','vat','website','currency','contact_person','contact_phone','contact_name','logo','address','state','pin','type'
    ];



}
