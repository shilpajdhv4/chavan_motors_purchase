<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_storage_location";
    protected $fillable = [
       'rank_no','section_no','item_no','current_qty','box_count','location','inserted_date','created_at','updated_at','status','master_id','comp_id'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
