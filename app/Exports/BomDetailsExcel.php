<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class BomDetailsExcel implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
    }

    public function view(): View
    {

      $erpnextDB = DB::connection("erpnext");

      $query = $erpnextDB
                    ->table("tabEmp Bag Data Child")
                    ->where("parent", $this->request->id);

        $bom_details_data = $query->get();

        return view("exports.bom_details", [
            "bom_details_data" => $bom_details_data,
        ]);

    }
}
