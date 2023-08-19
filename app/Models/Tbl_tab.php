<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_tab extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'name', 'icon', 'url', 'status','position'
    ];
}
