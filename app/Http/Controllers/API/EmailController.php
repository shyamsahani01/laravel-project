<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
// use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDF;



class EmailController extends Controller
{

  public function __construct()
  {
    $this->erpnextDB = DB::connection('erpnext');
  }

  public function planningEmails(Request $request)
  {

    // $a = ["hi"=>"10", "hi1"=>20, "hi2"=>30];
    //
    // $b = (object) $a;
    // $b->hi

    $mail = new PHPMailer(true);     // Passing `true` enables exceptions

    try {

        $planning_details = $this->erpnextDB
                      ->table('tabPlanning')
                      ->select(DB::Raw('tabPlanning.*, tabUser.full_name'))
                      ->join("tabUser", "tabPlanning.owner", "=", "tabUser.name")
                      ->where("tabPlanning.name", $request->id)
                      ->first();
      if( empty($planning_details) ) {
        echo json_encode(["msg"=>"Order not found.", "status"=>false]);die;
      }

        // Email server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        // $mail->Host = getenv("MAIL_Host");             //  smtp host
        // $mail->SMTPAuth = getenv("MAIL_SMTPAuth");
        // $mail->Username = getenv("MAIL_Username");   //  sender username
        // $mail->Password = getenv("MAIL_Password");       // sender password
        // $mail->SMTPSecure = getenv("MAIL_SMTPSecure");                  // encryption - ssl/tls
        // $mail->Port = getenv("MAIL_Port");                   // port - 587/465


        $mail->Host = "mail.shopindology.com";             //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = "erpsupport@atelierpinkcity.com";   //  sender username
        $mail->Password = "IT#102@ASP";       // sender password
        $mail->SMTPSecure = "tls";                  // encryption - ssl/tls
        $mail->Port = "587";                   // port - 587/465


        // $mail->Host = "smtp.office365.com";             //  smtp host
        // $mail->SMTPAuth = true;
        // $mail->Username = "sales@pinkcityindia.com";   //  sender username
        // $mail->Password = "Pink@65428";       // sender password
        // $mail->SMTPSecure = "tls";                  // encryption - ssl/tls
        // $mail->Port = "587";                   // port - 587/465

        // $mail->setFrom(getenv("MAIL_Username"), 'ERP Support Team');
        // $mail->setFrom(getenv("MAIL_Username"), $planning_details->full_name);
        // $mail->setFrom("sales@pinkcityindia.com", $planning_details->full_name);
        $mail->setFrom("erpsupport@atelierpinkcity.com", $planning_details->full_name);
        // $mail->addAddress($planning_details->owner);

        // $mail->addAddress([$planning_details->owner,
        //   "ravindra.cad@atelierpinkcity.com",
        //   // "designpjs@atelierpinkcity.com",
        //   // "abhishek.sharma@atelierpinkcity.com",
        //   // "productionpjm@atelierpinkcity.com",
        // ]);
        $mail->addAddress($planning_details->owner);
        // $mail->addAddress("shyamsundersahani01@gmail.com");
        // $mail->addAddress("sahuparitosh1995@gmail.com");

//         if($planning_details->owner == "abhishek@pinkcityindia.com") {
//
//
//
//         if($planning_details->company == "Pinkcity Jewelhouse Private Ltd-Mahapura") {
//           $mail->addAddress("productionpjm@pinkcityindia.com");
//           // $mail->addAddress("abhishek.sharma@atelierpinkcity.com");
//           $mail->addAddress("gemstones@pinkcityindia.com");
//           $mail->addAddress("designpjs@atelierpinkcity.com");
//           $mail->addAddress("ravindra.cad@atelierpinkcity.com");
//           $mail->addAddress("atul@atelierpinkcity.com");
//
//           $mail->AddCC("arun@pinkcityindia.com");
//           $mail->AddCC("kajal@pinkcityindia.com");
//           $mail->AddCC("merchandiser@pinkcityindia.com");
//           $mail->AddCC("mispjh@pinkcityindia.com");
//
//
// // To:- mahapura production <productionpjm@pinkcityindia.com>      ( Production Mahapura )
// // To:-abhishek.sharma@atelierpinkcity.com ( Stone )
// // To:-Mahapura Stone <gemstones@pinkcityindia.com> ( Stone )
// // To:-Ram Charan <designpjs@atelierpinkcity.com> ( Cad )
// //
// // To:-Ravindra Kumawat <ravindra.cad@atelierpinkcity.com> ( Cad )
// // To:-atul@atelierpinkcity.com <atul@atelierpinkcity.com> ( Diamond )
// //
// // CC:-Kajal Goyal <kajal@pinkcityindia.com>
// //
// // CC:-Arun Sharma <arun@pinkcityindia.com>
// // CC:-Ashok Pradhan <merchandiser@pinkcityindia.com>
// //
// // CC:-Parmanand Sharma <mispjh@pinkcityindia.com>
//
//
//         }
//         elseif($planning_details->company == "Pinkcity Jewelhouse Private Limited- Unit 1") {
//           // $mail->addAddress("ram@pinkcityindia.com");
//           // $mail->addAddress("sandeep.sharma@pinkcityindia.com");
//           //
//           // $mail->AddCC("rajiv@pinkcityindia.com");
//           // // $mail->AddCC("kajal@pinkcityindia.com");
//           echo json_encode(["msg"=>"Please update your Unit - 1 Email List", "status"=>false]);die;
//         }
//         elseif($planning_details->company == "Pinkcity Jewelhouse Private Limited-Unit 2") {
//           // $mail->addAddress("silverpjs@pinkcityindia.com");
//           $mail->addAddress("silverpjs@atelierpinkcity.com");
//           $mail->addAddress("manoj.jain@pinkcityindia.com");
//           $mail->addAddress("ppcpj2@atelierpinkcity.com");
//           // $mail->addAddress("abhishek.sharma@atelierpinkcity.com");
//           $mail->addAddress("gemstones@pinkcityindia.com");
//           $mail->addAddress("designpjs@atelierpinkcity.com");
//           $mail->addAddress("ravindra.cad@atelierpinkcity.com");
//           $mail->addAddress("stonepjs@atelierpinkcity.com");
//           $mail->addAddress("atul@atelierpinkcity.com");
//
//           $mail->AddCC("rajiv@pinkcityindia.com");
//           $mail->AddCC("arun@pinkcityindia.com");
//           $mail->AddCC("kajal@pinkcityindia.com");
//           $mail->AddCC("merchandiser@pinkcityindia.com");
//           $mail->AddCC("mispjh@pinkcityindia.com");
//
//
// //  To:- Suresh Kumar Yadav <silverpjs@pinkcityindia.com> (Production)
// // To:-Manoj Jain-Sitapura <manoj.jain@pinkcityindia.com>(Production)
// //
// // To:-Pinkcity Sitapura <ppcpj2@atelierpinkcity.com>(Production)
// //
// // To:-abhishek.sharma@atelierpinkcity.com ( Stone )
// // To:-Mahapura Stone <gemstones@pinkcityindia.com> ( Stone )
// // To:-Ram Charan <designpjs@atelierpinkcity.com> ( Cad )
// //
// // To:-Ravindra Kumawat <ravindra.cad@atelierpinkcity.com> ( Cad )
// // To:-stonepjs@atelierpinkcity.com <stonepjs@atelierpinkcity.com> ( Stone )
// // To:-atul@atelierpinkcity.com <atul@atelierpinkcity.com> ( Diamond )
// //
// // CC:-Kajal Goyal <kajal@pinkcityindia.com>
// // CC:-Rajiv Gupta <rajiv@pinkcityindia.com>
// // CC:-Arun Sharma <arun@pinkcityindia.com>
// // CC:-Ashok Pradhan <merchandiser@pinkcityindia.com>
// // CC:-Parmanand Sharma <mispjh@pinkcityindia.com>
//         }
//         else {
//           echo json_encode(["msg"=>"No Employee found for your company.", "status"=>false]);die;
//         }
//       } else {
//         echo json_encode(["msg"=>"Please update your Email List", "status"=>false]);die;
//       }


      $planning_email_details = $this->erpnextDB
                    ->table('tabPlanning Emails')
                    ->where("sales_team", $planning_details->owner)
                    ->where("company", $planning_details->company)
                    ->where("status", "Active")
                    ->get();
      $check_email = 0;
      foreach ($planning_email_details as $key => $value) {
        if($value->email_type == "To") {
          $check_email = 1;
          $mail->addAddress($value->email_id);
        }
        elseif($value->email_type == "CC") {
          $check_email = 1;
          $mail->AddCC($value->email_id);
        }
      }

      if($check_email == 0) {
        echo json_encode(["msg"=>"Please update your Email List", "status"=>false]);die;
      }





        // $mail->addBcc("shyam.sunder@pinkcityindia.com");
        $mail->addBcc("erpsupport@atelierpinkcity.com");
        // $mail->AddCC("shyam.sundar@atelierpinkcity.com");

        $mail->isHTML(true);


                                      // Set email content format to HTML=

          $mail->Subject = "New Order $planning_details->name - $planning_details->emper_code - $planning_details->order_no.";
          $mail->Body    = "Dear All,<br></br>
                            <br></br>
                            Greetings!<br></br>
                            <br></br>
                            Please find attached New Order for the Customer Code-  $planning_details->emper_code, details as per the below.<br></br>
                            Emperor Client Code: $planning_details->emper_code <br></br>
                            Order Number: $planning_details->order_no <br></br>";

        $planning_order_details = $this->erpnextDB
                      ->table('tabPlanning Order')
                      ->where("parent", $planning_details->name)
                      ->get();


                      // <th style='text-align: center; width: 15%;border: 1px solid black; font-weight: bold;'>Value</th>


        $mail->Body     .= " <table>
                                <thead>
                                <tr>
                                    <th style='text-align: center; width: 15%;border: 1px solid black; font-weight: bold;'>S.NO</th>
                                    <th style='text-align: center; width: 15%;border: 1px solid black; font-weight: bold;'>Metal</th>
                                    <th style='text-align: center; width: 15%;border: 1px solid black; font-weight: bold;'>No. of SKU</th>
                                    <th style='text-align: center; width: 15%;border: 1px solid black; font-weight: bold;'>Qty</th>
                                </tr>
                                </thead>
                                <tbody>";
        $count = 0;
        foreach ($planning_order_details as $k => $v) {
        $mail->Body     .= "   <tr>
                                    <td style='text-align: center;border: 1px solid black;'>".++$count."</td>
                                    <td style='text-align: center;border: 1px solid black;'>$v->metal</td>
                                    <td style='text-align: center;border: 1px solid black;'>$v->no_of_sku</td>
                                    <td style='text-align: center;border: 1px solid black;'>$v->qty</td>
                                </tr> ";
        }


        // <td style='text-align: center;border: 1px solid black;'>$v->value_of_order</td>

        $mail->Body     .= "          </tbody>
                              </table>
                            ";


        // $mail->Body     .= "
        //                     Metal : $planning_details->metal <br></br>
        //                     No of Sku : $planning_details->sku <br></br>
        //                     Quantity: $planning_details->qty <br></br>
        $mail->Body     .= "
                            <br></br>
                            <b>Stone demand updated in Google sheet.</b><br></br>
                            <br></br>
                            For More Details Click on below link, to view or update your department data respectively. <br></br>
                            <a href='https://erp.pinkcityindia.com/app/planning/$planning_details->name' target='_blank'>
                            https://erp.pinkcityindia.com/app/planning/$planning_details->name</a> <br></br>
                            Kindly update your complition dates within 2 days. <br></br>
                            <br></br>
                            Regards, <br></br>
                            $planning_details->full_name <br></br>";

          if( !$mail->send() ) {
            echo json_encode(["msg"=>"Email not sent", "status"=>false, "data"=>$mail->ErrorInfo]);die;
          }

          else {
            echo json_encode(["msg"=>"Email sent", "status"=>true, "data"=>""]); die;
          }

      } catch (Exception $e) {
           echo json_encode(["msg"=>"Message could not be sent.", "status"=>false, "data"=>$e->getMessage()]); die;
      }

  }

  public function salarySlipEmails(Request $request)
  {

    $mail = new PHPMailer(true);     // Passing `true` enables exceptions

    try {

        $salary_slip = $this->erpnextDB
                      ->table('tabSalary Slip AS tss')
                      ->select(DB::Raw('tss.*, tabEmployee.personal_email, tabEmployee.mother_name'))
                      ->join("tabEmployee", "tabEmployee.name", "=", "tss.employee")
                      ->where("tss.name", $request->id)
                      ->first();
      if( empty($salary_slip) ) {
        echo json_encode(["msg"=>"Salary Slip not found.", "status"=>false]);die;
      }

      if( empty($salary_slip->personal_email) ) {
        echo json_encode(["msg"=>"Please update your active Email-ID.", "status"=>false]);die;
      }


        // Email server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = getenv("MAIL_Host");             //  smtp host
        $mail->SMTPAuth = getenv("MAIL_SMTPAuth");
        $mail->Username = getenv("MAIL_Username");   //  sender username
        $mail->Password = getenv("MAIL_Password");       // sender password
        $mail->SMTPSecure = getenv("MAIL_SMTPSecure");                  // encryption - ssl/tls
        $mail->Port = getenv("MAIL_Port");                   // port - 587/465

        $mail->setFrom(getenv("MAIL_Username"), 'ERP Support Team');
        $mail->addAddress($salary_slip->personal_email);

        $mail->isHTML(true);

        $mail->Subject = "Salary Slip of ". date("F", strtotime($salary_slip->start_date)) . " " . date("Y", strtotime($salary_slip->start_date)) . " - " . $salary_slip->company;

        $mail->Body = view('emails.salary_slip', ["salary_slip"=>$salary_slip, ]);

        // echo view('emails.salary_slip', ["salary_slip"=>$salary_slip, ]);
        // die;


          if( !$mail->send() ) {
            echo json_encode(["msg"=>"Email not sent", "status"=>false, "data"=>$mail->ErrorInfo]);die;
          }

          else {
            echo json_encode(["msg"=>"Email sent successfully.", "status"=>true, "data"=>""]); die;
          }

      } catch (Exception $e) {
           echo json_encode(["msg"=>"Email could not be sent.", "status"=>false, "data"=>$e->getMessage()]); die;
      }

  }



  public function salarySlipPDF(Request $request)
  {

    // $mail = new PHPMailer(true);     // Passing `true` enables exceptions
    //
    // try {

        $salary_slip = $this->erpnextDB
                      ->table('tabSalary Slip AS tss')
                      ->select(DB::Raw('tss.*, tabEmployee.personal_email, tabEmployee.mother_name'))
                      ->join("tabEmployee", "tabEmployee.name", "=", "tss.employee")
                      ->where("tss.name", $request->id)
                      ->first();

      if( empty($salary_slip) ) {
        echo json_encode(["msg"=>"Salary Slip not found.", "status"=>false]);die;
      }

      // return view('pdf.salary_slip', ["salary_slip"=>$salary_slip]);
      $pdf = PDF::loadView('pdf.salary_slip', ["salary_slip"=>$salary_slip]);

      return $pdf->download('pdf_file.pdf');

  }




}
