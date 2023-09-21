<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\Library\AdminHelper;

class TestExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
        // $this->EmrSeetapuraDB = DB::connection('EmrSeetapura');
        // $this->erpnextDB = DB::connection('erpnext');
    }

    public function view(): View
    {
      $emp_data = DB::connection('erpnext')
                ->table('tabEmployee')
                ->where('status', "Active")
                // ->where('company', "Pinkcity Jewelhouse Private Ltd-Mahapura")
                // ->where('company', "Pinkcity Jewelhouse Private Limited- Unit 1")
                ->where('company', "Pinkcity Jewelhouse Private Limited-Unit 2")
                // ->limit(5)
                ->get();

        // echo "<pre>";

      foreach ($emp_data as $key => $value) {

        $total_leaves_allocated_el_pl = 0;
        $total_leaves_allocated_cl = 0;
        $total_leaves_allocated_co = 0;
        // print_r("<br>emp_data<br>");
        // print_r($value);
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
            // print_r("<br>total_leaves_allocated EL/PL : $value2->total_leaves_allocated  <br>");
          }
          if($value2->leave_type == "CL") {
            $total_leaves_allocated_cl = $value2->total_leaves_allocated;
            // print_r("<br>total_leaves_allocated CL : $value2->total_leaves_allocated  <br>");
          }
          if($value2->leave_type == "CO") {
            $total_leaves_allocated_co = $value2->total_leaves_allocated;
            // print_r("<br>total_leaves_allocated CO : $value2->total_leaves_allocated  <br>");
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


        // print_r("<br>total_allocated_el_pl_leader : $total_allocated_el_pl_leader  <br>");
        // print_r("<br>total_allocated_cl_leader : $total_allocated_cl_leader  <br>");
        // print_r("<br>total_allocated_co_leader : $total_allocated_co_leader  <br>");
        // print_r("<br>total_allocated_lwp_leader : $total_allocated_lwp_leader  <br>");
        //
        // print_r("<br>total_applied_el_pl_leader : $total_applied_el_pl_leader  <br>");
        // print_r("<br>total_applied_cl_leader : $total_applied_cl_leader  <br>");
        // print_r("<br>total_applied_co_leader : $total_applied_co_leader  <br>");
        // print_r("<br>total_applied_lwp_leader : $total_applied_lwp_leader  <br>");


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

        // print_r("<br>total_el_pl_application : $total_el_pl_application  <br>");
        // print_r("<br>total_cl_application : $total_cl_application  <br>");
        // print_r("<br>total_co_application : $total_co_application  <br>");
        // print_r("<br>total_lwp_application : $total_lwp_application  <br>");

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

      return view('exports.test', ['emp_data' => $emp_data] );

      }




}
