<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\erp\Attendance;
use App\Library\Helper;
use App\Models\erp\Employee;
use Carbon\Carbon;
use DB;
use Str;
use Illuminate\Support\Facades\Http;

class EsslErp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Essl:Erp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    //    $atendence = new Attendance();
    //    $atendence->name = 'assign34thu';
    //    $atendence->creation = "2021-12-04 10:02:10.714393";
    //    $atendence->modified = "2021-12-04 9:02:10.714345";
    //    $atendence->modified_by = "yudhbir.singh@atelierpinkcity.com";
    //    $atendence->owner      = "yudhbir.singh@atelierpinkcity.com";
    //    $atendence->docstatus  = 0;
    //    $atendence->parent     = "Sofine Jewelry";
    //    $atendence->parentfield = "sales_team";
    //    $atendence->parenttype = "Customer";
    //    $atendence->idx         = 1;
    //    $atendence->sales_person = "Brajesh Pandey";
    //    $atendence->contact_no   = null;
    //    $atendence->allocated_percentage = "100.000000";
    //    $atendence->allocated_amount     = "0.000000";
    //    $atendence->commission_rate      = null;
    //    $atendence->incentives           = "0.000000";
    //    $atendence->save();
    //    dd($atendence);

        // $check = Attendance::WhereDate('time',['2021-12-20','2021-12-20'])->delete();
        // dd($check);
      // $userids = ['PC0176','PC0175','PC0254'];
      //  $autoattendnce = Helper::AutoAttendnceCheckin($userids);    
      // dd($autoattendnce);    
        ini_set('max_execution_time', '1000000');
        $headers = array("X-Custom-Header: value");
        $data = ['startdate' => Carbon::now()->toDateString() .' '.'00:01:00.000' ,'enddate' => Carbon::now()->toDateString() .' '.'23:59:00.000'];
       
        $url = 'http://183.87.222.69:8090/api/attendance';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl); 

        $nowtime = Carbon::now()->toTimeString();
        foreach(json_decode($response) as $key =>$res){
                $hours = 0;
                if(!empty($res->outime) && !empty($res->intime)){
                    $dtToronto = Carbon::create($res->intime);
                    $dtVancouver = Carbon::create($res->outime);  
                    $hours = $dtVancouver->diffInHours($dtToronto);       
                }
                if('16:30:00' > $nowtime){
                   
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
                }else{
                    $check = Attendance::WhereDate('time',[Carbon::now()->toDateString(),Carbon::now()->toDateString()])->count();
                   
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

                    if(!empty($res->outime)){
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
            // }
        }
        exit;
        // if('14:00:00' > $nowtime){
        //   echo "Morning Attendance Data Get Sussfully";
        // }else{
        //   echo "Final Attendance Data Get Sussfully"; 
        // }
        // return 1;
    }


    private function employee($user_id){
        $empolyee = Employee::where('employee_number',$user_id)->first();
        if(!empty($empolyee)){
         return ['name' =>$empolyee->name ,'employeename' => $empolyee->employee_name];
        }else{
         return '';
        } 
    }
}
