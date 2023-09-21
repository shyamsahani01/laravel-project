<?php

namespace App\Exports;

use App\Models\erp\AttendanceRecords;
use App\Models\erp\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use DB;

class EsslOvertimeDataExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {


        $filters = ['start_date' => $this->request['start_date'],'end_date'=> $this->request['end_date']];

		// if(!empty($filters['start_date']) && !empty($filters['end_date'])){
		// 	$data = ['startdate' => $filters['start_date'],'enddate' => $filters['end_date']];
		//   }else{
		// 	$data = ['startdate' => Carbon::now()->startOfMonth()->todatetimestring(),'enddate' => Carbon::now()->todatetimestring()];
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
  
  

		// ini_set('max_execution_time', '1000000');
		// $headers = array("X-Custom-Header: value");
		// $url = 'http://183.87.222.69:8090/api/attendancexport';
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


		$attendanceData = $attendanceDB
						// ->table($table_name1)
						->table("RELYON_ATT")
						// ->select(DB::Raw("$table_name1.*, Employees.EmployeeName"))
						// ->join("Employees", "Employees.EmployeeCode", "=", "UserId")
						->whereBetween("attendancedate", [$auto_start_date, $auto_end_date])
						->orderBy("EMPCODE", "ASC")
						->get();



    // let  alldata = await  pool.request().query(
        // "SELECT * FROM [etimetracklite1].[dbo].[RELYON_ATT]
        // where attendancedate between '"+ startdate + "' and '"+ enddate + "' order by EMPCODE");



        //dd($records);



        return view('exports.esslovertime-export', ['response' => $attendanceData]);
    }
}
