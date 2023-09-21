<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Exports\StockExport;
use App\Exports\AttendncesExport;
use Google\Cloud\Speech\SpeechClient;
use App\Exports\OverTimeExport;
use App\Exports\CheckinCheckoutExport;
use App\Models\erp\Employee;
use App\Exports\AttendncesMissingExport;
use App\Exports\AttendncesMissingINExport;
use App\Exports\EsslDataExport;
use App\Exports\EsslOvertimeDataExport;
use App\Exports\EsslLiveDataExport;
use Maatwebsite\Excel\HeadingRowImport;
use Session;
use Carbon\Carbon;
use File;

class ExportController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    * Export Stock Data
    */
    public function StocksExport()
    {
        return Excel::download(new StockExport, 'stocks-data.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    * Expoert Attendnce Data
    */
    public function AttendnceExport(Request $request){

        if($request->export_data == 'all'){
            return Excel::download(new AttendncesExport($request), 'attendnce-'.date('d-m-Y').'-'.time().'.xlsx');
        }elseif($request->export_data == 'out'){
            return Excel::download(new AttendncesMissingExport($request), 'missingattendnce-'.date('d-m-Y').'-'.time().'.xlsx');
        }elseif($request->export_data == 'in'){
            return Excel::download(new AttendncesMissingINExport($request), 'missingattendnceIN-'.date('d-m-Y').'-'.time().'.xlsx');
        }elseif($request->export_data == 'overtime'){

            return Excel::download(new OverTimeExport($request), 'overtime-'.date('d-m-Y').'-'.time().'.xlsx');
        }
    }

    /**
    * @return
    * Export OutMisingExport Data
    */
    public function OutMisingExport(Request $request){
        return Excel::download(new AttendncesMissingExport($request), 'missingattendnce-'.date('d-m-Y').'-'.time().'.xlsx');
    }

    /**
    * @return
    * Export INMisingExport Data
    */
    public function INMisingExport(Request $request){
        return Excel::download(new AttendncesMissingINExport($request), 'missingattendnceIN-'.date('d-m-Y').'-'.time().'.xlsx');
    }

    /**
    * @return
    * Export INMisingExport Data
    */
    public function OvertimeExport(Request $request){
        return Excel::download(new OverTimeExport($request), 'overtime-'.date('d-m-Y').'-'.time().'.xlsx');
    }

    /**
     * @return
     * Google Speech
     */

    public function GoogleSpeech(){
        $speech = new SpeechClient([
            'projectId' => 'my_project',
            'languageCode' => 'en-US'
        ]);


      //  $files = File::files(public_path());

        $files = File::allFiles(public_path('audio'));
       // dd($files);
        // Recognize the speech in an audio file.
        $results = $speech->recognize(
            fopen(public_path('audio') . '/file_example.mp3', 'r')
        );

        foreach ($results as $result) {
            echo $result->topAlternative()['transcript'] . "\n";
        }
        exit;

    }



    public function CheckInExport($employee){
        $data = Employee::where('employee',$employee)->first();
        return Excel::download(new CheckinCheckoutExport($data->employee_number), $data->employee_name.'-'.date('d-m-Y').'-'.time().'.xlsx');
    }


    public function EsslExport(Request $request){
         return Excel::download(new EsslDataExport($request->all()), 'CheckIn-'.date('d-m-Y').'-'.time().'.xlsx');
        // return response()->json(['success'=>'Data Import Sussfully.']);
    }

    public function AttendnceEsslExport(Request $request){
         $title = "Essl Export";
         return view('admin.erpnext.essl-export',compact('title'));
    }

    public function EsslExportData(Request $request){

        return Excel::download(new EsslLiveDataExport($request->all()), 'Essldata-'.date('d-m-Y').'-'.time().'.xlsx');
    }

    public function EsslExportView(Request $request){
         $title = "Essl OverTime Data Export";
         return view('admin.erpnext.essl-overtime-export',compact('title'));
    }

    public function EsslOvertimeExport(Request $request){

        return Excel::download(new EsslOvertimeDataExport($request->all()), 'EsslOvertimedata-'.date('d-m-Y').'-'.time().'.xlsx');
    }

}
