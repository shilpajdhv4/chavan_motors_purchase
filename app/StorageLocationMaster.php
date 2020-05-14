<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class StorageLocationMaster extends Authenticatable
{
    protected $primaryKey = "id";
    public $table = "tbl_master_storage_loc";
    protected $fillable = [
       'rank_no','section_no','location','is_active','master_id','comp_id'];
   
}
