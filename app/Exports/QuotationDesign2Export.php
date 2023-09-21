<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;
use DB;

class QuotationDesign2Export implements FromView
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $query1 = DB::connection('localdesign')
                ->table('quotation_design_2')
                ->where('quotation_table_id', $this->request->quotation_id);
        $design_data = $query1->get();

        $query2 = DB::connection('localdesign')
                ->table('quotation_design_header')
                ->where('quotation_table_id', $this->request->quotation_id);
        $design_header_data = $query2->first();


        return view('exports.quotation_design2', [
            "design_data" => $design_data, 
            "design_header_data" => $design_header_data,
        ]);
    }

}