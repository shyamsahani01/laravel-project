<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PFStatementExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
      // $query1 = DB::connection('erpnext')
      //   ->table('tabSalary Slip')
      //   ->select(DB::raw("uan_number,
      //             employee_name,
      //             round(amount) amount,
      //             round(((amount*12)/100)) pf,
      //             round(((amount*8.33)/100)) eps,
      //             round(round(((amount*12)/100)) - round(((amount*8.33)/100)) ) epsepf,
      //             eps_scheme_not_applicable") )
      $query1 = DB::connection('erpnext')
        ->table('tabSalary Slip')
        ->select(DB::raw("uan_number,
                  employee_name,
                  IF(amount<15000, round(amount),  round(15000)  ) amount,
                  IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) pf,
                  IF(amount<15000, round(((amount*8.33)/100)),  round(((15000*8.33)/100))  ) eps,
                  IF(amount<15000,
                      ( round(((amount*12)/100)) - round(((amount*8.33)/100) )  ),
                      ( round(((15000*12)/100)) - round(((15000*8.33)/100) )  )  )  epsepf,
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
                                IF(amount<15000, round(amount),  round(15000)  ) amount,
                                IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) pf,
                                0 eps,
                                IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100))  ) epsepf,
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
                $query2->where('company',$this->request->company);
            }


            if(!empty($this->request->month) && !empty($this->request->year)){
                $query2->whereMonth('start_date', $this->request->month);
                $query2->whereMonth('end_date', $this->request->month);
                $query2->whereYear('start_date', $this->request->year);
                $query2->whereYear('end_date', $this->request->year);
                }

        $data = $query2->get();


        // $query3 = DB::connection('erpnext')
        //         ->table('tabSalary Slip')
        //         ->select(DB::raw("COUNT(*) AS totalemp") );

        //     if(!empty($request->employee_name)){
        //           $query3->where('employee_name', 'like', '%' . $request->employee_name. '%');
        //     }

        //     if(!empty($request->company)){
        //         $query3->where('company',$this->request->company);
        //     }

        //     if(!empty($request->start_date) && !empty($request->end_date)){
        //       $query3->where('start_date', ">=", $request->start_date);
        //       $query3->where('end_date', "<=", $request->end_date);
        //     }

        //     if(!empty($request->month) && !empty($request->year)){
        //       $query3->whereMonth('start_date', $request->month);
        //       $query3->whereMonth('end_date', $request->month);
        //       $query3->whereYear('start_date', $request->year);
        //       $query3->whereYear('end_date', $request->year);
        //     }


        $query4 = DB::connection('erpnext')
                ->table('tabSalary Slip')
                ->select(DB::raw("COUNT(*) AS employees1") )
                ->where(function($query) {
                    $query->where('uan_number', '=', '')
                          ->orWhere('uan_number',  NULL);
                });


                if(!empty($this->request->employee_name)){
                  $query4->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
              }

              if(!empty($this->request->company)){
                  $query4->where('company',$this->request->company);
              }


              if(!empty($this->request->month) && !empty($this->request->year)){
                  $query4->whereMonth('start_date', $this->request->month);
                  $query4->whereMonth('end_date', $this->request->month);
                  $query4->whereYear('start_date', $this->request->year);
                  $query4->whereYear('end_date', $this->request->year);
                  }


        $query5 = DB::connection('erpnext')
                  ->table('tabSalary Slip')
                  ->select(DB::raw("round(gross_pay) gross_pay") )
                  ->leftJoin('tabSalary Detail', function ($join) {
                    $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                         ->where('tabSalary Detail.abbr', '=', 'B');
                  })
                  ->where(function($query) {
                      $query->where('uan_number', '=', '')
                            ->orWhere('uan_number',  NULL);
                  });
                  // ->where('uan_number', '=', '')
                  // ->orWhere('uan_number',  NULL);


                if(!empty($this->request->employee_name)){
                  $query5->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
              }

              if(!empty($this->request->company)){
                  $query5->where('company',$this->request->company);
              }


              if(!empty($this->request->month) && !empty($this->request->year)){
                  $query5->whereMonth('start_date', $this->request->month);
                  $query5->whereMonth('end_date', $this->request->month);
                  $query5->whereYear('start_date', $this->request->year);
                  $query5->whereYear('end_date', $this->request->year);
                  }

        // return view('exports.pf_statement', ['pf_statement_data' => $data, 'employees'=>$query3->first(), 'employees1'=>$query4->first(), 'gross_pay'=>$query5->get() ] );

        return view('exports.pf_statement', ['pf_statement_data' => $data, 'employees1'=>$query4->first(), 'gross_pay'=>$query5->get() ] );



    }
}
