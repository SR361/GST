<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name','user_id'
    ];
}
