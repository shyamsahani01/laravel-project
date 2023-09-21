<?php

namespace App\Imports;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      // dd($row);
        return new ProductCategory([
            'product_id' => $row['product_id'],
            'name'  => $row['quality'],
            'type' => 'quality'
        ]);
        
    }
}
