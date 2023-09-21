<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $title = 'Buying Reports';
        return view('admin.reports.index',compact('title'));
    }

     /**
     * Show the application dashboard.
     * Purchase Reports
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function PurchaseReport(){
        $title = 'Purchase Reports';
        return view('admin.reports.purchase_report',compact('title'));
    }

     /**
     * Show the application dashboard.
     * Sales Reports
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function SalesReport(){
        $title = 'Sales Reports';
        return view('admin.reports.sales_report',compact('title'));
    }

     /**
     * Show the application dashboard.
     * Stock Reports
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function StockReport(){
        $title = 'CRM Reports';
        return view('admin.reports.stock_reports',compact('title'));
    }

    /**
     * Show the application dashboard.
     * HR Reports
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function HrReport(){
        $title = 'HR Reports';
        return view('admin.reports.hr_reports',compact('title'));
    }

    
    public function HrReportInProcess(){
        $title = 'HR Reports';
        return view('admin.reports.hr_report_In_process',compact('title'));
    }
}
