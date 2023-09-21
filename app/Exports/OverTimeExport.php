<?php

namespace App\Exports;

use App\Models\erp\AttendanceRecords;
use App\Models\erp\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OverTimeExport implements FromView
{
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        
        $query = AttendanceRecords::select('employee','employee_name','status','company','department','shift','attendance_date')->OrderBy('creation','DESC');
        //Flter By Employee Code 
        if(!empty($this->request->employee_code)){ 
            $query->where('employee',$this->request->employee_code);
         }
         if(!empty($this->request->employee_name)){ 
             $query->where('employee_name', 'like', '%'.$this->request->employee_name.'%');
         }
         if(!empty($this->request->status)){ 
             $query->where('status',$this->request->status);
         }
         if(!empty($this->request->shift)){
             $query->where('shift',$this->request->shift);
         }
         if(!empty($this->request->company)){
            $query->where('company',$this->request->company);
         }
         if(!empty($this->request->start_date) && !empty($this->request->end_date)){ 
            $query->whereBetween('attendance_date', [$this->request->start_date, $this->request->end_date]);
         }
        $data = $query->get();
      
        return view('exports.overtime-attendnce', ['attendncedata' => $data,'startdate'=>date('Y-m-d',(strtotime($this->request->start_date))),'enddate'=>date('Y-m-d',(strtotime($this->request->end_date)))]);
    }
}