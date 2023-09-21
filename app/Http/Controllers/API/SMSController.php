<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Exception;
use Twilio\Rest\Client;
use UltraMsg\WhatsAppApi;



class SMSController extends Controller
{
  public function __construct()
  {
    $this->erpnextDB = DB::connection('erpnext');
  }


  public function employeeSalarySlip(Request $request)
  {

        $receiverNumber = "+91";
        $message = "";

        $salary_slip = $this->erpnextDB
                      ->table('tabSalary Slip AS tss')
                      ->select(DB::Raw('tss.*, tabEmployee.cell_number, tabEmployee.mother_name'))
                      ->join("tabEmployee", "tabEmployee.name", "=", "tss.employee")
                      ->where("tss.name", $request->id)
                      ->first();
      if( empty($salary_slip) ) {
        echo json_encode(["msg"=>"Salary Slip not found.", "status"=>false]);die;
      }

      if( empty($salary_slip->cell_number) ) {
        echo json_encode(["msg"=>"Please update your active Mobile No.", "status"=>false]);die;
      }

      $receiverNumber .= $salary_slip->cell_number;
      $message .= $salary_slip->company ."\n";
      $message .= "Salary Slip of ". date("F", strtotime($salary_slip->start_date)) . " " . date("Y", strtotime($salary_slip->start_date)) . "\n";
      $message .= "Employee Number : $salary_slip->employee \n" ;
      $message .= "Employee Name : $salary_slip->employee_name \n" ;
      $message .= "Gross Earnings : ". round($salary_slip->gross_pay) . " \n" ;
      $message .= "Gross Deductions : ". round($salary_slip->total_deduction) ." \n" ;
      $message .= "Net Pay :  ". round($salary_slip->net_pay) ." \n" ;


        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
            // $twilio_number = "whatsapp:".getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

            echo json_encode(["msg"=>"SMS sent successfully.", "status"=>true, "data"=>""]); die;

        } catch (Exception $e) {
             echo json_encode(["msg"=>"SMS could not be sent.", "status"=>false, "data"=>$e->getMessage()]); die;
        }
  }


  public function whatsappWebhook(Request $request)
  {
        print_r($_REQUEST);
        die;
  }



  public function employeeSalarySlipWhatsapp(Request $request)
  {
    $receiverNumber = "whatsapp:+91";
    $message = "";


    $salary_slip = $this->erpnextDB
                  ->table('tabSalary Slip AS tss')
                  ->select(DB::Raw('tss.*, tabEmployee.cell_number, tabEmployee.mother_name'))
                  ->join("tabEmployee", "tabEmployee.name", "=", "tss.employee")
                  ->where("tss.name", $request->id)
                  ->first();
    if( empty($salary_slip) ) {
      echo json_encode(["msg"=>"Salary Slip not found.", "status"=>false]);die;
    }

    if( empty($salary_slip->cell_number) ) {
      echo json_encode(["msg"=>"Please update your active Whatsapp No.", "status"=>false]);die;
    }

    $receiverNumber .= $salary_slip->cell_number;
    $message .= $salary_slip->company ."\n";
    $message .= "Salary Slip of ". date("F", strtotime($salary_slip->start_date)) . " " . date("Y", strtotime($salary_slip->start_date)) . "\n";
    $message .= "Employee Number : $salary_slip->employee \n" ;
    $message .= "Employee Name : $salary_slip->employee_name \n" ;
    $message .= "Gross Earnings : ". round($salary_slip->gross_pay) . " \n" ;
    $message .= "Gross Deductions : ". round($salary_slip->total_deduction) ." \n" ;
    $message .= "Net Pay :  ". round($salary_slip->net_pay) ." \n" ;



    try {

        $account_sid = "AC93f520c47f3cdad75188fdf826827174";
        $auth_token = "5c9aaf8acb9b2fee8196b1a8c8ed1744";
        $twilio_number = "whatsapp:+14155238886";
        // $twilio_number = "whatsapp:".getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
            'from' => $twilio_number,
            'body' => $message]);

        echo json_encode(["msg"=>"Whatsapp message sent successfully.", "status"=>true, "data"=>""]); die;

    } catch (Exception $e) {

        echo json_encode(["msg"=>"Whatsapp message could not be sent.", "status"=>false, "data"=>$e->getMessage()]); die;
    }
  }




}
