<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_order";
    protected $fillable = [
       'type','product_grp','vendor_name','item_name','item_no','qty','remark','created_at','updated_at','branch_name','depart_name','user_id','inserted_date',
        'status_approved_by_dm','status_remark_by_dm','status_approved_by_gm','status_remark_by_gm','purchase_status','is_active',
        'given_quntity','return_qty','remaning_qty','dm_date','gm_date','comp_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
