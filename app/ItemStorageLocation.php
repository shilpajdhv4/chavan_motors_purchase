<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ItemStorageLocation extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_items_storage_loc";
    protected $fillable = [
       'sl_id','item_no','qty','inserted_date','created_at','updated_at'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
