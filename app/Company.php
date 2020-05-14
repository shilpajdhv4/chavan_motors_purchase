<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $primaryKey = "company_id";
    public $table = "tbl_company_master";
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'company_name', 'level_permission','is_active','return_permission'
    ];
}