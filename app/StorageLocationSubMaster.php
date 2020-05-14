<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class StorageLocationSubMaster extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_sub_master_storage_location";
    protected $fillable = [
       'master_id','section_no','inserted_date','is_active','comp_id'];
   
}
