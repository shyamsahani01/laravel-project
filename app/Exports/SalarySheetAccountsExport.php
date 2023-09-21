<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class SalarySheetAccountsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function view(): View
    {

      $current_month = date("m", time());
      $current_year = date("Y", time());

      if(!empty($this->request->month) && !empty($this->request->year)){
        $current_month = $this->request->month;
        $current_year = $this->request->year;
      }


      $query1 = DB::connection('erpnext')
                  ->table('tabSalary Component AS tsc')
                  ->select(DB::raw("SUM(tsd.amount) amount, tsc.name, tsc.type, tsc.salary_component_abbr") )
                  ->leftJoin('tabSalary Detail AS tsd', "tsd.abbr", "=", "tsc.salary_component_abbr")
                  ->leftJoin('tabSalary Slip AS tss', "tss.name", "=", "tsd.parent")
                  ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  ->where('te.occupation_accounts', '=', 'Direct')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($this->request->company)){
            $query1->where('tss.company',$this->request->company);
        }

        $query1->whereMonth('tss.start_date', $current_month);
        $query1->whereMonth('tss.end_date', $current_month);
        $query1->whereYear('tss.start_date', $current_year);
        $query1->whereYear('tss.end_date', $current_year);


      $salary_sheet_data['direct'] = $query1->get();


      $query2 = DB::connection('erpnext')
                  ->table('tabSalary Component AS tsc')
                  ->select(DB::raw("SUM(tsd.amount) amount, tsc.name, tsc.type, tsc.salary_component_abbr") )
                  ->leftJoin('tabSalary Detail AS tsd', "tsd.abbr", "=", "tsc.salary_component_abbr")
                  ->leftJoin('tabSalary Slip AS tss', "tss.name", "=", "tsd.parent")
                  ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  ->where('te.occupation_accounts', '=', 'Indirect')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($this->request->company)){
            $query2->where('tss.company',$this->request->company);
        }


        $query2->whereMonth('tss.start_date', $current_month);
        $query2->whereMonth('tss.end_date', $current_month);
        $query2->whereYear('tss.start_date', $current_year);
        $query2->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['indirect'] = $query2->get();

      $query3 = DB::connection('erpnext')
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::raw("te.occupation_accounts, sum(tss.gross_monthly_salary) gross_monthly_salary, COUNT(te.employee) employee_count") )
                  ->join('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('te.occupation_accounts');

        if(!empty($this->request->company)){
            $query3->where('tss.company',$this->request->company);
        }

        $query3->whereMonth('tss.start_date', $current_month);
        $query3->whereMonth('tss.end_date', $current_month);
        $query3->whereYear('tss.start_date', $current_year);
        $query3->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['gross_data'] = $query3->get();


      $query4 = DB::connection('erpnext')
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::raw("bank_name_new, sum(net_pay) net_pay") )
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tss.bank_name_new');

        if(!empty($this->request->company)){
            $query4->where('tss.company',$this->request->company);
        }

        $query4->whereMonth('tss.start_date', $current_month);
        $query4->whereMonth('tss.end_date', $current_month);
        $query4->whereYear('tss.start_date', $current_year);
        $query4->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['bank_data'] = $query4->get();

        return view("exports.salary_sheet_accounts", [
            "salary_sheet_data" => $salary_sheet_data,
        ]);

    }
}
