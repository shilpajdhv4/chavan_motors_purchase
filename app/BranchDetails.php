<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class BranchDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_branch_details";
    
    protected $fillable = [
        'branch_name', 'created_at','created_at','updated_at'
    ];
}