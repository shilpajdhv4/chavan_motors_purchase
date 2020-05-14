<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = "loc_id";
    public $table = "tbl_location";
    protected $fillable = [
        'loc_name','user_id','user_id','comp_id'
    ];
}
