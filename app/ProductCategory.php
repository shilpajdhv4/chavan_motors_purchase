<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_product_categ";
    protected $fillable = [
        'product_name','product_type','created_at','updated_at','branch_name','depart_name','user_id','comp_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
