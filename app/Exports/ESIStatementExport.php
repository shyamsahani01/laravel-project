<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class ESIStatementExport implements FromView
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function view(): View
    {
        $query1 = DB::connection('erpnext')
                ->table('tabSalary Slip')
                ->select(DB::raw("esic_no,
                    employee_name,
                    round(payment_days) payment_days,
                    round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
                    `tabSalary Detail`.parent and td.abbr='WA' ),0)) esi_earnings,
                round(amount) esi_contribution") )
                ->leftJoin('tabSalary Detail', function ($join) {
                $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                ->where('tabSalary Detail.abbr', '=', 'ESI');
                })

                ->whereRaw("( SELECT amount FROM  `tabSalary Detail` tsd WHERE tsd.parent = `tabSalary Slip`.name and  tsd.abbr = 'ESI' ) > 0")
                // ->whereRaw("round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
                // `tabSalary Detail`.parent and td.abbr='WA' ),0)) <= 21000")
                ->whereNull('esic_exit_date')
                ->where('esic_no', '!=', NULL);

                if(!empty($this->request->employee_name)){
                    $query1->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
                }

                if(!empty($this->request->company)){
                    $query1->where('company', $this->request->company);
                }


                if(!empty($this->request->month) && !empty($this->request->year)){
                    $query1->whereMonth('start_date', $this->request->month);
                    $query1->whereMonth('end_date', $this->request->month);
                    $query1->whereYear('start_date', $this->request->year);
                    $query1->whereYear('end_date', $this->request->year);
                    }


        $data = $query1->get();

        return view('exports.esi_statement', ['esi_statement_data' => $data]);
    }
}
