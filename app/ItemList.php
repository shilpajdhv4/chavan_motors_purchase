<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ItemList extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_item";
    protected $fillable = [
        'prod_type','product_grp','price','item_no','item_desc','qty','threshold_qty','created_at','updated_at','branch_name','depart_name','user_id','comp_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
