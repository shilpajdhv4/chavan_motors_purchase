<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Branch extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $primaryKey = "branch_id";
    public $table = "tbl_branch";
    
    protected $fillable = [
        'branch_name', 'loc_id','brand_name','mobile_no','brand_head_id','branch_address'
    ];
}