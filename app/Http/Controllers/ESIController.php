<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
// use App\Models\erp\AttendanceRecords;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Exports\ESIStatementExport;
use App\Exports\ESIChallanExport;
use App\Exports\ESIChallanMultipleSheetExport;

class ESIController extends Controller
{


  public function esi_statement(Request $request){

    $title = 'ESI Statement';


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

      if(!empty($request->employee_name)){
            $query1->where('employee_name', 'like', '%' . $request->employee_name. '%');
        }

      if(!empty($request->company)){
          $query1->where('company',$request->company);
      }

      if(!empty($request->month) && !empty($request->year)){
        $query1->whereMonth('start_date', $request->month);
        $query1->whereMonth('end_date', $request->month);
        $query1->whereYear('start_date', $request->year);
        $query1->whereYear('end_date', $request->year);
      }


    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }

    $data = $request->all();

    $esi_statement_data = $query1->paginate($pagination);

    Helper::LoginIpandTime($request->getClientIp());
    return view('admin.esi.esi_statement',compact('title', 'esi_statement_data', 'data'));
}

public function esi_statement_export(Request $request){

  $file_name = 'ESI_Statement';

  if(!empty($request->company)){
    $file_name .= '-' . $request->company;
  }

  $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


    return Excel::download(new ESIStatementExport($request), $file_name);
}

public function esi_challan(Request $request){

  $title = 'ESI Challan';


    // $query2 = DB::connection('erpnext')
    //               ->table('tabEmployee')
    //               ->select(DB::raw("esic_no,
    //                             employee_name,
    //                             0 payment_days,
    //                             0 esi_earnings,
    //                             2 workings_day1,
    //                             esic_exit_date") )
    //             ->where('esic_no', '!=', NULL)
    //             ->whereMonth('esic_exit_date', $previous_month)
    //             ->whereYear('esic_exit_date', $previous_year);


    $query1 = DB::connection('erpnext')
                ->table('tabEmployee')
                ->select(DB::raw("esic_no,
                              employee_name,
                              0 payment_days,
                              0 esi_earnings,
                              2 workings_day1,
                              esic_exit_date as last_working_day") )
              ->where('esic_no', '!=', NULL);

          if(!empty($request->employee_name)){
                $query1->where('employee_name', 'like', '%' . $request->employee_name. '%');
            }

          if(!empty($request->company)){
              $query1->where('company', $request->company);
          }

          if(!empty($request->month) && !empty($request->year)){
            $current_month = $request->month;
            $current_year = $request->year;
            $previous_month =  $current_month - 1;
            $previous_year = $current_year;
            if($previous_month <= 0) { $previous_month = 12;  $previous_year =  $current_year - 1; }

            // $query1->whereMonth('relieving_date', $previous_month);
            // $query1->whereYear('relieving_date', $previous_year);
            // $query1->whereMonth('esic_exit_date', $previous_month);
            // $query1->whereYear('esic_exit_date', $previous_year);



            // $query1->whereRaw(" ( ( MONTH(relieving_date) = '$previous_month' AND YEAR(relieving_date) = '$previous_year' ) OR
            //                     ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");
            $query1->whereRaw(" (
                                ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");

          } else {
            $current_month = date("m", time());
            $current_year = date("Y", time());
            $previous_month =  $current_month - 1;
            $previous_year = $current_year;
            if($previous_month <= 0) { $previous_month = 12;  $previous_year =  $current_year - 1; }
            // $query1->whereMonth('relieving_date', $previous_month);
            // $query1->whereYear('relieving_date', $previous_year);
            // $query1->whereMonth('esic_exit_date', $previous_month);
            // $query1->whereYear('esic_exit_date', $previous_year);


            // $query1->whereRaw(" ( ( MONTH(relieving_date) = '$previous_month' AND YEAR(relieving_date) = '$previous_year' ) OR
            //                     ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");
            $query1->whereRaw(" ( 
                                ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");



          }


  $query2 = DB::connection('erpnext')
              ->table('tabSalary Slip')
              ->select(DB::raw("esic_no,
                            employee_name,
                            round(payment_days) payment_days,
                            round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
                            `tabSalary Detail`.parent and td.abbr='WA' ),0)) esi_earnings,
                            (if (payment_days>0,0,1)) workings_day1,
                            esic_exit_date as last_working_day") )
              ->leftJoin('tabSalary Detail', function ($join) {
                  $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                  ->where('tabSalary Detail.abbr', '=', 'B');
                })
              ->whereNull('esic_exit_date')
              ->where('esic_no', '!=', NULL)
              ->whereRaw("( SELECT amount FROM  `tabSalary Detail` tsd WHERE tsd.parent = `tabSalary Slip`.name and  tsd.abbr = 'ESI' ) > 0")
              // ->whereRaw("round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
              // `tabSalary Detail`.parent and td.abbr='WA' ),0)) <= 21000")
              ->where('payment_days', "!=", NULL)
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

  $esi_challan_data = $query2->paginate($pagination);

  Helper::LoginIpandTime($request->getClientIp());
  return view('admin.esi.esi_challan',compact('title', 'esi_challan_data', 'data'));
}

public function esi_challan_export(Request $request){


  $file_name = 'ESI_Challan';

  if(!empty($request->company)){
    $file_name .= '-' . $request->company;
  }

  $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


  return Excel::download(new ESIChallanMultipleSheetExport($request),  $file_name);
}


}
