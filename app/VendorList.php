<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class VendorList extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_vendor";
    protected $fillable = [
        'vendor_name','mob_no','pan_card_no','gst_no','address','product_type','inserted_date','created_at','updated_at','user_id','contact_name',
        'comp_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
