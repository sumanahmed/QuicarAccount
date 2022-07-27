<?php

namespace App\Import;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel,WithHeadingRow
{   

    public function __construct()
    {  
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        return new Customer([            
            'name'  => $row['name'],
            'phone' => "0".$row['phone'],
        ]);
    }

    public function sheets(): array
    {
        return [
            0 => new CustomerImport(),
        ];
    }
}
