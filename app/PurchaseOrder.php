<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_purchase_order";
    protected $fillable = [
       'order_id','vendor_id','item_no','item_desc','price','qty','inserted_date','created_at','updated_at','type','product_grp','user_id','tl_ids','po_id','remark',
        'maker_status','maker_date','checker_status','checker_date','received_qty','received_date','received_remark',
        'storage_status','update_status','file_upload','comp_id','storage_add_qty'];
    
}
