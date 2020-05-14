<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ApprovedOrder extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_approved_order";
    protected $fillable = [
       'order_id','item_no','item_desc','order_qty','received_qty','user_id','branch_name','depart_name','received_date','created_at','updated_at','cheker_flag',
        'return_qty','remaning_qty'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
