<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ProductionController extends Controller
{

  public function __construct(Type $foo = null)
  {
    $this->erpnextDB = DB::connection('erpnext');
  }

  public function ordersList(Request $request){

    $title = 'Production Orders';

    $query = $this->erpnextDB
                ->table('tabProduction Order Track')
                ->select(DB::raw("po_number,
                                  customer,
                                  client_code,
                                  order_date,
                                  exp_delivery__date") )
                ->groupBy('po_number')
                ->orderBy('name','DESC');

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }

    $pd_orders_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['pd_orders_data'] = $pd_orders_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.production.orders.list', $data );
  }

  public function ordersDetails(Request $request){

    $title = 'Production Order Details';

    $query = $this->erpnextDB
                ->table('tabProduction Order Track')
                ->select(DB::raw("po_number,
                                  customer,
                                  client_code,
                                  order_date,
                                  exp_delivery__date") )
                ->groupBy('po_number')
                ->where('po_number', $request->po_number)
                ->orderBy('name','DESC');
   $order_data = $query->first();

    $query = $this->erpnextDB
                ->table('tabBag Order as bag_order')
                ->select(DB::raw("bag_order.po_number,
                                  bag_order.design_code,
                                  SUM(bag_order.final_bag_order_qty) AS total_order_qty,
                                  count(bag_order.design_code) AS total_bags,
                                  GROUP_CONCAT(bag_order.name) AS all_names
                                  ") )
                ->where('po_number', $request->po_number)
                ->groupBy('bag_order.design_code')
                ->orderBy('name','DESC');



    $order_bag_data = $query->get();

    foreach ($order_bag_data as $key => $value) {
      $all_names = explode(",", $value->all_names);

      $temp_data = [];
      for ($i=0; $i <count($all_names) ; $i++) {
        $temp_data[$i] = $query = $this->erpnextDB
                    ->table('tabProduction Workflow as pd_w')
                    ->select(DB::raw("pd_w.*,
                                      bag_order.final_bag_order_qty
                                      ") )
                    ->where('pd_w.parent', $all_names[$i])
                    ->leftJoin('tabBag Order as bag_order', "bag_order.name", "=", "pd_w.parent")
                    ->orderBy('pd_w.idx', 'DESC')
                    ->first();
      }

     $order_bag_data[$key]->pd_data = $temp_data;

    }

    $data['title'] = $title;
    $data['order_bag_data'] = $order_bag_data;
    $data['order_data'] = $order_data;

    // echo "<pre>";
    // print_r($order_bag_data);
    // die;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.production.orders.view', $data );
  }


}
