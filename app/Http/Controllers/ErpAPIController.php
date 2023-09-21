<?php

namespace App\Http\Controllers;

use App\Library\Helper;
use App\Models\erp\Stocks;
use Illuminate\Support\Facades\Http;
use App\Models\erp\SalesOrder;
use App\Models\erp\Attendance;
use App\Models\erp\AttendanceRecords;
use App\Models\essl\ESSLAttendence;
use App\Http\Controllers\ExportController;
use App\Models\erp\Employee;
use App\Models\erp\PurchaseItem;
use App\Models\erp\PurchaseOrder;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ErpAPIController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Stock Ladger Api
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function powerbilogin(){
        $data = [
                    'grant_type'    => 'password',
                    'resource'      => 'https://analysis.windows.net/powerbi/api',
                    'client_id'     => 'POWERBI_ADD_CLIENT_ID',
                    'client_secret' => 'POWERBI_ADD_CLIENT_SECRET',
                    'username'      => 'POWERBI_USER_NAME',
                    'password'      => 'POWERBI_PASSWORD',
                ];
        $header = [
            "Content-Type:application/x-www-form-urlencoded",
            "return-client-request-id:true",
        ];
        $url = 'https://login.microsoftonline.com/common/oauth2/token';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        dd($response);

     }

    public function StockLedger(Request $request)
    {
        if(!empty($request->show)){
            $pagination = $request->show;
          }else{
            $pagination = 10;
        }
        if (!empty($request->get('companyName')) || !empty($request->get('start_date')) || !empty($request->get('end_date'))) {
            $data = $request->all();
        }else {
            $data['start_date'] = Carbon::now()->subDays(30)->toDateString();
            $data['end_date'] = Carbon::now()->toDateString();
            // $data['companyName'] = 'Pinkcity Jewelhouse Private Ltd-Mahapura';
              $data['companyName'] = '';
            $data['ItemCode'] = '';
        }
        $type = 'stock';
        $query = Stocks::OrderBy('creation','DESC')->groupBy('item_code');
        //Filters By ItemCode
        if($data['ItemCode']){
            $query->where('item_code',$data['ItemCode']);
        }
        //Filters By Date
        if($data['start_date'] && $data['end_date']){
            $query->whereBetween('creation',[$data['start_date'], $data['end_date']]);
        }
        //Filters By Company
        if($data['companyName']){
            $query->where('company',$data['companyName']);
        }
        $stockdatas = $query->paginate($pagination);
        //dd($stockdatas);
       // $stockdatas = Helper::ErpnextStockLedger($data, $type);
        //dd($stockdatas);
        $title = "Stock Ledger";
        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.erpnext.stockladger', compact('title', 'stockdatas', 'data'));
    }

    /**
     * Show the application dashboard.
     * Purchase Order Api
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function PurchaseOrder(Request $request)
    {
        if(!empty($request->show)){
            $pagination = $request->show;
          }else{
            $pagination = 10;
        }
         if (!empty($request->get('companyName')) || !empty($request->get('start_date')) || !empty($request->get('end_date')) || !empty($request->get('suppliername'))) {
             $data = $request->all();
         } else {
            $data['start_date'] = Carbon::now()->subDays(30)->toDateString();
            $data['end_date'] = Carbon::now()->toDateString();
            $data['companyName'] = '';
            $data['suppliername'] = '';
            $data['status'] = '';
         }
        // $type = 'purchase';
        // $purchasedatas = Helper::ErpnextStockLedger($data, $type);
        $title = "Purchase Order";
        $suppliers = PurchaseOrder::GroupBy('supplier_name')->pluck('supplier_name');
        $status = PurchaseOrder::GroupBy('status')->pluck('status');

        // $query = PurchaseOrder::where('status','!=','To Receive and Bill')->where('status','!=','Cancelled')->where('status','!=','Closed')->where('status','!=','Completed')->where('status','!=','To Bill')->where('status','!=','To Receive');
        $query = PurchaseOrder::OrderBy('creation','DESC');
        //Query Set By Company Filters
        if($data['companyName']){
            $query->where('company',$data['companyName']);
        }
        //Query Set By Date Flters
        if($data['start_date'] && $data['end_date']){
            $query->whereBetween('creation',[$data['start_date'], $data['end_date']]);
        }
        //Query Set By Status
        if($data['status']){
            $query->where('status',$data['status']);
        }
        //Query Set By SupplerName Filters
        if($data['suppliername']){
            $query->where('supplier_name',$data['suppliername']);
        }
		$purchasedatas = $query->paginate($pagination);
        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.erpnext.purchaseorder', compact('title', 'purchasedatas', 'data','suppliers','status'));
    }

    /**
     * Show the application dashboard.
     * Sales Order Api
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function SalesOrder(Request $request)
    {
        if(!empty($request->show)){
            $pagination = $request->show;
          }else{
            $pagination = 10;
        }
        if (!empty($request->all())) {
            $data = $request->all();
        } else {
            $data['start_date'] = Carbon::now()->subDays(30)->toDateString();
            $data['end_date'] = Carbon::now()->toDateString();
            $data['companyName'] = '';
        }
        // $type = 'sales';
        //  $salesdatas = Helper::ErpnextStockLedger($data, $type);
        $title = "Sales Order";
        $query = SalesOrder::WhereDate('delivery_date','<=',Carbon::now())->where('delivery_status','Not Delivered');
        //Query Set By Company Filters
        if($data['companyName']){
            $query->where('company',$data['companyName']);
        }
        //Query Set By Date Flters
        if($data['start_date'] && $data['end_date']){
            $query->whereBetween('creation',[$data['start_date'], $data['end_date']]);
        }

        $salesdatas = $query->paginate($pagination);
        Helper::LoginIpandTime($request->getClientIp());
       // dd($salesdatas);
        return view('admin.erpnext.salesorder', compact('title', 'salesdatas', 'data'));
    }

    public function PurchaseRequest(Request $request)
    {
      $title = "Purchase Request Form";
      return view('admin.erpnext.purchaseform', compact('title'));
    }

    public function ItemMontering(Request $request)
    {
       // print_r(phpinfo());select * from [dbo].[DeviceLogs_1_2021]
       // exit;
        $tables = DB::connection('essl')->select('[DeviceLogs_1_2021]');
        dd($tables);
        foreach($tables as $table)
        {
        echo "<pre>";
        echo $table;
        }
        exit;

        if (!empty($request->get('start_date')) || !empty($request->get('end_date') || !empty($request->get('companyName')) || !empty($request->get('itemGroup')))) {
            $data = $request->all();
        } else {
            $data['start_date'] = Carbon::now()->subDays(30)->toDateString();
            $data['end_date'] = Carbon::now()->toDateString();
            $data['companyName'] = 'Pinkcity Jewelhouse Private Ltd-Mahapura';
            $data['ItemCode'] = '';
        }
        $start_date = Carbon::now()->subDays(30)->toDateString();

        $end_date = Carbon::now()->toDateString();

        //Stock Query Wise
        $stockquery = Stocks::OrderBy('creation','DESC')->Groupby('item_code');
        //Query Set By Company Filters
        if(!empty($request->get('companyName'))){
            $stockdatas =   $stockquery->where('company',$request->get('companyName'));
        }
        //Query Set By Company Filters
        if(!empty($request->get('companyName'))){
          $stockdatas =   $stockquery->where('company',$request->get('companyName'));
        }

        //Query Set By Date Flters
        if($data['start_date'] && $data['end_date']){
            $stockdatas =   $stockquery->whereBetween('creation',[$data['start_date'], $data['end_date']]);
        }

        $stockdatas = $stockquery->paginate();
        $title = 'All Stock Data';
        return view('admin.erpnext.erpmonitoring', compact('title', 'stockdatas','data'));

    }


    public function StockPurchaseOrder(Request $request,$code){
        $purchaseItem  = PurchaseItem::where('item_code',$code)->pluck('parent');
        $purchasedatas = PurchaseOrder::whereIn('name',$purchaseItem)->paginate('10');
        $title = 'All Purchase Order';
        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.erpnext.itempurcahseorder', compact('title', 'purchasedatas'));
    }

    public function AttendanceCheckin(Request $request){
        $title = 'All Checkin Checkout Data';
        // $recod = Attendance::where('employee','HR-EMP-PJHM-0197')->get();
        // dd($recod);
        $query = Attendance::OrderBy('time','DESC');

        //Flter By Employee Code
        if(!empty($request->employee_code)){
           $query->where('employee',$request->employee_code);
        }
        if(!empty($request->employee_name)){
            $query->where('employee_name', 'like', '%'.$request->employee_name.'%');
        }
        if(!empty($request->date)){
            $query->WhereDate('time',date('Y-m-d',strtotime($request->date)));
        }
        if(!empty($request->start_date) && !empty($request->end_date)){
            $query->whereBetween('time', [$request->start_date, $request->end_date]);
        }
        $attendnces = $query->paginate('10');
        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.erpnext.attendance-checkin-checkout',compact('title', 'attendnces'));
    }


    public function AttendanceRecord(Request $request){

        $title = 'Attendence Data';
        // $recod = AttendanceRecords::where('company','Pinkcity Jewelhouse Private Limited- Unit 1')->first();
        // dd($recod);

        if(!empty($request->show)){
          $pagination = $request->show;
        }else{
          $pagination = 10;
        }

        $query = AttendanceRecords::OrderBy('creation','DESC');
        //Flter By Employee Code
        if(!empty($request->employee_code)){
           $query->where('employee',$request->employee_code);
        }
        if(!empty($request->employee_name)){
            $query->where('employee_name', 'like', '%'.$request->employee_name.'%');
        }
        if(!empty($request->status)){
            $query->where('status',$request->status);
        }
        if(!empty($request->shift)){
            $query->where('shift',$request->shift);
        }
        if(!empty($request->company)){
            $query->where('company',$request->company);
        }
        if(!empty($request->start_date) && !empty($request->end_date)){
            $query->whereBetween('attendance_date', [$request->start_date, $request->end_date]);
        }
        $attendnces = $query->paginate($pagination);

        Helper::LoginIpandTime($request->getClientIp());
        return view('admin.erpnext.attendancedata',compact('title', 'attendnces'));
    }


    public function attendanceData(){
        ini_set('max_execution_time', '10000000');
        $responses = Http::get('http://192.168.2.21:8090/api/attendance');
        // $data = json_decode($responses);
        // dd($data);
        //$atendence = Attendance::get();
        //dd(count($atendence));
       // $atendence = Attendance::truncate();
       // exit;
        foreach(json_decode($responses) as $res){
               $empolyee = Employee::where('employee_number','!=',$res->userid)->first();
               if(!empty($empolyee)){
                    $dateformat = $res->logdate;
                    $timedate = substr($dateformat, 0, strpos($dateformat, '.'));
                    $date = date('Y-m-d H:i:s', strtotime($timedate));
                    if($res->userid == 'PM0054' && $res->userid == 'PM0100' && $res->userid == 'PM0261'){
                        $data = [
                            'employee_field_value' => $res->userid,
                            'log_type' => $res->c1,
                            'timestamp'   => $date.'.000000',
                            'device_id'   => $res->devicelogid
                        ];
                        $response = Helper::AttendnceCheckin($data);
                    }

                }
        }

        return redirect('/');
    }

    private function employee($user_id){
        $empolyee = Employee::where('employee_number',$user_id)->first();

        if(!empty($empolyee)){
            if(!empty($empolyee->default_shift)){
                $shift = $empolyee->default_shift;
            }else{
                $shift = '';
            }
         return ['name' =>$empolyee->name ,'employeename' => $empolyee->employee_name,'shift' => $shift];
        }else{
         return '';
        }
    }


    public function AttendnceRecordApi(){
        ini_set('max_execution_time', '10000000');
        $res = ESSLAttendence::get();
        dd($res);
        $responses = Http::get('http://192.168.2.21:8090/api/attendance');
        $records = json_decode($responses);

        $title = 'Api Record';

        return view('admin.erpnext.api-records',compact('title','records'));
    }



 public function AttendanceRecordEssl(Request $request){

        $filters = $request->all();


        $attendanceDB = DB::connection('Attendance');


        //dd(Carbon::now()->startOfMonth()->todatetimestring());
        // if(!empty($filters['start_date']) && !empty($filters['end_date'])){
        //   $data = ['startdate' => $filters['start_date'] .' '.'05:00:00','enddate' => $filters['end_date'] .' '.'11:59:00'];
        // }else{
        //   $data = ['startdate' => Carbon::now()->startOfMonth()->todatetimestring(),'enddate' => Carbon::now()->todatetimestring()];
        // }

        if(!empty($filters['start_date']) && !empty($filters['end_date'])){
          $auto_start_date = $filters['start_date'] .' '.'05:00:00';
          $auto_end_date =  $filters['end_date'] .' '.'23:59:00';
          $data = ['startdate' => $auto_start_date,'enddate' => $auto_end_date];
        }else{
          $auto_start_date = Carbon::now()->startOfMonth()->todatetimestring();
          $auto_end_date =  Carbon::now()->todatetimestring();
          $data = ['startdate' => $auto_start_date,'enddate' => $auto_end_date];
        }

       // dd($data);
        // ini_set('max_execution_time', '1000000');
        // $headers = array("X-Custom-Header: value");
        // $url = 'http://183.87.222.69:8090/api/attendance';
        // $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($curl);
        // $records  = json_decode($response);


          $attendanceDB = DB::connection('Attendance');

          $table_name1 = "";

          $start_date_month = date("n", strtotime($auto_start_date));
          $start_date_year = date("Y", strtotime($auto_start_date));

          $table_name1 = "DeviceLogs_".$start_date_month."_".$start_date_year;


          $records = $attendanceDB
                  ->table($table_name1)
                  ->select(DB::Raw("userid,
                                    min(logdate) as 'intime',
                                    case
                                      when max(logdate) = min(logdate) then null
                                      else max(logdate) end as 'outime',
                                    convert(Date,LogDate) as logdate"))
                  ->whereBetween("LogDate", [$auto_start_date, $auto_end_date])
                  ->groupBy(DB::Raw("userid, convert(Date,LogDate)"))
                  ->orderBy("userid", "ASC")
                  // ->orderBy("LogDate", "ASC")
                  ->get();

      // dd($records);
        $userid = [];
        $intime = [];
        foreach($records as $res){
            $timedate = substr($res->intime, 0, strpos($res->intime, '.'));
            $outdate = substr($res->outime, 0, strpos($res->outime, '.'));
            $userid [] = $res->userid;
            $intime [] = date('Y-m-d H:i:s',strtotime($timedate));
            $outtime [] = !empty($res->outime) ? date('Y-m-d H:i:s',strtotime($outdate)) : '';
        }
     //  exit;
        //Attendnce Filters
        if(!empty($request->show)){
            $pagination = $request->show;
        }else{
            $pagination = 10;
        }

        //$datacheck = Employee::first();
       // dd($outtime);
        $query = Employee::WhereIn('employee_number',$userid)->OrderBy('creation','DESC');

        //Flter By Employee Code
        if(!empty($request->employee_code)){
           $query->where('employee',$request->employee_code);
        }
        if(!empty($request->employee_name)){
             $query->where('employee_name', 'like', '%'.$request->employee_name.'%');
        }
        if(!empty($request->company)){
            $query->where('company',$request->company);
        }
        if(!empty($request->start_date) && !empty($request->end_date)){
            //$query->whereBetween('attendance_date', [$request->start_date, $request->end_date]);
        }

        $employeedata = $query->paginate($pagination);



     // excel code ----------------

        // if(!empty($request->show)){
        //     $pagination = $request->show;
        // }else{
        //     $pagination = 10;
        // }
        //
        //
        //
        //
        // $query = Employee::where('status','Active')->OrderBy('creation','DESC');
        //
        // //Flter By Employee Code
        // if(!empty($filters['employee_code'])){
        //    $query->where('employee',$filters['employee_code']);
        // }
        // if(!empty($filters['employee_name'])){
        //      $query->where('employee_name', 'like', '%'.$filters['employee_name'].'%');
        // }
        // if(!empty($filters['company'])){
        //     $query->where('company',$filters['company']);
        // }
        // if(!empty($filters['start_date']) && !empty($filters['end_date'])){
        //     //$query->whereBetween('attendance_date', [$this->request->start_date, $this->request->end_date]);
        // }
        //
        // $employeedata = $query->paginate($pagination);
        //
        // $userArray = [];
        //
        // foreach ($employeedata as $key => $value) {
        //   $userArray[] = "'".$value->attendance_device_id."'";
        // }
        //
        // $table_name1 = "";
        //
        // $start_date_month = date("n", strtotime($auto_start_date));
        // $start_date_year = date("Y", strtotime($auto_start_date));
        //
        // $table_name1 = "DeviceLogs_".$start_date_month."_".$start_date_year;
        //
        //
        // $records = $attendanceDB
        //         ->table($table_name1)
        //         ->select(DB::Raw("userid,
        //                           min(logdate) as 'intime',
        //                           case
        //                             when max(logdate) = min(logdate) then null
        //                             else max(logdate) end as 'outime',
        //                           convert(Date,LogDate) as logdate"))
        //         ->whereBetween("LogDate", [$auto_start_date, $auto_end_date])
        //         // ->where("userid", $userArray)
        //         ->whereRaw("userid IN ( " . implode(",",$userArray) . " )")
        //         ->groupBy(DB::Raw("userid, convert(Date,LogDate)"))
        //         ->orderBy("userid", "ASC")
        //         ->get();



        $title = 'Check-In/Out Detail ESSL';

        return view('admin.erpnext.api-records',compact('title','employeedata','records'));

    }


    /**
     * Employee Details Data
    */
    public function EmployeeDetails($slug){
        $records = Helper::CheckinData();
        $employee =  Employee::where('employee',$slug)->first();
        $title = 'Employee View';
        return view('admin.erpnext.employee-view',compact('employee','title','records'));
    }

}
