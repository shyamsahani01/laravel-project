<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class EmployeeCheckINExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
    }

    public function view(): View
    {
      $query = DB::table('attendance')
                  ->orderBy('id','DESC');

      if(!empty($this->request->employee_name)){
          $query->where('emp_name', 'like', '%' . $this->request->employee_name. '%');
      }

      if(!empty($this->request->company)){
          $query->where('company', $request->company);
      }

      if(!empty($request->start_date)){
          $query->whereDate('in_time', ">=", $this->request->start_date);
          $query->orderBy('in_time', "ASC");
      }
      else {
        $query->orderBy('in_time', "DESC");
        $auto_start_date = date('Y-m-d');
        $query->whereDate('in_time', $auto_start_date);
        // $this->request->start_date = $auto_start_date;
      }

      if(!empty($this->request->end_date)){
          $query->whereDate('in_time', "<=", $this->request->end_date);
      }

      $query->limit(1000);


      // if(!empty($request->show)){
      //   $pagination = $request->show;
      // }else{
      //   $pagination = 10;
      // }

      $check_in_data = $query->get();

      $data['check_in_data'] = $check_in_data;

      return view('exports.check_in_local', $data);
    }
}
