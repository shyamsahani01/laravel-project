<?php

namespace App\Exports;

use App\Models\erp\AttendanceRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\erp\Employee;
use Carbon\Carbon;
use DB;

class EsslDataExport implements FromView
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function view(): View
    {

        $filters = $this->request;

        //dd(Carbon::now()->startOfMonth()->todatetimestring());
        // if(!empty($filters['sdate']) && !empty($filters['edate'])){
        //   $data = ['startdate' => $filters['sdate'] .' '.'05:00:00','enddate' => $filters['edate'] .' '.'11:59:00'];
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


        //dd($data);
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

        $attendanceDB = DB::connection('Attendance');


        $query = Employee::where('status','Active')->OrderBy('creation','DESC');

        //Flter By Employee Code
        if(!empty($filters['employee_code'])){
           $query->where('employee',$filters['employee_code']);
        }
        if(!empty($filters['employee_name'])){
             $query->where('employee_name', 'like', '%'.$filters['employee_name'].'%');
        }
        if(!empty($filters['company'])){
            $query->where('company',$filters['company']);
        }
        if(!empty($filters['start_date']) && !empty($filters['end_date'])){
            //$query->whereBetween('attendance_date', [$this->request->start_date, $this->request->end_date]);
        }

        $employeedata = $query->get();

        $userArray = [];

        foreach ($employeedata as $key => $value) {
          $userArray[] = "'".$value->attendance_device_id."'";
        }

        // echo "<pre>";
        // print_r($userArray);
        // echo "<br>hi11</br>";



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
                // ->where("userid", $userArray)
                ->whereRaw("userid IN ( " . implode(",",$userArray) . " )")
                ->groupBy(DB::Raw("userid, convert(Date,LogDate)"))
                ->orderBy("userid", "ASC")
                ->get();


          // print_r($records);
          // echo "<br>hi22</br>";
          // die;




       // dd($attendnces);
        return view('exports.esslattendnce', ['response'=>$records]);
    }
}
