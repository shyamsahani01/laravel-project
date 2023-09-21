<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class SalaryComponentExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
        $this->data = $data;
    }

    public function view(): View
    {

      return view('exports.salary_component', $this->data);
    }
}
