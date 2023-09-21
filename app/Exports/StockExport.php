<?php

namespace App\Exports;

use App\Models\erp\Stocks;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockExport implements FromCollection,WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stocks::groupBy('item_code')->where('item_code','AMS_R')->get();
    }


    public function headings() :array
    {
        return ["First Name", "Last Name", "Mobile","DOB", "Gender"];
    }
}
