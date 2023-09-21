<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class BankSheetHDFCBankExport implements FromView
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function view(): View
    {

      $query1 = DB::connection('erpnext')
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::raw("tss.employee,
                  tss.attendance_device_id,
                  tss.employee_name,
                  tss.net_pay,
                  tabEmployee.bank_ac_no,
                  tabEmployee.bank_name_new") )
                  ->join('tabEmployee', "tabEmployee.employee", "=", "tss.employee")
                  // ->whereRaw(" tabEmployee.bank_ac_no = tss.bank_account_no ")
                  // and te.bank_ac_no = tss.bank_account_no
                  // ->where('tabEmployee.bank_ac_no', '=', 'tss.bank_account_no')
                  ->where('tabEmployee.bank_name_new', '=', 'HDFC Bank')
                  ->where('tss.docstatus', '<=', 1);

        if(!empty($this->request->employee_name)){
              $query1->where('tss.employee_name', 'like', '%' . $this->request->employee_name. '%');
          }

        if(!empty($this->request->company)){
            $query1->where('tss.company',$this->request->company);
        }

        $current_month = date("m", time());
        $current_year = date("Y", time());

        if(!empty($this->request->month) && !empty($this->request->year)){
          $current_month = $this->request->month;
          $current_year = $this->request->year;
        }

        $query1->whereMonth('tss.start_date', $current_month);
        $query1->whereMonth('tss.end_date', $current_month);
        $query1->whereYear('tss.start_date', $current_year);
        $query1->whereYear('tss.end_date', $current_year);


        $query1->limit(1500);

        $bank_sheet_data = $query1->get();

        // print_r("<pre>");
        // print_r("hi22");
        // // print_r($this->request);
        // print_r($bank_sheet_data);
        // die;

        return view("exports.hdfc_bank", [
            "bank_sheet_data" => $bank_sheet_data,
        ]);

    }
}
