<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PFChallanExport implements FromView
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
        ->select(DB::raw("uan_number,
                  employee_name,
                  round(gross_pay) gross_pay,
                  IF(amount<15000, round(amount),  round(15000)  )  amount1,
                  IF(amount<15000, round(amount),  round(15000)  )  amount2,
                  IF(amount<15000, round(amount),  round(15000)  )  amount3,
                  IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) pf,
                  IF(amount<15000, round(((amount*8.33)/100)),  round(((15000*8.33)/100))  ) eps,
                  IF(amount<15000,
                      ( round(((amount*12)/100)) - round(((amount*8.33)/100) )  ),
                      ( round(((15000*12)/100)) - round(((15000*8.33)/100) )  )  )  epsepf,
                  round(leave_without_pay) leave_without_pay,
                  eps_scheme_not_applicable") )
        ->leftJoin('tabSalary Detail', function ($join) {
            $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                ->where('tabSalary Detail.abbr', '=', 'B');
          })
        ->where('eps_scheme_not_applicable', '=', 0)
        ->where('uan_number', '!=', '')
        ->OrderBy('uan_number','ASC');

        if(!empty($this->request->employee_name)){
            $query1->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
        }

        if(!empty($this->request->company)){
            $query1->where('company',$this->request->company);
        }


        if(!empty($this->request->month) && !empty($this->request->year)){
            $query1->whereMonth('start_date', $this->request->month);
            $query1->whereMonth('end_date', $this->request->month);
            $query1->whereYear('start_date', $this->request->year);
            $query1->whereYear('end_date', $this->request->year);
          }


        $query2 = DB::connection('erpnext')
                ->table('tabSalary Slip')
                ->select(DB::raw("uan_number,
                                employee_name,
                                round(gross_pay) gross_pay,
                                IF(amount<15000, round(amount),  round(15000)  ) amount1,
                                0 amount2,
                                IF(amount<15000, round(amount),  round(15000)  ) amount3,
                                IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) pf,
                                0 eps,
                                IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) epsepf,
                                round(leave_without_pay) leave_without_pay,
                                eps_scheme_not_applicable") )
                ->leftJoin('tabSalary Detail', function ($join) {
                    $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                        ->where('tabSalary Detail.abbr', '=', 'B');
                })
                ->where('eps_scheme_not_applicable', '=', 1)
                ->where('uan_number', '!=', '')
                ->OrderBy('uan_number','ASC')
                ->union($query1);

        if(!empty($this->request->employee_name)){
            $query2->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
        }

        if(!empty($this->request->company)){
            $query2->where('company', $this->request->company);
        }

        if(!empty($this->request->month) && !empty($this->request->year)){
            $query2->whereMonth('start_date', $this->request->month);
            $query2->whereMonth('end_date', $this->request->month);
            $query2->whereYear('start_date', $this->request->year);
            $query2->whereYear('end_date', $this->request->year);
          }

        $data = $query2->get();

        return view('exports.pf_challan', ['pf_challan_data' => $data]);
    }
}
