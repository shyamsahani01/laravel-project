<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\erp\Attendance;
use App\Models\erp\AttendanceRecords;
use App\Library\Helper;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function index(){
        ini_set('max_execution_time', '1000000');
        $headers = array("X-Custom-Header: value");
        $url = 'http://192.168.2.21:8090/api/attendance';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_POSTFIELDS,"startdate=2021-12-09 07:00:00.000&enddate=2021-12-09 23:59:00.000");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $data = json_decode($response);
        return response()->json($data, 200);
    }

    public function deleteAttendnce(Request $request){
       //$delete = Attendance::whereBetween('attendance_date',[$request->startdate,$request->enddate])->delete();
       //dd($delete);
       if(empty($request->startdate)){
         echo "Start Date Is Required For Delete Entry";
         exit;
       }
       if(empty($request->enddate)){
         echo "End Date Is Required For Delete Entry";
         exit;
       } 
      
       $date = Attendance::whereDate('time',[$request->startdate,$request->enddate])->count();
       dd($date);
       echo "Record Deleted Successfully";
    }

    public function dateAttendnce(Request $request){
        
     
        if(empty($request->startdate)){
            echo "Start Date Is Required For Delete Entry";
            exit;
        }
        if(empty($request->enddate)){
            echo "End Date Is Required For Delete Entry";
            exit;
        } 
       
        ini_set('max_execution_time', '1000000');
        $headers = array("X-Custom-Header: value");
        $data = ['startdate' => $request->startdate.' 00:01:00.000' ,'enddate' => $request->enddate.' 23:59:00.000'];
        $url = 'http://183.87.222.69:8090/api/attendance';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl); 
       
        foreach(json_decode($response) as $key =>$res){
                 $hours = 0;
                if(!empty($res->outime) && !empty($res->intime)){
                    $dtToronto = Carbon::create($res->intime);
                    $dtVancouver = Carbon::create($res->outime);  
                    $hours = $dtVancouver->diffInHours($dtToronto);       
                }
                if(!empty($res->intime)){
                    $timedate = substr($res->intime, 0, strpos($res->intime, '.'));
                    $date = date('Y-m-d H:i:s', strtotime($timedate)); 
                    $deviceidin = mt_rand(100000, 999999);
                    $datain = [
                                            'employee_field_value' => $res->userid,
                                            'log_type' => 'IN',
                                            'timestamp'   => $date.'.000000',
                                            'device_id'   => $deviceidin
                    ];
                    $response = Helper::AttendnceCheckin($datain);
                }

                if(!empty($res->outime) && $hours > 1){
                    $outimedate = substr($res->outime, 0, strpos($res->outime, '.'));
                    $oudate = date('Y-m-d H:i:s', strtotime($outimedate)); 
                    $deviceidout = mt_rand(100000, 999999);
                    $dataout = [
                        'employee_field_value' => $res->userid,
                        'log_type' => 'OUT',
                        'timestamp'   => $oudate.'.000000',
                        'device_id'   => $deviceidout
                    ];
                    $response = Helper::AttendnceCheckin($dataout);
                } 
        }
        
        echo "Record Inserted Successfully";
    }
}
