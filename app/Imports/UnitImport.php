<?php

namespace App\Imports;
use App\Models\erp\UnitData;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Carbon\Carbon;
use DB;

class UnitImport implements ToModel, WithHeadingRow,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    
    //  $data =  DB::connection('erpnext')->statement('ALTER TABLE `production_cost_report` ADD `date` TIMESTAMP NULL DEFAULT NULL AFTER `id`');
   
         $data = UnitData::get();
        dd($data);
        //dd($row);
        // Schema::connection('erpnext')->create('production_cost_report', function($table)
        // {
        //     $table->increments('id');
        //     $table->string('gold_proud_worker_today')->nullable();
        //     $table->string('gold_proud_worker_today_salary')->nullable();
        //     $table->string('gold_gw_amount')->nullable();
        //     $table->string('gold_total_amount')->nullable();
        //     $table->string('gold_qty_pic')->nullable();
        //     $table->string('gold_wt_gms')->nullable();
        //     $table->string('gold_rs_per_pic')->nullable();
        //     $table->string('gold_rs_per_gm')->nullable();
        //     $table->string('sliver_proud_worker_today')->nullable();
        //     $table->string('sliver_proud_worker_today_salary')->nullable();
        //     $table->string('sliver_gw_amount')->nullable();
        //     $table->string('sliver_total_amount')->nullable();
        //     $table->string('sliver_qty_pic')->nullable();
        //     $table->string('sliver_wt_gms')->nullable();
        //     $table->string('sliver_rs_per_pic')->nullable();
        //     $table->string('sliver_rs_per_gm')->nullable();
        //     $table->string('total_fg_gold_sliver_gms')->nullable();
        //     $table->string('manpower_cost')->nullable();
        //     $table->string('gw_cost')->nullable();
        //     $table->string('total_manpower_amount')->nullable();
        //     $table->string('total_manpower_amount_per_gm')->nullable();
        //     $table->string('total_export_till_today_usd')->nullable();
        //     $table->string('gold_fg_amount_per_pic')->nullable();
        //     $table->string('sliver_fg_amount_per_pic')->nullable();
        //     $table->string('total_fg_amount')->nullable();
        //     $table->string('total_expenses_manpower')->nullable();
        //     $table->string('of_manpower_expenses_againest_fg_value')->nullable();
        //     $table->string('total_expenses_of_gold')->nullable();
        //     $table->string('of_manpower_expenses_of_gold_againest_fg_value')->nullable();
        //     $table->string('total_expenses_of_sliver')->nullable();
        //     $table->string('of_manpower_expenses_of_sliver_againest_fg_value')->nullable();
        //     $table->timestamps();
        // });
        
        return new UnitData([
            //'id'  => '1',
            'date'   => !empty($row['date']) ? date('Y-m-d H:i:s',strtotime($row['date'])) : '',
            'gold_proud_worker_today'   => $row['gold_no_of_prod_workers_present_today'],
            'gold_proud_worker_today_salary'   => $row['gold_todays_salary_of_present_prod_workers'],
            'gold_gw_amount'   => $row['gold_gw_amount'],
            'gold_total_amount'   => $row['gold_total_amount'],
            'gold_qty_pic'   => $row['gold_qty_pcs'],
            'gold_wt_gms'   => $row['gold_wt_gms'],
            'gold_rs_per_pic'   => $row['gold_rs_per_pc'],
            'gold_rs_per_gm'   => $row['gold_rs_per_gm'],
            'sliver_proud_worker_today'   => $row['no_of_prod_workers_present_today'],
            'sliver_proud_worker_today_salary'   => $row['todays_salary_of_present_prod_workers'],
            'sliver_gw_amount'   => $row['gw_amount'],
            'sliver_total_amount'   => $row['total_amount'],
            'sliver_qty_pic'   => $row['qty_pcs'],
            'sliver_wt_gms'   => $row['wt_gms'],
            'sliver_rs_per_pic'   => $row['rs_per_pc'],
            'sliver_rs_per_gm'   => $row['rs_per_gm'],
            'total_fg_gold_sliver_gms'   => $row['total_fg_gold_silver_gms'],
            'manpower_cost'   => $row['manpower_cost'],
            'gw_cost'   => $row['gw_cost'],
            'total_manpower_amount'   => $row['total_manpower_amount'],
            'total_manpower_amount_per_gm'   => $row['total_manpower_per_gm'],
            'total_export_till_today_usd'   => $row['total_export_till_today_usd'],
            'gold_fg_amount_per_pic'   => $row['gold_fg_amount_at_rs_6000_per_pc'],
            'sliver_fg_amount_per_pic'   => $row['silver_fg_amount_at_rs_800_per_pc'],
            'total_fg_amount'   => $row['total_fg_amount'],
            'total_expenses_manpower'   => $row['total_expenses_on_manpower'],
            'of_manpower_expenses_againest_fg_value'   => $row['of_manpower_expenses_against_fg_value'],
            'total_expenses_of_gold'   => $row['total_expenses_of_gold_at_35_of_total_expenses'],
            'of_manpower_expenses_of_gold_againest_fg_value'   => $row['of_manpower_expenses_of_gold_against_fg_value'],
            'total_expenses_of_sliver'   => $row['total_expenses_of_silver_at_65_of_total_expenses'],
            'of_manpower_expenses_of_sliver_againest_fg_value'   => $row['of_manpower_expenses_of_silver_against_fg_value']
        ]);
        
    }


 
}
