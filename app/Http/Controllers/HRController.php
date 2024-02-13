<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

// use App\Models\erp\AttendanceRecords;
// use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Exports\SalaryRegExport;
use App\Exports\EmployeeAttendanceExport;
use App\Exports\EmployeeDetailsExport;
use App\Exports\EmployeeDetailMultipleSheetExport;
use App\Exports\SalaryComponentExport;
use App\Exports\EmpAttendanceReportExport;
use App\Exports\OTLesshoursReportExport;
use App\Exports\LesshoursReportExport;
use App\Exports\BonusReportExport;
use App\Exports\BankSheetOtherBankExport;
use App\Exports\BankSheetHDFCBankExport;
use App\Exports\SalarySheetExport;
use App\Exports\SalarySheetAccountsExport;
use App\Exports\ComplianceSheetExport;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class HRController extends Controller
{

  public function __construct()
  {
    $this->year = date("Y");
    $this->month_array = [];
    $this->value = [];
  }

  public function salary_register(Request $request){


      $title = 'Salary Register';

      $data = $this->salary_register_data($request->all());

      $data['title'] = $title;

      return view('admin.hr.salary_reports.salary_register', $data);
  }

  public function salary_register_data($request_data = [])
  {
    // $company = 'Pinkcity Jewelhouse Private Ltd-Mahapura';
    $company = '';

    if(isset($request_data['company'])){
        $company =  $request_data['company'];
    }
    $company = str_replace(" ", "+", $company);

    $last_month = date('m', strtotime(date('Y-m')." -1 month"));
    $last_year = date('Y', strtotime(date('Y-m')." -1 month"));

    $current_month = date("m", time() );
    $current_year = date("Y", time() );

    if(isset($request_data['month']) && isset($request_data['year'])){
      $last_month = $request_data['month'];
      $last_year = $request_data['year'];

      $current_month = $last_month;
      $current_year = $last_year;

      $last_month_int =  (int) $last_month;
      if( $last_month_int <= 8 )  {
        $current_month = "0" . ($last_month_int + 1);
      }
      elseif($last_month_int >= 9 && $last_month_int < 12) {
        $current_month = $last_month_int + 1 ;
      }
      elseif($last_month_int == 12) {
        $current_month = "01" ;
        $current_year =  ( (int)$last_year ) +1 ;
      }
    }

    $from_date = "$last_year-$last_month-01";
    $to_date = "$current_year-$current_month-01";

    $last_month_int =  (int) $last_month;

    $json_filter = ["from_date"=>$from_date,
                    "to_date"=>$to_date,
                     "currency"=>"INR",
                     "company"=>$company,
                     "docstatus"=>"Submitted",
                   ];



    // $json_filter = ["from_date"=>"2022-05-01",
    //                 "to_date"=>"2022-06-01",
    //                  "currency"=>"INR",
    //                  "company"=>$company,
    //                  "docstatus"=>"Submitted",
    //                ];

    $url = 'https://erp.pinkcityindia.com/api/method/frappe.desk.query_report.run';
    $url .= '?report_name=Salary+Register';
    $url .= '&filters=' . json_encode($json_filter);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'X-Custom-Header: value',
        'Authorization: token e439301f9d117aa:55ddfcac33666ea',
        'Cookie: full_name=Guest; sid=Guest; system_user=no; user_id=Guest; user_image='
      ),
    ));

    $response = curl_exec($curl);

    $salary_register_data = json_decode($response);


    $json_filter2 = ["month"=>"$last_month_int",
                    "year"=>$last_year,
                    "company"=>$company,
                    "summarized_view"=>1,
                   ];


    $url2 = 'https://erp.pinkcityindia.com/api/method/frappe.desk.query_report.run';
    $url2 .= '?report_name=Monthly+Attendance+Sheet';
    $url2 .= '&filters=' . json_encode($json_filter2);

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url2,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'X-Custom-Header: value',
        'Authorization: token e439301f9d117aa:55ddfcac33666ea',
        'Cookie: full_name=Guest; sid=Guest; system_user=no; user_id=Guest; user_image='
      ),
    ));

    $response = curl_exec($curl);

    $attendance_summery_data = json_decode($response);

    if(isset($request_data['employee_name'])){
      $temp_data = [];
      if (isset($attendance_summery_data->message->result)) {
        if(is_array($attendance_summery_data->message->result) ) {
          if(count($attendance_summery_data->message->result) > 0) {

            $result = $attendance_summery_data->message->result;
            for($i=0; $i<count($result)-1 ; $i++) {
              $data2 = $result[$i];
              // print_r($data2->employee_name);
              // print_r("<br>hi11<br>");
              if(stripos($data2->employee_name, $request_data['employee_name']) !== false) {
                $temp_data[] = $data2;
                // print_r($data2->employee_name);
                // print_r("<br>hi11<br>");
                // print_r($request_data['employee_name']);
                // print_r("<br>hi22<br>");
              }
            }

            $attendance_summery_data->message->result = $temp_data;
          }

        }
      }
    }

    // echo "<pre>";
    // print_r($attendance_summery_data);
    // die;
    // echo "<br>";
    // print_r($json_filter);
    // echo "<br>";
    // print_r($json_filter2);
    // echo "<br>";
    // print_r($salary_register_data);
    // die;

    $data['salary_register_data'] = $salary_register_data;
    $data['attendance_summery_data'] = $attendance_summery_data;

    return $data;
  }

    public function salary_reg_export(Request $request) {

      $file_name = 'Salary Register';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $data = $this->salary_register_data($request->all());

      // echo "<pre>";
      // print_r($data);
      // echo "<br>";
      // print_r( $request->all() );
      // die;




      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new SalaryRegExport($request, $data), $file_name);

    }

    public function employee_report(Request $request){

      $erpnextDB = DB::connection("erpnext");

        $query = $erpnextDB
                    ->table("tabEmployee")
                    // ->where('status', '=', 'Active')
                    ->orderBy('employee_name','ASC');
        $emp_report_data = $query->get();

        if(!empty($request->employee_name)){
            $query->where('employee_name', 'like', '%' . $request->employee_name. '%');
        }

      if(!empty($request->company)){
          $query->where('company', $request->company);
      }

      if(!empty($request->status)){
          $query->where('status', $request->status);
      }

        if(!empty($request->show)){
            $pagination = $request->show;
        }else{
            $pagination = 10;
        }
        $data = $request->all();
        $emp_report_data = $query->paginate($pagination);

        return view("admin.hr.employee_report.emp_report", [
            "emp_report_data" => $emp_report_data,
            "title" => "Employee's Details",
        ]);
    }

    public function empReportDetails(Request $request){

      $erpnextDB = DB::connection("erpnext");

        $query = $erpnextDB
                    ->table("tabEmployee")
                    ->where("employee", $request->employee);
        $emp_details_data = $query->first();

        $query1 = $erpnextDB
                    ->table("tabSalary Slip")
                    ->select(DB::raw(
                          "`tabSalary Slip`.name,
                          `tabSalary Slip`.employee,
                          `tabSalary Slip`.employee_name,
                          `tabSalary Slip`.payment_days,
                          `tabSalary Slip`.net_pay,
                          `tabSalary Slip`.start_date,
                          `tabSalary Slip`.gross_pay,
                          `tabSalary Slip`.net_pay,
                          `tabSalary Slip`.gross_monthly_salary,
                          `tabSalary Slip`.base_net_pay,
                          `tabSalary Slip`.total_working_days,
                          `tabSalary Detail`.abbr,
                          ( SELECT
                               SUM( IF(tabAttendance.status = 'Present', 1,
                                          IF(tabAttendance.status = 'Half Day', 0.5, 0 )
                                      )
                                )
                               FROM tabAttendance
                        		   WHERE tabAttendance.employee = '$request->employee'
                        		   AND ( tabAttendance.attendance_date BETWEEN
                                        `tabSalary Slip`.start_date
                                        AND  `tabSalary Slip`.end_date  )
                          ) as total_present
                          "
                      ))
                    ->join("tabSalary Detail", "tabSalary Detail.parent", "tabSalary Slip.name")
                    ->groupBy("tabSalary Slip.name")
                    ->where("employee", $request->employee);
        $emp_salary_data = $query1->get();

        return view("admin.hr.employee_report.emp_details", [
            "emp_details_data" => $emp_details_data,
            "emp_salary_data" => $emp_salary_data,
            "title" => "Employee Detail",
        ]);
    }

    public function salary_com(Request $request){

      $data = $this->salary_com_data($request->all(), 'view');

      $data['title'] = "Salary Component Classification";

      return view("admin.payroll.salary_com", $data);

    }

    public function salary_com_data($request_data = [], $page_type = 'view')
    {
      $erpnextDB = DB::connection("erpnext");


      $query = $erpnextDB
                  ->table("tabEmployee")
                  ->select(DB::raw(
                        "`tabSalary Slip`.name,
                        `tabSalary Slip`.employee,
                        `tabSalary Slip`.employee_name,
                        `tabSalary Slip`.attendance_device_id,
                        `tabSalary Slip`.gross_monthly_salary,
                        `tabSalary Slip`.base_total_deduction,
                        `tabSalary Slip`.base_net_pay,
                        `tabSalary Slip`.net_pay"
                    ))
                  ->join("tabSalary Slip", "tabEmployee.name", "tabSalary Slip.employee")
                  ->whereRaw("`tabSalary Slip`.start_date = ( SELECT start_date FROM `tabSalary Slip` tss
                                            where employee  = tabEmployee.name
                                            order by tss.start_date  desc limit 1 )")
                  // ->groupBy("tabEmployee.name")
                  // ->OrderBy(DB::raw(
                  //       "`tabSalary Slip`.start_date ASC, tabEmployee.employee_name"
                  //   ));
                  ->OrderBy('tabEmployee.employee_name','ASC');



                if(!empty($request_data['employee_name'])){
                    $query->where('tabEmployee.employee_name', 'like', '%' . $request_data['employee_name']. '%');
                }

              if(!empty($request_data['company'])){
                  $query->where('tabEmployee.company', $request_data['company']);
              }

              if(!empty($request_data['status'])){
                  $query->where('tabEmployee.status', $request_data['status']);
              }

                if($page_type == 'view') {
                  if(!empty($request_data['show'])) {
                      $pagination = $request_data['show'];
                  } else {
                      $pagination = 10;
                  }
                  // $data = $request->all();
                  $salary_com_data =  $query->paginate($pagination);
                } else {
                  $salary_com_data =  $query->get();
                }


        $data['salary_com_data'] = $salary_com_data;

        return $data;

    }


    public function bonus_report(Request $request){

      $data = $this->bonus_report_data($request->all(), 'view');

      $data['title'] = "Employee's Bonus";

      return view("admin.hr.bonus.bonus_report", $data);

    }

    public function bonus_report_data($request_data = [], $page_type = 'view')
    {
      $erpnextDB = DB::connection("erpnext");

      // $year = 2022;

      if(!empty($request_data['year'])){
          $this->year = $request_data['year'];
          // $year = $request_data['year'];
      }

      $this->month_array = [
        ["month"=>"april",
         "month_digit"=>4,
         "year_digit"=>$this->year,
         "select_basic"=>"april_salary_details.amount as april_basic",
         "select_basic_default"=>"april_salary_details.default_amount as april_basic_default",
         "select_day"=>"april_salary.payment_days as april_pay_days",
         "salary_table"=>"april_salary",
         "salary_detail_table"=>"april_salary_details",
       ],
        ["month"=>"may",
         "month_digit"=>5,
         "year_digit"=>$this->year,
         "select_basic"=>"may_salary_details.amount as may_basic",
         "select_basic_default"=>"may_salary_details.default_amount as may_basic_default",
         "select_day"=>"may_salary.payment_days as may_pay_days",
         "salary_table"=>"may_salary",
         "salary_detail_table"=>"may_salary_details",
       ],
        ["month"=>"june",
         "month_digit"=>6,
         "year_digit"=>$this->year,
         "select_basic"=>"june_salary_details.amount as june_basic",
         "select_basic_default"=>"june_salary_details.default_amount as june_basic_default",
         "select_day"=>"june_salary.payment_days as june_pay_days",
         "salary_table"=>"june_salary",
         "salary_detail_table"=>"june_salary_details",
       ],
        ["month"=>"july",
         "month_digit"=>7,
         "year_digit"=>$this->year,
         "select_basic"=>"july_salary_details.amount as july_basic",
         "select_basic_default"=>"july_salary_details.default_amount as july_basic_default",
         "select_day"=>"july_salary.payment_days as july_pay_days",
         "salary_table"=>"july_salary",
         "salary_detail_table"=>"july_salary_details",
       ],
        ["month"=>"aug",
         "month_digit"=>8,
         "year_digit"=>$this->year,
         "select_basic"=>"aug_salary_details.amount as aug_basic",
         "select_basic_default"=>"aug_salary_details.default_amount as aug_basic_default",
         "select_day"=>"aug_salary.payment_days as aug_pay_days",
         "salary_table"=>"aug_salary",
         "salary_detail_table"=>"aug_salary_details",
       ],
        ["month"=>"sept",
         "month_digit"=>9,
         "year_digit"=>$this->year,
         "select_basic"=>"sept_salary_details.amount as sept_basic",
         "select_basic_default"=>"sept_salary_details.default_amount as sept_basic_default",
         "select_day"=>"sept_salary.payment_days as sept_pay_days",
         "salary_table"=>"sept_salary",
         "salary_detail_table"=>"sept_salary_details",
       ],
        ["month"=>"oct",
         "month_digit"=>10,
         "year_digit"=>$this->year,
         "select_basic"=>"oct_salary_details.amount as oct_basic",
         "select_basic_default"=>"oct_salary_details.default_amount as oct_basic_default",
         "select_day"=>"oct_salary.payment_days as oct_pay_days",
         "salary_table"=>"oct_salary",
         "salary_detail_table"=>"oct_salary_details",
       ],
        ["month"=>"nov",
         "month_digit"=>11,
         "year_digit"=>$this->year,
         "select_basic"=>"nov_salary_details.amount as nov_basic",
         "select_basic_default"=>"nov_salary_details.default_amount as nov_basic_default",
         "select_day"=>"nov_salary.payment_days as nov_pay_days",
         "salary_table"=>"nov_salary",
         "salary_detail_table"=>"nov_salary_details",
       ],
        ["month"=>"dec",
         "month_digit"=>12,
         "year_digit"=>$this->year,
         "select_basic"=>"dec_salary_details.amount as dec_basic",
         "select_basic_default"=>"dec_salary_details.default_amount as dec_basic_default",
         "select_day"=>"dec_salary.payment_days as dec_pay_days",
         "salary_table"=>"dec_salary",
         "salary_detail_table"=>"dec_salary_details",
       ],
        ["month"=>"jan",
         "month_digit"=>1,
         "year_digit"=>$this->year + 1,
         "select_basic"=>"jan_salary_details.amount as jan_basic",
         "select_basic_default"=>"jan_salary_details.default_amount as jan_basic_default",
         "select_day"=>"jan_salary.payment_days as jan_pay_days",
         "salary_table"=>"jan_salary",
         "salary_detail_table"=>"jan_salary_details",
       ],
        ["month"=>"feb",
         "month_digit"=>2,
         "year_digit"=>$this->year + 1,
         "select_basic"=>"feb_salary_details.amount as feb_basic",
         "select_basic_default"=>"feb_salary_details.default_amount as feb_basic_default",
         "select_day"=>"feb_salary.payment_days as feb_pay_days",
         "salary_table"=>"feb_salary",
         "salary_detail_table"=>"feb_salary_details",
       ],
        ["month"=>"mar",
         "month_digit"=>3,
         "year_digit"=>$this->year + 1,
         "select_basic"=>"mar_salary_details.amount as mar_basic",
         "select_basic_default"=>"mar_salary_details.default_amount as mar_basic_default",
         "select_day"=>"mar_salary.payment_days as mar_pay_days",
         "salary_table"=>"mar_salary",
         "salary_detail_table"=>"mar_salary_details",
       ],
     ];

      $select_string = "tabEmployee.name,
                    tabEmployee.employee_name,
                    tabEmployee.status,";

        foreach ($this->month_array as $key => $value) {
          $select_string .= $value['select_basic'] .", ";
          $select_string .= $value['select_day'] .", ";
          $select_string .= $value['select_basic_default'] .", ";
        }

        $select_string .= "tabEmployee.department";


      $query = $erpnextDB
                  ->table("tabEmployee")
                  ->select(DB::raw($select_string))
                  ->OrderBy('tabEmployee.employee_name','ASC')
                  ->groupBy('tabEmployee.employee');

                    foreach ($this->month_array as $key => $value) {
                      $this->value = $value;
                      $query->leftJoin('tabSalary Slip as '.$this->value['salary_table'] , function ($join) {
                         $join->on('tabEmployee.name', '=', $this->value['salary_table'].'.employee')
                              ->whereMonth($this->value['salary_table'].'.start_date', '=', $this->value['month_digit'])
                              ->whereYear($this->value['salary_table'].'.start_date', '=', $this->value['year_digit']);
                     });
                      $query->leftJoin('tabSalary Detail as '.$this->value['salary_detail_table'], function ($join) {
                         $join->on($this->value['salary_table'].'.name', '=', $this->value['salary_detail_table'].'.parent')
                              ->where($this->value['salary_detail_table'].'.abbr', '=', 'B');
                     });
                     $this->value = [];
                    }


                if(!empty($request_data['employee_name'])){
                    $query->where('tabEmployee.employee_name', 'like', '%' . $request_data['employee_name']. '%');
                }

              if(!empty($request_data['company'])){
                  $query->where('tabEmployee.company', $request_data['company']);
              }

              if(!empty($request_data['status'])){
                  $query->where('tabEmployee.status', $request_data['status']);
              }

                if($page_type == 'view') {
                  if(!empty($request_data['show'])) {
                      $pagination = $request_data['show'];
                  } else {
                      $pagination = 10;
                  }
                  // $data = $request->all();
                  $bonus_data =  $query->paginate($pagination);
                } else {
                  $bonus_data =  $query->get();
                }


        $data['bonus_data'] = $bonus_data;
        $data['year'] = $this->year;

        return $data;

    }


    public function bonus_report_export(Request $request){

      $file_name = 'bonus_report';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $data = $this->bonus_report_data($request->all(), 'excel');

      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new BonusReportExport($request, $data), $file_name);

    }

    public function empAttendanceReport(Request $request){

          $title = 'Employee Attendance Report';

          $month = 0;
          $year = 0;
          if(!empty($request->month) && !empty($request->year)){
            $month = $request->month;
            $year = $request->year;
            $total_date = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
          }
          else {
            $month = date("m", time());
            $year = date("Y", time());
            $total_date = cal_days_in_month(CAL_GREGORIAN, date("m", time()) ,date("Y", time()));
          }

          $query = DB::connection('erpnext')
                      ->table('tabEmployee')
                      ->select(DB::raw("tabEmployee.name,
                                        tabEmployee.employee,
                                        tabEmployee.employee_name,
                                        tabEmployee.company,
                                        tabEmployee.date_of_joining") )
                      ->leftJoin('tabAttendance', 'tabEmployee.name', 'tabAttendance.employee')
                      // ->where('tabEmployee.status', 'Active')
                      ->orderBy('tabEmployee.employee_name', "ASC")
                      ->groupBy('tabEmployee.name');

            if(!empty($request->employee_name)){
                  $query->where('tabEmployee.employee_name', 'like', '%' . $request->employee_name. '%');
              }

            if(!empty($request->company)){
                $query->where('tabEmployee.company',$request->company);
            }

            if(!empty($request->month) && !empty($request->year)){
              $query->whereMonth('tabAttendance.attendance_date', $request->month);
              $query->whereYear('tabAttendance.attendance_date', $request->year);
            }
            else {
              $query->whereMonth('tabAttendance.attendance_date', date("m", time()));
              $query->whereYear('tabAttendance.attendance_date', date("Y", time()));
            }


          if(!empty($request->show)){
            $pagination = $request->show;
          }else{
            $pagination = 10;
          }


          $empAttendance_data = $query->paginate($pagination);
          // $empAttendance_data = $query->toSql();
          // $empAttendance_data = $query->get();

          $data['title'] = $title;
          $data['empAttendance_data'] = $empAttendance_data;
          $data['total_date'] = $total_date;
          $data['month'] = $month;
          $data['year'] = $year;

          // echo "<pre>";
          // print_r($data);
          // die;

          return view('admin.hr.employee_attendance.emp_attendance_report', $data);
      }




      public function employee_details_export(Request $request){

        $file_name = 'Employee_Details';

        if(!empty($request->company)){
          $file_name .= '-' . $request->company;
        }

        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


        return Excel::download(new EmployeeDetailMultipleSheetExport($request),  $file_name);

      }

      public function salary_component_export(Request $request){

        $file_name = 'Salary_Component';

        if(!empty($request->company)){
          $file_name .= '-' . $request->company;
        }

        $data = $this->salary_com_data($request->all(), 'excel');

        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
        return Excel::download(new SalaryComponentExport($request, $data), $file_name);

      }

      public function employee_attendance_export(Request $request){

        $file_name = 'Employee_Attendance';

        if(!empty($request->company)){
          $file_name .= '-' . $request->company;
        }

        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
        return Excel::download(new EmployeeAttendanceExport($request), $file_name);

      }

      public function ot_lesshours_report(Request $request){

        $erpnextDB = DB::connection("erpnext");

        $query = $erpnextDB
                      ->table("report_emp_attendace_detail")
                      ->select(DB::raw("report_emp_attendace_detail.*,
                                          tabEmployee.employee,
                                          tabEmployee.employee_name,
                                          tabEmployee.attendance_device_id,
                                          tabEmployee.company") )
                      ->leftJoin('tabEmployee', 'tabEmployee.employee', 'report_emp_attendace_detail.emp');


          if(!empty($request->employee_name)){
                $query->where('tabEmployee.employee_name', 'like', '%' . $request->employee_name. '%');
                // $query->where('tabEmployee.employee', $request->employee);
            }

          if(!empty($request->company)){
              $query->where('tabEmployee.company',$request->company);
          }

          if(!empty($request->start_date)){
              $query->whereDate('report_emp_attendace_detail.date', ">=", $request->start_date);
              $query->orderBy('report_emp_attendace_detail.date', "ASC");
          }
          else {
            $query->orderBy('report_emp_attendace_detail.date', "DESC");
            $auto_start_date = date('Y-m-d', strtotime ( '-2 day' , time() ) );
            $query->whereDate('report_emp_attendace_detail.date', $auto_start_date);
            $request->start_date = $auto_start_date;
          }

          if(!empty($request->end_date)){
              $query->whereDate('report_emp_attendace_detail.date', "<=", $request->end_date);
          }

          if(!empty($request->show)){
            $pagination = $request->show;
          }else{
            $pagination = 10;
          }

          $ot_lesshours_data = $query->paginate($pagination);

          return view("admin.hr.emp_ot_lesshours.ot_lesshours", [
              "ot_lesshours_data" => $ot_lesshours_data,
              "title" => "OT & Less Hours Report",
          ]);

      }


      public function ot_lesshours_getHTMLData(Request $request){

        $erpnextDB = DB::connection("erpnext");

        $query = $erpnextDB
                      ->table("report_emp_attendace_detail")
                      ->where('id', $request->id);


        $ot_lesshours_data = $query->first();
        $html_data = "";

        if(isset($ot_lesshours_data->all_in_out_json)) {
          $i=1;
          $all_in_out = json_decode($ot_lesshours_data->all_in_out_json);
          foreach ($all_in_out as $key => $value) {
              $html_data .= "<tr>
                              <td class='text-center'>".$i++."</td>
                              <td class='text-center'>$value->in_time</td>
                              <td class='text-center'>$value->out_time</td>
                            </tr>";
          }
        }


        return json_encode(["msg"=>"OT check in data", "status"=>true, "html_data"=>$html_data ]);

      }

      public function ot_lesshours_update(Request $request){

        $erpnextDB = DB::connection("erpnext");

        $query = $erpnextDB
                      ->statement("UPDATE report_emp_attendace_detail
                                SET
                                  final_ot_hour_salary =
                                  ( $request->final_ot_hour * ROUND(per_hour_salary) ),
                                  final_ot_hour = $request->final_ot_hour
                                  WHERE id = $request->id");

        return json_encode(["msg"=>"OT data successfully updated", "status"=>true, ]);

      }


      public function ot_lesshours_report_export(Request $request){

        $file_name = 'OT Report Export';

        if(!empty($request->company)){
          $file_name .= '-' . $request->company;
        }

        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
        return Excel::download(new OTLesshoursReportExport($request), $file_name);

      }


      public function bank_sheet_hdfc_bank(Request $request){

        $title = 'Bank Sheet : HDFC Bank';


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

          if(!empty($request->employee_name)){
                $query1->where('tss.employee_name', 'like', '%' . $request->employee_name. '%');
            }

          if(!empty($request->company)){
              $query1->where('tss.company',$request->company);
          }

          $current_month = date("m", time());
          $current_year = date("Y", time());

          if(!empty($request->month) && !empty($request->year)){
            $current_month = $request->month;
            $current_year = $request->year;
          }

          $query1->whereMonth('tss.start_date', $current_month);
          $query1->whereMonth('tss.end_date', $current_month);
          $query1->whereYear('tss.start_date', $current_year);
          $query1->whereYear('tss.end_date', $current_year);



        if(!empty($request->show)){
          $pagination = $request->show;
        }else{
          $pagination = 10;
        }

        $data = $request->all();

        $bank_sheet_data = $query1->paginate($pagination);

        return view('admin.payroll.bank_sheet.hdfc_bank',compact('title', 'bank_sheet_data', 'data'));
    }

    public function bank_sheet_hdfc_bank_export(Request $request){

      $file_name = 'Bank Sheet - HDFC Bank ';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new BankSheetHDFCBankExport($request), $file_name);

    }



      public function bank_sheet_other_bank(Request $request){

        $title = 'Bank Sheet : Other Bank';


        $query1 = DB::connection('erpnext')
                    ->table('tabSalary Slip AS tss')
                    ->select(DB::raw("tss.employee,
                    tss.attendance_device_id,
                    tss.employee_name,
                    tss.net_pay,
                    tss.start_date,
                    tabEmployee.bank_ac_no,
                    tabEmployee.ifsc_code,
                    tabEmployee.bank_name_new") )
                    ->join('tabEmployee', "tabEmployee.employee", "=", "tss.employee")
                    // ->whereRaw(" tabEmployee.bank_ac_no = tss.bank_account_no ")
                    ->where('tabEmployee.bank_name_new', '!=', 'HDFC Bank')
                    ->where('tss.docstatus', '<=', 1);

          if(!empty($request->employee_name)){
                $query1->where('tss.employee_name', 'like', '%' . $request->employee_name. '%');
            }

          if(!empty($request->company)){
              $query1->where('tss.company',$request->company);
          }

          $current_month = date("m", time());
          $current_year = date("Y", time());

          if(!empty($request->month) && !empty($request->year)){
            $current_month = $request->month;
            $current_year = $request->year;
          }

          $query1->whereMonth('tss.start_date', $current_month);
          $query1->whereMonth('tss.end_date', $current_month);
          $query1->whereYear('tss.start_date', $current_year);
          $query1->whereYear('tss.end_date', $current_year);



        if(!empty($request->show)){
          $pagination = $request->show;
        }else{
          $pagination = 10;
        }

        $data = $request->all();

        $bank_sheet_data = $query1->paginate($pagination);

        return view('admin.payroll.bank_sheet.other_bank',compact('title', 'bank_sheet_data', 'data'));
    }


    public function bank_sheet_other_bank_export(Request $request){

      $file_name = 'Bank Sheet - Other Bank ';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new BankSheetOtherBankExport($request), $file_name);

    }

    public function salary_sheet(Request $request){

      $title = 'Salary Sheet';

      $current_month = date("m", time());
      $current_year = date("Y", time());

      if(!empty($request->month) && !empty($request->year)){
        $current_month = $request->month;
        $current_year = $request->year;
      }


      $query1 = DB::connection('erpnext')
                  ->table('tabSalary Component AS tsc')
                  ->select(DB::raw("SUM(tsd.amount) amount, tsc.name, tsc.type, tsc.salary_component_abbr") )
                  ->leftJoin('tabSalary Detail AS tsd', "tsd.abbr", "=", "tsc.salary_component_abbr")
                  ->leftJoin('tabSalary Slip AS tss', "tss.name", "=", "tsd.parent")
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  // ->where('te.occupation', '=', 'Worker')
                  ->where('tss.occupation', '=', 'Worker')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($request->company)){
            $query1->where('tss.company',$request->company);
        }

        $query1->whereMonth('tss.start_date', $current_month);
        $query1->whereMonth('tss.end_date', $current_month);
        $query1->whereYear('tss.start_date', $current_year);
        $query1->whereYear('tss.end_date', $current_year);


      $salary_sheet_data['worker'] = $query1->get();


      $query2 = DB::connection('erpnext')
                  ->table('tabSalary Component AS tsc')
                  ->select(DB::raw("SUM(tsd.amount) amount, tsc.name, tsc.type, tsc.salary_component_abbr") )
                  ->leftJoin('tabSalary Detail AS tsd', "tsd.abbr", "=", "tsc.salary_component_abbr")
                  ->leftJoin('tabSalary Slip AS tss', "tss.name", "=", "tsd.parent")
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  // ->where('te.occupation', '=', 'Staff')
                  ->where('tss.occupation', '=', 'Staff')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($request->company)){
            $query2->where('tss.company',$request->company);
        }


        $query2->whereMonth('tss.start_date', $current_month);
        $query2->whereMonth('tss.end_date', $current_month);
        $query2->whereYear('tss.start_date', $current_year);
        $query2->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['staff'] = $query2->get();

      $query3 = DB::connection('erpnext')
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::raw("tss.occupation, sum(tss.gross_monthly_salary) gross_monthly_salary, COUNT(tss.employee) employee_count") )
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tss.occupation');

        if(!empty($request->company)){
            $query3->where('tss.company',$request->company);
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

        if(!empty($request->company)){
            $query4->where('tss.company',$request->company);
        }

        $query4->whereMonth('tss.start_date', $current_month);
        $query4->whereMonth('tss.end_date', $current_month);
        $query4->whereYear('tss.start_date', $current_year);
        $query4->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['bank_data'] = $query4->get();


      // $query5 = DB::connection('erpnext')
      //             ->table('tabSalary Slip AS tss')
      //             ->select(DB::raw("esic_no,
      //             employee_name,
      //             round(payment_days) payment_days,
      //             round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
      //             `tabSalary Detail`.parent and td.abbr='WA' ),0)) esi_earnings,
      //             round(amount) esi_contribution") )
      //             ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
      //             ->leftJoin('tabSalary Detail AS tsd', function ($join) {
      //             $join->on('tss.name', '=', 'tsd.parent')
      //             ->where('tsd.abbr', '=', 'ESI');
      //             })
      //             ->whereRaw("( SELECT amount FROM  `tabSalary Detail` tsd2 WHERE tsd2.parent = `tabSalary Slip`.name and  tsd2.abbr = 'ESI' ) > 0")
      //             // ->whereRaw("round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
      //             // `tabSalary Detail`.parent and td.abbr='WA' ),0)) <= 21000")
      //             ->whereNull('esic_exit_date')
      //             ->where('esic_no', '!=', NULL);
      //
      //     if(!empty($request->company)){
      //         $query5->where('tss.company',$request->company);
      //     }
      //
      //     $query5->whereMonth('tss.start_date', $current_month);
      //     $query5->whereMonth('tss.end_date', $current_month);
      //     $query5->whereYear('tss.start_date', $current_year);
      //     $query5->whereYear('tss.end_date', $current_year);



      // $query5 = DB::connection('erpnext')
      //             ->table('tabSalary Component AS tsc')
      //             ->whereNotIn('salary_component_abbr', ['PF_1', 'ESI_1'])
      //             ->where('docstatus', '=', 0);
      //
      // $salary_sheet_data['salary_component'] = $query5->get();

      return view('admin.payroll.salary_sheet.salary_sheet',compact('title', 'salary_sheet_data',));
  }



    public function salary_sheet_export(Request $request){

      $file_name = 'Salary Sheet ';

      if(!empty($request->company)){
        $file_name .= '-' . $request->company;
      }

      $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      return Excel::download(new SalarySheetExport($request), $file_name);

    }


    public function salary_sheet_accounts(Request $request){

      $title = 'Salary Sheet - Accounts';

      $current_month = date("m", time());
      $current_year = date("Y", time());

      if(!empty($request->month) && !empty($request->year)){
        $current_month = $request->month;
        $current_year = $request->year;
      }


      $query1 = DB::connection('erpnext')
                  ->table('tabSalary Component AS tsc')
                  ->select(DB::raw("SUM(tsd.amount) amount, tsc.name, tsc.type, tsc.salary_component_abbr") )
                  ->leftJoin('tabSalary Detail AS tsd', "tsd.abbr", "=", "tsc.salary_component_abbr")
                  ->leftJoin('tabSalary Slip AS tss', "tss.name", "=", "tsd.parent")
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  // ->where('te.occupation_accounts', '=', 'Direct')
                  ->where('tss.occupation_accounts', '=', 'Direct')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($request->company)){
            $query1->where('tss.company',$request->company);
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
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  // ->where('te.occupation_accounts', '=', 'Indirect')
                  ->where('tss.occupation_accounts', '=', 'Indirect')
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tsc.name')
                  ->orderBy('tsc.type');

        if(!empty($request->company)){
            $query2->where('tss.company',$request->company);
        }


        $query2->whereMonth('tss.start_date', $current_month);
        $query2->whereMonth('tss.end_date', $current_month);
        $query2->whereYear('tss.start_date', $current_year);
        $query2->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['indirect'] = $query2->get();

      $query3 = DB::connection('erpnext')
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::raw("tss.occupation_accounts, sum(tss.gross_monthly_salary) gross_monthly_salary, COUNT(tss.employee) employee_count") )
                  // ->leftJoin('tabEmployee AS te', "te.employee", "=", "tss.employee")
                  ->where('tss.docstatus', '<=', 1)
                  ->groupBy('tss.occupation_accounts');

        if(!empty($request->company)){
            $query3->where('tss.company',$request->company);
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

        if(!empty($request->company)){
            $query4->where('tss.company',$request->company);
        }

        $query4->whereMonth('tss.start_date', $current_month);
        $query4->whereMonth('tss.end_date', $current_month);
        $query4->whereYear('tss.start_date', $current_year);
        $query4->whereYear('tss.end_date', $current_year);

      $salary_sheet_data['bank_data'] = $query4->get();

      // $query5 = DB::connection('erpnext')
      //             ->table('tabSalary Component AS tsc')
      //             ->whereNotIn('salary_component_abbr', ['PF_1', 'ESI_1'])
      //             ->where('docstatus', '=', 0);
      //
      // $salary_sheet_data['salary_component'] = $query5->get();

      return view('admin.payroll.salary_sheet_accounts.salary_sheet_accounts',compact('title', 'salary_sheet_data',));
  }


  public function salary_sheet_accounts_export(Request $request){

    $file_name = 'Salary Sheet - Accounts -  ';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
    return Excel::download(new SalarySheetAccountsExport($request), $file_name);

  }


  public function leave_details(Request $request){

    $title = 'Leave Details ';

    $erpnextDB = DB::connection("erpnext");

    $month = 0;
    $year = 0;
    if(!empty($request->month) && !empty($request->year)){
      $month = (int) $request->month;
      $year = (int) $request->year;
    }
    else {
      $month = date("m", time());
      $year = date("Y", time());
    }

    // print_r("month : $month");
    // print_r("year : $year");

      $query = $erpnextDB
                  ->table("tabEmployee AS te")
                  ->select(DB::raw(
                        "te.employee,
                         te.employee_name,
                         te.department,
                         te.date_of_joining,
                         te.status,
                         ( SELECT SUM(IF(ta2.status = 'Present', 1, 0))
                         FROM tabAttendance ta2 WHERE ta2.employee = te.employee
                              and month(ta2.attendance_date) = $month and year(ta2.attendance_date) = $year and ta2.docstatus = 1
                         ) AS current_present,
                         (SELECT SUM(IF(ta2.status = 'Half Day', 0.5, 0))
                         FROM tabAttendance ta2 WHERE ta2.employee = te.employee
                              and month(ta2.attendance_date) = $month and year(ta2.attendance_date) = $year and ta2.docstatus = 1
                        ) AS current_half_day,
                        ( SELECT SUM(IF(tlle2.leave_type = 'CL', tlle2.leaves, 0))
                        FROM `tabLeave Ledger Entry` tlle2 WHERE tlle2.employee = te.employee
                            and month(tlle2.from_date) = $month and year(tlle2.from_date) = $year and tlle2.docstatus = 1 and tlle2.transaction_type = 'Leave Application'
                        ) AS taken_cl,
                        ( SELECT SUM(IF(tlle2.leave_type = 'EL/PL', tlle2.leaves, 0))
                        FROM `tabLeave Ledger Entry` tlle2 WHERE tlle2.employee = te.employee
                            and month(tlle2.from_date) = $month and year(tlle2.from_date) = $year and tlle2.docstatus = 1 and tlle2.transaction_type = 'Leave Application'
                        ) AS taken_el_pl,
                        ( SELECT SUM(IF(tla2.leave_type = 'CL', tla2.total_leaves_allocated, 0))
                        FROM `tabLeave Allocation` tla2 WHERE tla2.employee = te.employee
                            and tla2.docstatus = $month and year(tla2.to_date) = $year
                        ) AS total_cl,
                        ( SELECT SUM(IF(tla2.leave_type = 'EL/PL', tla2.previous_year_leave, 0))
                        FROM `tabLeave Allocation` tla2 WHERE tla2.employee = te.employee
                            and tla2.docstatus = 1 and year(tla2.to_date) = $year
                        ) AS total_el_pl"
                    ))

                    // ( SELECT SUM(IF(tla2.leave_type = 'EL/PL', tla2.total_leaves_allocated, 0))
                    // FROM `tabLeave Allocation` tla2 WHERE tla2.employee = te.employee
                    //     and tla2.docstatus = 1 and year(tla2.to_date) = $year
                    // ) AS total_el_pl
                  // ->where("te.employee", $request->employee)
                  ->groupBy("te.employee");

      if(!empty($request->employee_name)){
            $query->where('te.employee_name', 'like', '%' . $request->employee_name. '%');
        }

      if(!empty($request->company)){
          $query->where('te.company',$request->company);
      }

      if(!empty($request->status)){
          $query->where('te.status', $request->status);
      }

      if(!empty($request->show)){
        $pagination = $request->show;
      }else{
        $pagination = 10;
      }


      $leave_details = $query->paginate($pagination);
      // $empAttendance_data = $query->toSql();
      // $empAttendance_data = $query->get();

      $data['title'] = $title;
      $data['leave_details'] = $leave_details;
      $data['month'] = $month;
      $data['year'] = $year;

      return view('admin.hr.leave_details.leave_details', $data);

  }

  public function compliance_sheet(Request $request){

    $title = 'Compliance Sheet';

    $months = ["01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April",
    "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August",
    "09"=>"September", "10"=>"Octomber", "11"=>"November", "12"=>"December"];

    $erpnextDB = DB::connection("erpnext");

    $month = 0;
    $month_name = 0;
    $company = "";
    $year = 0;
    if(!empty($request->month) && !empty($request->year)){
      // print_r("hi22");
      $month = $request->month;
      $year = $request->year;
      $month_name = $months[$month];
      $total_date = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
    }
    else {
      // print_r("hi33");
      $month = date("m", time());
      $month_name = date("F", time());
      $year = date("Y", time());
      $total_date = cal_days_in_month(CAL_GREGORIAN, date("m", time()) ,date("Y", time()));
    }

    $this->month = $month;
    $this->year = $year;

    // print_r($month);
    // die;


    $query = $erpnextDB
                ->table("tabEmployee AS te")
                // ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour, SUM(report_emp_attendace_detail.ot_hours_round) ot_hours_round") )
                // ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour ") )
                ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour ") )
                // ->select(DB::Raw("te.*, tei.payroll_date, tei.ot_hour ") )
                // ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, IF(tas.ot_hour > 0 , tas.ot_hour, IF(tei.ot_hour > 0, tei.ot_hour, 0 ) ) ot_hour ") )
                ->join('tabAttendance', "tabAttendance.employee", "te.employee")
                ->leftJoin('tabAdditional Salary as tas', function ($join) {
                      $join->on('tas.employee', '=', 'te.employee')
                      ->whereMonth('tas.payroll_date', $this->month)
                      ->whereYear('tas.payroll_date', $this->year)
                      ->where('tas.salary_component', 'OT');
                  })
                // ->leftJoin('tabEmployee Incentive as tei', function ($join) {
                //       $join->on('tei.employee', '=', 'te.employee')
                //       ->whereMonth('tei.payroll_date', $this->month)
                //       ->whereYear('tei.payroll_date', $this->year)
                //       ->where('tei.salary_component', 'OT');
                //   })
                // ->leftJoin('tabEmployee Incentive as tei', function ($join) {
                //       $join->on('tei.employee', '=', 'te.employee')
                //       ->whereMonth('tei.payroll_date', $this->month)
                //       ->whereYear('tei.payroll_date', $this->year)
                //       ->where('tei.salary_component', 'OT');
                //   })
                // ->leftJoin('report_emp_attendace_detail', function ($join) {
                //       $join->on('report_emp_attendace_detail.emp', '=', 'te.employee')
                //       ->whereMonth('report_emp_attendace_detail.date', $this->month)
                //       ->whereYear('report_emp_attendace_detail.date', $this->year);
                //   })
                ->whereMonth('tabAttendance.attendance_date', $month)
                ->whereYear('tabAttendance.attendance_date', $year)
                ->where('tabAttendance.docstatus', 1)
                ->groupBy('te.employee');


      if(!empty($request->employee_name)){
            $query->where('te.employee_name', 'like', '%' . $request->employee_name. '%');
        }

      if(!empty($request->company)){
          $query->where('te.company',$request->company);
          $company = $request->company;
      }

      // if(!empty($request->status)){
      //     $query->where('te.status', $request->status);
      // }
      // $query->where('te.status', "Active");

      if(!empty($request->show)){
        $pagination = $request->show;
      }else{
        $pagination = 10;
      }


      $compliance_data = $query->paginate($pagination);

      // echo "<pre>";
      // print_r($this->month);
      // print_r($this->year);
      // print_r($compliance_data);
      // die;

      foreach ($compliance_data as $key => $value) {
        // $compliance_data[$key]->attendance_data = $erpnextDB
        //             ->table("report_emp_attendace_detail")
        //             // ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type")
        //             ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour") )
        //             ->leftjoin('tabAttendance', function ($join) {
        //                 $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
        //                      // ->where('tabAttendance.attendance_date',  'report_emp_attendace_detail.date');
        //                      // ->whereDate('report_emp_attendace_detail.date',  'tabAttendance.attendance_date');
        //                      ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
        //             })
        //             // ->leftJoin("tabAttendance", "tabAttendance.employee", "=", "report_emp_attendace_detail.emp")
        //             // ->where('tabAttendance.attendance_date', "report_emp_attendace_detail.date")
        //             ->where('report_emp_attendace_detail.emp', $value->employee)
        //             ->where('tabAttendance.docstatus', 1)
        //             ->whereMonth('report_emp_attendace_detail.date', $month)
        //             ->whereYear('report_emp_attendace_detail.date', $year)
        //             ->groupBy('report_emp_attendace_detail.date')
        //             ->get();
        //             // ->toSql();
        $compliance_data[$key]->attendance_data = $erpnextDB
                    ->table("tabAttendance")
                    ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type", "tabAttendance.attendance_date",)
                    // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )

                    ->leftJoin('report_emp_attendace_detail', function ($join) {
                        $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
                             ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
                    })
                    ->where('tabAttendance.employee', $value->employee)
                    ->where('tabAttendance.docstatus', 1)
                    ->whereRaw("( ( MONTH(report_emp_attendace_detail.date) = $month and YEAR(report_emp_attendace_detail.date) = $year ) OR ( MONTH(tabAttendance.attendance_date) = $month and YEAR(tabAttendance.attendance_date) = $year ) ) ")
                    ->get();


          // $compliance_data[$key]->attendance_data = $erpnextDB
          //             ->table("tabAttendance")
          //             ->select("tabAttendance.status", "tabAttendance.leave_type", "tabAttendance.attendance_date",)
          //             // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )
          //
          //             // ->leftJoin('report_emp_attendace_detail', function ($join) {
          //             //     $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
          //             //          ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
          //             // })
          //             ->where('tabAttendance.employee', $value->employee)
          //             ->where('tabAttendance.docstatus', 1)
          //             ->whereMonth('tabAttendance.attendance_date', $month)
          //             ->whereYear('tabAttendance.attendance_date', $year)
          //             // ->whereRaw("( ( MONTH(report_emp_attendace_detail.date) = $month and YEAR(report_emp_attendace_detail.date) = $year ) OR ( MONTH(tabAttendance.attendance_date) = $month and YEAR(tabAttendance.attendance_date) = $year ) ) ")
          //             ->get();
      }

      $holiday_list = $erpnextDB
                  ->table("tabHoliday")
                  ->whereMonth('holiday_date', $month)
                  ->whereYear('holiday_date', $year)
                  ->get();

    $data['title'] = $title;
    $data['compliance_data'] = $compliance_data;
    $data['holiday_list'] = $holiday_list;
    $data['total_date'] = $total_date;
    $data['month'] = $month;
    $data['month_name'] = $month_name;
    $data['year'] = $year;
    $data['company'] = $company;

    return view('admin.payroll.compliance_sheet.list', $data);

  }

  public function compliance_sheet_export(Request $request){
    ini_set('max_execution_time', '1000000');

    $file_name = 'Compliance Sheet -  ';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
    return Excel::download(new ComplianceSheetExport($request), $file_name);

  }

}
