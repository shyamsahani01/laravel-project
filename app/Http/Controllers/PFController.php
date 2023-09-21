<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\erp\AttendanceRecords;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Exports\PFChallanExport;
use App\Exports\PFStatementExport;

class PFController extends Controller
{

     public function pf_challan(Request $request){

        $title = 'Provident Fund Challan';

        // $query1 = DB::connection('erpnext')
        //             ->table('tabSalary Slip')
        //             ->select(DB::raw("uan_number,
        //                       employee_name,
        //                       round(gross_pay) gross_pay,
        //                       round(amount) amount1,
        //                       round(amount) amount2,
        //                       round(amount) amount3,
        //                       round(((amount*12)/100)) pf,
        //                       round(((amount*8.33)/100)) eps,
        //                       ( round(((amount*12)/100)) - round(((amount*8.33)/100) )  ) epsepf,
        //                       round(leave_without_pay) leave_without_pay,
        //                       eps_scheme_not_applicable") )
        //             ->leftJoin('tabSalary Detail', function ($join) {
        //                 $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
        //                     ->where('tabSalary Detail.abbr', '=', 'B');
        //               })
        //             ->where('eps_scheme_not_applicable', '=', 0)
        //             ->where('uan_number', '!=', '')
        //             ->OrderBy('uan_number','ASC');
        // IF(amount<15000, round(((amount*12)/100)),  round(((15000*12)/100)) )


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

          if(!empty($request->employee_name)){
                $query1->where('employee_name', 'like', '%' . $request->employee_name. '%');
            }

          if(!empty($request->company)){
              $query1->where('company', $request->company);
          }

          if(!empty($request->month) && !empty($request->year)){
            $query1->whereMonth('start_date', $request->month);
            $query1->whereMonth('end_date', $request->month);
            $query1->whereYear('start_date', $request->year);
            $query1->whereYear('end_date', $request->year);
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

          if(!empty($request->employee_name)){
              $query2->where('employee_name', 'like', '%' . $request->employee_name. '%');
          }

          if(!empty($request->company)){
              $query2->where('company', $request->company);
          }


          if(!empty($request->month) && !empty($request->year)){
            $query2->whereMonth('start_date', $request->month);
            $query2->whereMonth('end_date', $request->month);
            $query2->whereYear('start_date', $request->year);
            $query2->whereYear('end_date', $request->year);
          }


        if(!empty($request->show)){
          $pagination = $request->show;
        }else{
          $pagination = 10;
        }

        $data = $request->all();

        $pf_challan_data = $query2->paginate($pagination);

        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.pf.pf_challan',compact('title', 'pf_challan_data', 'data'));
    }


    public function pf_challan_export(Request $request){

      $file_name = 'PF_Challan';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new PFChallanExport($request), $file_name);

    }

    public function pf_challan_export_text(Request $request){
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

        if(!empty($request->employee_name)){
          $query1->where('employee_name', 'like', '%' . $request->employee_name. '%');
        }

        if(!empty($request->company)){
            $query1->where('company', $request->company);
        }

        if(!empty($request->month) && !empty($request->year)){
          $query1->whereMonth('start_date', $request->month);
          $query1->whereMonth('end_date', $request->month);
          $query1->whereYear('start_date', $request->year);
          $query1->whereYear('end_date', $request->year);
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

          if(!empty($request->employee_name)){
              $query2->where('employee_name', 'like', '%' . $request->employee_name. '%');
          }

          if(!empty($request->company)){
              $query2->where('company', $request->company);
          }

          if(!empty($request->month) && !empty($request->year)){
            $query2->whereMonth('start_date', $request->month);
            $query2->whereMonth('end_date', $request->month);
            $query2->whereYear('start_date', $request->year);
            $query2->whereYear('end_date', $request->year);
          }

        $pf_challan_data = $query2->get();

        $string_data = "";

        if(!empty($pf_challan_data)) {
          foreach($pf_challan_data as $data) {
            $string_data .= $data->uan_number . "#~#";
            $string_data .= $data->employee_name . "#~#";
            $string_data .= $data->gross_pay . "#~#";
            $string_data .= $data->amount1 . "#~#";
            $string_data .= $data->amount2 . "#~#";
            $string_data .= $data->amount3 . "#~#";
            $string_data .= $data->pf . "#~#";
            $string_data .= $data->eps . "#~#";
            $string_data .= $data->epsepf . "#~#";
            $string_data .= $data->leave_without_pay . "#~#";
            $string_data .= '0' . "\n";
          }
        }


        $file_name = 'PF_Challan_Text';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $file_name .=  "-". date('d-m-Y').'-'.time().'.txt';


        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=$file_name");

        echo $string_data;


    }


  public function pf_statement(Request $request){

      $title = 'Provident Fund Statement';

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

            if(!empty($request->employee_name)){
                $query1->where('employee_name', 'like', '%' . $request->employee_name. '%');
            }

          if(!empty($request->company)){
              $query1->where('company', $request->company);
          }

          if(!empty($request->month) && !empty($request->year)){
            $query1->whereMonth('start_date', $request->month);
            $query1->whereMonth('end_date', $request->month);
            $query1->whereYear('start_date', $request->year);
            $query1->whereYear('end_date', $request->year);
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

          if(!empty($request->employee_name)){
              $query2->where('employee_name', 'like', '%' . $request->employee_name. '%');
          }

          if(!empty($request->company)){
              $query2->where('company', $request->company);
          }

          if(!empty($request->month) && !empty($request->year)){
            $query2->whereMonth('start_date', $request->month);
            $query2->whereMonth('end_date', $request->month);
            $query2->whereYear('start_date', $request->year);
            $query2->whereYear('end_date', $request->year);
          }



      if(!empty($request->show)){
        $pagination = $request->show;
      }else{
        $pagination = 10;
      }

      $data = $request->all();

      $pf_statement_data = $query2->paginate($pagination);

      Helper::LoginIpandTime($request->getClientIp());
      return view('admin.pf.pf_statement',compact('title', 'pf_statement_data', 'data'));
  }

  public function pf_statement_export(Request $request){

    $file_name = 'PF_Statement';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


    return Excel::download(new PFStatementExport($request), $file_name);
  }



}
