<?php

namespace App\Exports;

use App\Models\Rent;
use Maatwebsite\Excel\Concerns\FromCollection;

class ComplteRentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rent::all();
    }
}
