<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use App\Exports\TestExport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;



class TestController extends Controller
{

  public function employeeNewLeaveByJoining(Request $request)
  {



    $emp_data = DB::connection('erpnext')
              ->table('tabEmployee')
              ->where('status', "Active")
              // ->whereNotIn('employee', ["HR-EMP-PJHM-0595"])
              // ->where('company', "Pinkcity Jewelhouse Private Ltd-Mahapura")
              // ->where('company', "Pinkcity Jewelhouse Private Limited- Unit 1")
              // ->where('company', "Pinkcity Jewelhouse Private Limited-Unit 2")
              ->where('date_of_joining', "<", "2022-11-01")
              ->orderBy('date_of_joining', "DESC")
              ->get();


      print_r("<pre>");
      print_r("<br>hi11<br>");
      // die;


      foreach ($emp_data as $key => $value) {

        print_r("<br>emp_data <br>");
        print_r($value);
        // continue;
        // die;

        $new_join = "2022-04-01";
        $date_of_join = $value->date_of_joining;

        print_r("<br> new_join : $new_join<br>");
        print_r("<br> date_of_join : $date_of_join<br>");

        $new_join_date = date_create($new_join);
        $date_of_join_date = date_create($date_of_join);


        // $emp_data = DB::connection('erpnext')
        //           ->table('tabEmployee')
        //           ->where('status', "Active")
        //           ->where('company', "Pinkcity Jewelhouse Private Ltd-Mahapura")
        //           ->orderBy('date_of_joining', "DESC")
        //           ->get();


        // print_r("<br>new_join_date<br>");
        // print_r($new_join_date);
        // print_r("<br>date_of_join_date<br>");
        // print_r($date_of_join_date);

        $date_diff = date_diff($date_of_join_date, $new_join_date);

        // $new_cl = 0.5;
        $new_cl =1;
        $new_el_pl = 1;
        if($date_diff->invert == 1) {
          // $new_cl = 0.5;
          $new_cl = 1;
        }
        else {
          // $new_cl = 1;
          $new_cl = 1;
          // $new_cl = 0.5;
        }

        print_r("<br>new_cl : $new_cl<br>");
        print_r("<br>new_el_pl : $new_el_pl<br>");




          $name = "";
            // generate unique name feild ================ start =============================
            $check = 0;
            $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
            while($check == 0) {
              $name = "";
              for($i=0; $i<10; $i++) {
                $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
              }

              $checkName = DB::connection('erpnext')
                  ->table('tabProduction Workflow')
                  ->where('name', 'like', '%' . $name ."%")
                  ->first();

              if(empty($checkName)) {
                $check = 1;
              }
            }
            // generate unique name feild ================ end =============================




        $data = DB::connection('erpnext')
        ->table('tabLeave Ledger Entry')
        ->insert(["name"=> $name,
                  "creation"=> date('Y-m-d h:i:s', time()),
                  "modified"=> date('Y-m-d h:i:s', time()),
                  "modified_by"=> "Administrator",
                  "owner"=> "Administrator",
                  "docstatus"=>1,
                  "parent"=>null,
                  "parentfield"=>null,
                  "parenttype"=>null,
                  "idx"=>0,
                  "employee"=>$value->employee,
                  "employee_name"=>$value->employee_name,
                  "leave_type"=>"CL",
                  "transaction_type"=>"Leave Allocation",
                  "transaction_name"=>null,
                  "leaves"=>$new_cl,
                  "from_date"=>"2022-10-31",
                  "to_date"=>"2022-12-31",
                  "holiday_list"=>null,
                  "is_carry_forward"=>0,
                  "is_expired"=>0,
                  "is_lwp"=>0,
                  "amended_from"=>null,
                  "_user_tags"=>null,
                  "_comments"=>null,
                  "_assign"=>null,
                  "_liked_by"=>null,
                  "company"=>$value->company,
                ]);




        $name = "";
          // generate unique name feild ================ start =============================
          $check = 0;
          $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
          while($check == 0) {
            $name = "";
            for($i=0; $i<10; $i++) {
              $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
            }

            $checkName = DB::connection('erpnext')
                ->table('tabLeave Ledger Entry')
                ->where('name', 'like', '%' . $name ."%")
                ->first();

            if(empty($checkName)) {
              $check = 1;
            }
          }
          // generate unique name feild ================ end =============================



        $data = DB::connection('erpnext')
        ->table('tabLeave Ledger Entry')
        ->insert(["name"=> $name,
                  "creation"=> date('Y-m-d h:i:s', time()),
                  "modified"=> date('Y-m-d h:i:s', time()),
                  "modified_by"=> "Administrator",
                  "owner"=> "Administrator",
                  "docstatus"=>1,
                  "parent"=>null,
                  "parentfield"=>null,
                  "parenttype"=>null,
                  "idx"=>0,
                  "employee"=>$value->employee,
                  "employee_name"=>$value->employee_name,
                  "leave_type"=>"EL/PL",
                  "transaction_type"=>"Leave Allocation",
                  "transaction_name"=>null,
                  "leaves"=>$new_el_pl,
                  "from_date"=>"2022-10-31",
                  "to_date"=>"2022-12-31",
                  "holiday_list"=>null,
                  "is_carry_forward"=>0,
                  "is_expired"=>0,
                  "is_lwp"=>0,
                  "amended_from"=>null,
                  "_user_tags"=>null,
                  "_comments"=>null,
                  "_assign"=>null,
                  "_liked_by"=>null,
                  "company"=>$value->company,
                ]);


        $leave_data = DB::connection('erpnext')
                  ->table('tabLeave Allocation')
                  ->where('employee', $value->employee)
                  ->get();


        // print_r("<br>leave_data<br>");
        // print_r($leave_data);
      $total_leaves_allocated_el_pl = 0;
      $total_leaves_allocated_cl = 0;

      $new_total_leaves_allocated_el_pl = 0;
      $new_total_leaves_allocated_cl = 0;

        foreach ($leave_data as $key2 => $value2) {
          if($value2->leave_type == "EL/PL") {
            $total_leaves_allocated_el_pl = $value2->total_leaves_allocated;
            // print_r("<br>total_leaves_allocated_el_pl : $total_leaves_allocated_el_pl<br>");
          }
          if($value2->leave_type == "CL") {
            $total_leaves_allocated_cl = $value2->total_leaves_allocated;
            // print_r("<br>total_leaves_allocated_cl : $total_leaves_allocated_cl<br>");
          }
        }

        print_r("<br>total_leaves_allocated_el_pl : $total_leaves_allocated_el_pl<br>");
        print_r("<br>total_leaves_allocated_cl : $total_leaves_allocated_cl<br>");

        $new_total_leaves_allocated_el_pl = $total_leaves_allocated_el_pl + $new_el_pl;
        $new_total_leaves_allocated_cl = $total_leaves_allocated_cl + $new_cl;

        print_r("<br>new_total_leaves_allocated_el_pl : $new_total_leaves_allocated_el_pl<br>");
        print_r("<br>new_total_leaves_allocated_cl : $new_total_leaves_allocated_cl<br>");

        $data = DB::connection('erpnext')
                ->table('tabLeave Allocation')
                ->where('employee',  $value->employee )
                ->where('leave_type',  "CL" )
                ->where('from_date',  "2022-01-01" )
                ->where('to_date',  "2022-12-31" )
                ->update(['total_leaves_allocated'=>$new_total_leaves_allocated_cl]);

        $data = DB::connection('erpnext')
                ->table('tabLeave Allocation')
                ->where('employee',  $value->employee )
                ->where('leave_type',  "EL/PL" )
                ->where('from_date',  "2022-01-01" )
                ->where('to_date',  "2022-12-31" )
                ->update(['total_leaves_allocated'=>$new_total_leaves_allocated_el_pl]);


      }

      print_r("<br>hi88<br>");

  }


  public function empLeaveMismatch($value='')
  {

    $data = DB::connection('erpnext')
            ->select('SELECT tla.employee, tla.employee_name, tla.leave_type, tla.from_date, tla.to_date,
                        tlle.employee, tlle.employee_name, tlle.leave_type, tlle.from_date, tlle.to_date
                      from `tabLeave Application` tla
                      LEFT JOIN `tabLeave Ledger Entry` tlle
                        on tlle.employee = tla.employee and tlle.from_date = tla.from_date
                        and tlle.to_date = tla.to_date
                      WHERE tla.docstatus = 1
                      and tla.company  = "Pinkcity Jewelhouse Private Limited-Unit 2"
                      and tla.from_date > "2022-09-01"
                      ORDER by tla.creation desc');


            // SELECT sum(CASE
            //                     when ta.status = 'Present' then 1
            //                     when ta.status = 'Half Day' then 0.5
            //                     ELSE 0
            //                    END) total_present, tm.`month`, tm.month_no, employee, employee_name, company
            // FROM tabAttendance ta
            // LEft JOIn tabMonth tm on month_no =  MONTH(ta.attendance_date)
            // WHERE ta.attendance_date >= '2023-01-01' AND ta.attendance_date <= '2023-12-31'
            // GROUP BY ta.employee, tm.`month`
            // LIMIT 10

  echo "<pre>";
  print_r($data);

  }

  public function empLeaveDetails($value='')
  {

    $emp_data = DB::connection('erpnext')
              ->table('tabEmployee')
              ->where('status', "Active")
              ->where('company', "Pinkcity Jewelhouse Private Ltd-Mahapura")
              ->get();

      echo "<pre>";

    foreach ($emp_data as $key => $value) {

      $total_leaves_allocated_el_pl = 0;
      $total_leaves_allocated_cl = 0;
      $total_leaves_allocated_co = 0;
      print_r("<br>emp_data<br>");
      print_r($value);
      $leave_allocation_data = DB::connection('erpnext')
                      ->table('tabLeave Allocation')
                      ->where('employee',  $value->employee )
                      ->where('from_date', ">", "2021-12-31" )
                      ->get();

      // print_r("<br>leave_allocation_data<br>");
      // print_r($leave_allocation_data);

      foreach ($leave_allocation_data as $key2 => $value2) {


        if($value2->leave_type == "EL/PL") {
          $total_leaves_allocated_el_pl = $value2->total_leaves_allocated;
          print_r("<br>total_leaves_allocated EL/PL : $value2->total_leaves_allocated  <br>");
        }
        if($value2->leave_type == "CL") {
          $total_leaves_allocated_cl = $value2->total_leaves_allocated;
          print_r("<br>total_leaves_allocated CL : $value2->total_leaves_allocated  <br>");
        }
        if($value2->leave_type == "CO") {
          $total_leaves_allocated_co = $value2->total_leaves_allocated;
          print_r("<br>total_leaves_allocated CO : $value2->total_leaves_allocated  <br>");
        }


      }



      $leave_leader_data = DB::connection('erpnext')
                      ->table('tabLeave Ledger Entry')
                      ->where('employee',  $value->employee )
                      ->where('docstatus',  1 )
                      ->get();

      // print_r("<br>leave_leader_data<br>");
      // print_r($leave_leader_data);


      $total_allocated_el_pl_leader = 0;
      $total_allocated_cl_leader = 0;
      $total_allocated_co_leader = 0;
      $total_allocated_lwp_leader = 0;

      $total_applied_el_pl_leader = 0;
      $total_applied_cl_leader = 0;
      $total_applied_co_leader = 0;
      $total_applied_lwp_leader = 0;


      foreach ($leave_leader_data as $key3 => $value3) {

        if($value3->leave_type == "EL/PL") {
          if($value3->transaction_type == "Leave Application") {
            $total_applied_el_pl_leader = $total_applied_el_pl_leader + $value3->leaves;
          }
          if($value3->transaction_type == "Leave Allocation") {
            $total_allocated_el_pl_leader = $total_allocated_el_pl_leader + $value3->leaves;
          }
        }

        if($value3->leave_type == "CL") {
          if($value3->transaction_type == "Leave Application") {
            $total_applied_cl_leader = $total_applied_cl_leader + $value3->leaves;
          }
          if($value3->transaction_type == "Leave Allocation") {
            $total_allocated_cl_leader = $total_allocated_cl_leader + $value3->leaves;
          }
        }

        if($value3->leave_type == "CO") {
          if($value3->transaction_type == "Leave Application") {
            $total_applied_co_leader = $total_applied_co_leader + $value3->leaves;
          }
          if($value3->transaction_type == "Leave Allocation") {
            $total_applied_co_leader = $total_applied_co_leader + $value3->leaves;
          }
        }

        if($value3->leave_type == "LWP") {
          if($value3->transaction_type == "Leave Application") {
            $total_applied_lwp_leader = $total_applied_lwp_leader + $value3->leaves;
          }
          if($value3->transaction_type == "Leave Allocation") {
            $total_allocated_lwp_leader = $total_allocated_lwp_leader + $value3->leaves;
          }
        }

      }


      print_r("<br>total_allocated_el_pl_leader : $total_allocated_el_pl_leader  <br>");
      print_r("<br>total_allocated_cl_leader : $total_allocated_cl_leader  <br>");
      print_r("<br>total_allocated_co_leader : $total_allocated_co_leader  <br>");
      print_r("<br>total_allocated_lwp_leader : $total_allocated_lwp_leader  <br>");

      print_r("<br>total_applied_el_pl_leader : $total_applied_el_pl_leader  <br>");
      print_r("<br>total_applied_cl_leader : $total_applied_cl_leader  <br>");
      print_r("<br>total_applied_co_leader : $total_applied_co_leader  <br>");
      print_r("<br>total_applied_lwp_leader : $total_applied_lwp_leader  <br>");


      $total_el_pl_application = 0;
      $total_cl_application = 0;
      $total_co_application = 0;
      $total_lwp_application = 0;


      $leave_app_data = DB::connection('erpnext')
                      ->table('tabLeave Application')
                      ->where('employee',  $value->employee )
                      ->where('docstatus',  1 )
                      ->where('status',  'Approved' )
                      ->get();


      foreach ($leave_app_data as $key3 => $value3) {

        if($value3->leave_type == "EL/PL") {
          $total_el_pl_application = $total_el_pl_application + $value3->total_leave_days;
        }

        if($value3->leave_type == "CL") {
          $total_cl_application = $total_cl_application + $value3->total_leave_days;
        }

        if($value3->leave_type == "CO") {
          $total_co_application = $total_co_application + $value3->total_leave_days;
        }

        if($value3->leave_type == "LWP") {
          $total_lwp_application = $total_lwp_application + $value3->total_leave_days;
        }

      }

      print_r("<br>total_el_pl_application : $total_el_pl_application  <br>");
      print_r("<br>total_cl_application : $total_cl_application  <br>");
      print_r("<br>total_co_application : $total_co_application  <br>");
      print_r("<br>total_lwp_application : $total_lwp_application  <br>");

      $leave_data = [];
      $leave_data['total_leaves_allocated_el_pl'] = $total_leaves_allocated_el_pl;
      $leave_data['total_leaves_allocated_cl'] = $total_leaves_allocated_cl;
      $leave_data['total_leaves_allocated_co'] = $total_leaves_allocated_co;
      $leave_data['total_allocated_el_pl_leader'] = $total_allocated_el_pl_leader;
      $leave_data['total_allocated_cl_leader'] = $total_allocated_cl_leader;
      $leave_data['total_allocated_co_leader'] = $total_allocated_co_leader;
      $leave_data['total_allocated_lwp_leader'] = $total_allocated_lwp_leader;
      $leave_data['total_applied_el_pl_leader'] = $total_applied_el_pl_leader;
      $leave_data['total_applied_cl_leader'] = $total_applied_cl_leader;
      $leave_data['total_applied_co_leader'] = $total_applied_co_leader;
      $leave_data['total_applied_lwp_leader'] = $total_applied_lwp_leader;
      $leave_data['total_el_pl_application'] = $total_el_pl_application;
      $leave_data['total_cl_application'] = $total_cl_application;
      $leave_data['total_co_application'] = $total_co_application;
      $leave_data['total_lwp_application'] = $total_lwp_application;

      $emp_data[$key]->leave_data = $leave_data;

    }
  }

  public function testDataExport(Request $request){

    // Create new state:
    // $state = smbclient_state_new();
    // // Initialize the state with workgroup, username and password:
    // smbclient_state_init($state, null, 'jhs', 'jhs');
    // // Open a file for reading:
    // $file = smbclient_open($state, 'smb://192.168.2.5/MwPict/DM LD RG17337.jpg', 'r');
    // if ($file) {
    //   // Read the file incrementally, dump contents to output:
    //   while ($data = smbclient_read($state, $file, 1000)) {
    //     echo $data;
    //   }
    // }
    // // Close the file handle:
    // smbclient_close($state, $file);
    // // Free the state
    // smbclient_state_free($state);

    print_r("<pre>");
    // print_r(phpinfo());
    // print_r(readfile('smb://jhs:jhs@192.168.2.5/MwPict/3D/ZP/ZP11847.jpg'));
    $data = file_get_contents('/opt/lampp/htdocs/test/DM LD RG17337.jpg');
    print_r($data);
    // print_r(rawurlencode("smb://jhs:jhs@192.168.2.5/MwPict/DM LD RG17337.jpg"));

      // print_r("hi");
      // die;

      // $file_name = 'testReport';
      //
      // $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
      //
      // return Excel::download(new TestExport($request), $file_name);
    }


    public function updateLeaveLeadgerBalance(Request $request)
    {
      $emp_id =0;
      $date =0;
        if(empty($request->emp_id)){
            $emp_id = $request->emp_id;
            echo "emp_id Is Required For Attendnce Entry";
            exit;
        }
        // if(empty($request->date)){
        //     $date = $request->date;
        //     echo "attendance_date Is Required For Attendnce Entry";
        //     exit;
        // }

  //       SELECT te.employee, te.employee_name, te.department, te.designation,  sum(CASE
  // 				when ta.status = 'Present' then 1
  // 				when ta.status = 'Half Day' then 0.5
  // 				ELSE 0
  // 		   END) total_attend,sum(CASE
  // 				when ta.status = 'Present' then 1
  // 				when ta.status = 'Half Day' then 0.5
  // 				ELSE 0
  // 		   END)/20 total_pl
  // 		   FROM tabEmployee te
  // LEFT JOIN tabAttendance ta on ta.employee = te.employee
  // WHERE te.company = 'Pinkcity Jewelhouse Private Limited-Unit 2' and ta.attendance_date > '2021-12-31'

      // $month = date("m", strtotime($request->date) );
      // $year = date("Y", strtotime($request->date) );
      //
      // $check_el_pl = 0;
      // $check_cl = 0;

      $query_data = $this->erpnextDB
                  ->table('tabLeave Allocation')
                  // ->select(DB::raw("sum(CASE
                  //   when ta.status = 'Present' then 1
                  //   when ta.status = 'Half Day' then 0.5
                  //   ELSE 0
                  //  END) total_present, employee, employee_name, company") )
                  // ->where('employee', $request->emp_id)
                  // ->where('employee', "HR-EMP-PJHM-0429")
                  // ->where('owner', 'pm0138@pinkcityindia.com')
                  ->where('leave_type', "EL/PL")
                  ->where('from_date',  "2023-01-01")
                  ->where('to_date',   "2023-12-31")
                  ->get();

  print_r("<br>hi132#<br>");
  // die;


    foreach ($query_data as $key => $query1) {


        if($query1->previous_year_leave > 0) {

          print_r("<br>hi131#<br>");

            $name = "";
              // generate unique name feild ================ start =============================
              $check = 0;
              $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
              while($check == 0) {
                $name = "";
                for($i=0; $i<10; $i++) {
                  $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
                }

                $checkName = DB::connection('erpnext')
                    ->table('tabLeave Ledger Entry')
                    ->where('name', 'like', '%' . $name ."%")
                    ->first();

                if(empty($checkName)) {
                  $check = 1;
                }
              }
              // generate unique name feild ================ end =============================



            $data = $this->erpnextDB
            ->table('tabLeave Ledger Entry')
            ->insert(["name"=> $name,
                      "creation"=> date('Y-m-d h:i:s', time()),
                      "modified"=> date('Y-m-d h:i:s', time()),
                      "modified_by"=> "Administrator",
                      "owner"=> "Administrator",
                      "docstatus"=>1,
                      "parent"=>null,
                      "parentfield"=>null,
                      "parenttype"=>null,
                      "idx"=>0,
                      "employee"=>$query1->employee,
                      "employee_name"=>$query1->employee_name,
                      "leave_type"=>"EL/PL",
                      "transaction_type"=>"Leave Allocation",
                      "transaction_name"=>null,
                      "leaves"=>$query1->previous_year_leave,
                      "from_date"=>"2023-01-01",
                      "to_date"=>"2023-12-31",
                      "holiday_list"=>'Holiday List 2023',
                      "is_carry_forward"=>1,
                      "is_expired"=>0,
                      "is_lwp"=>0,
                      "amended_from"=>null,
                      "_user_tags"=>null,
                      "_comments"=>null,
                      "_assign"=>null,
                      "_liked_by"=>null,
                      "company"=>$query1->company,
                    ]);

          $data = $this->erpnextDB
                  ->table('tabLeave Allocation')
                  ->where('employee',  $query1->employee )
                  ->where('leave_type',  "EL/PL" )
                  ->where('from_date',  "2023-01-01" )
                  ->where('to_date',  "2023-12-31" )
                  ->update(['total_leaves_allocated'=> DB::raw( "previous_year_leave + ". (0) ) ]);


        }
      }



    }

//     SELECT tt.sku, tt.stock, tt.price,  tt.category, tt.`Item Name`,
// ti.item_code, ti.item_name, ti.item_group, ti.valuation_rate, ti.description, ti.metal_group, ti.metal_type, ti.opening_stock,
// (SELECT qty_after_transaction FROm `tabStock Ledger Entry` tsle where tsle.item_code = ti.item_code and tsle.is_cancelled = 0 ORDER BY
// 			creation DESC LIMIT 1) ti_stock,
// (SELECT qty FROm `tabStock Reconciliation Item` tsri where tsri.item_code = ti.item_code and tsri.docstatus <= 1 ORDER BY
// 			creation DESC LIMIT 1) tsri_stock
// FROM testTable tt
// LEFT JOIN tabItem ti ON ti.item_code = tt.sku



    public function testFun($value='')
    {


      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sociablekit.com/api/sync-requests/create?embed_id=161549&type=2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => ["embed_id"=> "161549", "type" => 2],
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer Bearer 200357|ZTw9SwgysTYtqMOXdPBEUK6d9Q2Wh7twV9PhR8qQ',
          // 'Cookie: laravel_session=UpSECCcrjTLGnCpdo6hkKSoh5ynFPc4RwS06I6qc'
        ),
      ));

      $response = curl_exec($curl);

      print_r("<pre>");
      print_r("<br>hi11<br>");
      print_r($response);

      curl_close($curl);
      echo $response;



      // $data = DB::connection('erpnext')
      //         ->select('SELECT * from `tabDM Rm Code Master` tdrcm WHERE ISNULL(raw_material_category) ');
      //
      //     echo "<pre>";
      //     print_r($data);
      //
      //     foreach ($data as $key => $value) {
      //       // $data2 = DB::connection('EmrSitapura')
      //       $data2 = DB::connection('Emr')
      //               ->select("SELECT * FROM RmMst WHERE RmCd = '$value->name'");
      //               // echo "<pre>";
      //               print_r($data2);
      //       if(isset($data2[0]->RmCd)) {
      //         $data = DB::connection('erpnext')
      //                 ->table('tabDM Rm Code Master')
      //                 ->where('name',  $value->name )
      //                 ->update(['rm_code'=> $data2[0]->RmCd,
      //                           'rm_code_name' => $data2[0]->RmDesc,
      //                           'raw_material_category' => $data2[0]->RmCtg,
      //                           'raw_material_sub_category' => $data2[0]->RmSCtg,
      //                           'raw_material_desc' => $data2[0]->RmDesc,
      //                         ]);
      //       }
      //     }



    }



    // SELECT




}
