<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use App\Exports\EmployeeCheckINExport;

class ESSLController extends Controller
{

  public function __construct()
  {
    // $this->erpnextDB = DB::connection('erpnext');
    // $this->attendanceDB = DB::connection('Attendance');
  }

  public function essl_department_list(Request $request){

    $title = 'ESSL Department List';

    // $query = $this->attendanceDB
    $query = DB::connection('Attendance')
                ->table('Departments')
                ->orderBy('DepartmentId','DESC');

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }

    $department_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['department_data'] = $department_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.essl.department.list', $data );
  }

  public function essl_employee_list(Request $request){

    $title = 'ESSL Employees List';

    // $query = $this->attendanceDB
    $query = DB::connection('Attendance')
                ->table('Employees')
                ->select('Employees.*', "Companies.CompanySName", "Companies.CompanyFName")
                ->leftJoin('Companies', "Companies.CompanyId", "=", "Employees.CompanyId")
                ->orderBy('Employees.EmployeeId','DESC');

    if(!empty($request->employee_name)){
        $query->where('EmployeeName', 'like', '%' . $request->employee_name. '%');
    }

    if(!empty($request->company)){
        $query->where('Companies.CompanySName', $request->company);
    }

    if(!empty($request->status)){
        $query->where('status', $request->status);
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }

    $employee_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['employee_data'] = $employee_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.essl.employee.list', $data );
  }

  public function check_in_local_list(Request $request){

    $title = 'Attendance List';

    $query = DB::table('attendance')
                ->orderBy('id','DESC');

    if(!empty($request->employee_name)){
        $query->where('emp_name', 'like', '%' . $request->employee_name. '%');
    }

    if(!empty($request->company)){
        $query->where('company', $request->company);
    }

    if(!empty($request->start_date)){
        $query->whereDate('in_time', ">=", $request->start_date);
        $query->orderBy('in_time', "ASC");
    }
    else {
      $query->orderBy('in_time', "DESC");
      $auto_start_date = date('Y-m-d');
      $query->whereDate('in_time', $auto_start_date);
      $request->start_date = $auto_start_date;
    }

    if(!empty($request->end_date)){
        $query->whereDate('in_time', "<=", $request->end_date);
    }


    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }

    $check_in_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['check_in_data'] = $check_in_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.essl.check_in.list', $data );
  }

  public function check_in_local_export(Request $request){

    $file_name = 'Attendance Entry';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    if(!empty($request->start_date)){
      $file_name .= '-' . $request->start_date;
    }

    $file_name .=  '.xlsx';


    return Excel::download(new EmployeeCheckINExport($request),  $file_name);

  }


  public function check_in_local_add(Request $request){

    $title = 'Attendance Entry';

    $data['title'] = $title;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.essl.check_in.add', $data );
  }

  public function check_in_local_add_data(Request $request){

    $get_emp_data = DB::connection('Attendance')
                ->table('Employees')
                ->select('Employees.*', "Companies.CompanySName", "Companies.CompanyFName", "Departments.DepartmentFName")
                ->leftJoin('Companies', "Companies.CompanyId", "=", "Employees.CompanyId")
                ->leftJoin('Departments', "Departments.DepartmentId", "=", "Employees.DepartmentId")
                ->where('Employees.EmployeeCode',$request->employee_id)
                ->first();

    if(empty($get_emp_data)) {
      echo json_encode(["msg"=>"Employee not found", "status"=>false, "data"=>""]); die;
    }

    $data = DB::table('attendance')
            ->where('employee_id',  $request->employee_id )
            ->where('type',  $request->type )
            ->whereRaw( " ( DATE(in_time) = '". date("Y-m-d") ."' OR DATE(out_time) = '". date("Y-m-d")  ."' ) ")
            // ->whereDate('in_time',  date("Y-m-d") )
            // ->whereDate('in_time',  date("Y-m-d") )
            ->orderBy('created_on',  "DESC")
            ->first();

    // $check_in = "In";
    // if($request->type == 0) { $check_in = "Out";}

    // for check in --- entry ---------------------------
    if($request->type == 1) {
      // for blank entry
      if(empty($data)) {
        $query = DB::table('attendance')
                ->insert([
                  "employee_id"=>$request->employee_id,
                  "type"=>$request->type,
                  "emp_name"=>$get_emp_data->EmployeeName,
                  "designation"=>$get_emp_data->Designation,
                  "department"=>$get_emp_data->DepartmentFName,
                  "designation"=>$get_emp_data->Designation,
                  "company"=>$get_emp_data->CompanySName,
                  "in_time"=>date("Y-m-d h:i:s"),
                  "created_by"=>auth()->user()->email,
                  "created_on"=>date("Y-m-d h:i:s"),
                ]);
        echo json_encode(["msg"=>"Employee Check-in added successfully.", "status"=>true, "data"=>""]); die;
      } else {
        // add another check for given date
        if(isset($data->out_time)) {
          $query = DB::table('attendance')
                  ->insert([
                    "employee_id"=>$request->employee_id,
                    "type"=>$request->type,
                    "emp_name"=>$get_emp_data->EmployeeName,
                    "designation"=>$get_emp_data->Designation,
                    "department"=>$get_emp_data->DepartmentFName,
                    "designation"=>$get_emp_data->Designation,
                    "company"=>$get_emp_data->CompanySName,
                    "in_time"=>date("Y-m-d h:i:s"),
                    "created_by"=>auth()->user()->email,
                    "created_on"=>date("Y-m-d h:i:s"),
                  ]);
          echo json_encode(["msg"=>"Employee Check-in added successfully.", "status"=>true, "data"=>""]); die;
        }
        // add check - out first
        else {
          echo json_encode(["msg"=>"Employee Check-in already added. Please add check - out entry", "status"=>false, "data"=>""]); die;
        }
      }
    }
    // for check - out entry
    else {
      $query = DB::table('attendance')
              ->where('employee_id',  $request->employee_id )
              ->whereDate('in_time',  date("Y-m-d") )
              ->whereNull('out_time')
              ->update([
                "employee_id"=>$request->employee_id,
                "out_time"=>date("Y-m-d h:i:s"),
                "modified_by"=>auth()->user()->email,
                "modified_on"=>date("Y-m-d h:i:s"),
              ]);
      if($query) {
        echo json_encode(["msg"=>"Employee Check-out added successfully.", "status"=>true, "data"=>""]); die;
      }
      // add check - in first
      else {
        echo json_encode(["msg"=>"Employee Check-in not found. Please add check - in entry first", "status"=>false, "data"=>""]); die;
      }
    }


  }


  public function check_in_local_get_emp_details(Request $request){

    $get_emp_data = DB::connection('Attendance')
                ->table('Employees')
                ->select('Employees.*', "Companies.CompanySName", "Companies.CompanyFName", "Departments.DepartmentFName")
                ->leftJoin('Companies', "Companies.CompanyId", "=", "Employees.CompanyId")
                ->leftJoin('Departments', "Departments.DepartmentId", "=", "Employees.DepartmentId")
                ->where('Employees.EmployeeCode',$request->employee_id)
                ->first();

    if(empty($get_emp_data)) {
      echo json_encode(["msg"=>"Employee not found", "status"=>false, "data"=>""]); die;
    } else {
      echo json_encode(["msg"=>"Employee found", "status"=>true, "data"=>$get_emp_data ]); die;
    }

  }


}
