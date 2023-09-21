<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;
use DB;

class QuotationDesign1Export implements FromView
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
        $this->erpnextDB = DB::connection('erpnext');
        $this->localdesignDB = DB::connection('localdesign');
    }
    public function view(): View
    {

        $query = $this->erpnextDB
                          ->table("tabQuotation");
        $query->where('name', $this->request->quotation_id);
        $quotation_data = $query->first();

        $query1 = $this->localdesignDB
                              ->table("quotation_design_1");
        $query1->where('quotation_table_id', $this->request->quotation_id);
        $query1->orderBy('current_row_no', "ASC");
        $design_data = $query1->get();

       $query2 = $this->localdesignDB
                             ->table("quotation_design_header");
       $query2->where('quotation_table_id', $this->request->quotation_id);
       $design_header_data = $query2->first();


        return view('exports.quotation_design1', [
            "quotation_data" => $quotation_data,
            "design_data" => $design_data,
            "design_header_data" => $design_header_data,
        ]);
    }

}
