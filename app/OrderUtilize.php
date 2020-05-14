<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OrderUtilize extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_order_utilize";
    protected $fillable = [
       'po_id','order_id','user_id','item_no','actual_qty','stock_qty','used_qty','inserted_date','created_at','updated_at','remark'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
