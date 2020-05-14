<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Checker extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_checker";
    protected $fillable = [
        'order_id','return_qty','purches_status','approve_id','purches_remark','tl_remark','tl_id','sm_status','status','sm_date','remark',
        'gm_status','gm_remark','gm_date','comp_id'
    ];
   
    
}
