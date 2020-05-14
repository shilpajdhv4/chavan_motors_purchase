<?php

namespace App\Imports;

use App\User;
use App\DesignDetail;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportUsers implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
//    public function startRow(): int
//    {
//        return 7;
//    }
    
    public function model(array $row)
    {        
        if(isset($row[6])){
            return new DesignDetail([
                'detail_no' => $row[1],
                'item_desc' => $row[2],
                'item_type' => $row[3],
                'material_type' => $row[4],
                'finish_size' => $row[5],
                'qty' => $row[6]
            ]);
        }
    }
    
    
}
