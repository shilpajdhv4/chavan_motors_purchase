<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class DepartmentDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_depart_details";
    
    protected $fillable = [
        'depart_name', 'created_at','created_at','updated_at','comp_id'
    ];
}