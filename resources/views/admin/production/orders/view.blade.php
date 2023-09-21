@extends('admin.layout.app')
@section('content')
<div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                <div class="card">
                  <div class="card-header card-header-primary" style="background-color: white;">

                      <div class="row">
                          <div class="col-md-6">
                            <h4 class="card-title " style="font-weight: 700;color: black;font-size: 1.25rem;">{{$title}}</h4>

                          </div>
                      </div>

                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12 col-sm-12  form-group">

                        <!-- <div class="col-md-12 col-sm-12  form-group">
                          <label for="staticEmail" class="col-sm-3 col-form-label" style="color: black;font-weight: bold;">Order No.</label>
                          <div class="col-sm-9">
                            <input type="text" name="po_number" class="form-control-plaintext" value="@if(isset($order_data->po_number)){{ $order_data->po_number }}@endif">
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12  form-group">
                          <label for="staticEmail" class="col-sm-3 col-form-label" style="color: black;font-weight: bold;">Client Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="customer" class="form-control-plaintext" value="@if(isset($order_data->customer)){{ $order_data->customer }}@endif">
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12  form-group">
                          <label for="staticEmail" class="col-sm-3 col-form-label" style="color: black;font-weight: bold;">Client Code</label>
                          <div class="col-sm-9">
                            <input type="text" name="client_code" class="form-control-plaintext" value="@if(isset($order_data->client_code)){{ $order_data->client_code }}@endif">
                          </div>
                        </div> -->

                      </div>

                    </div>

                    <div class=" ">

                      <?php

                        $all_dept = [
                          "PCAD"=>["total"=>0, "total_bag_qty"=>0],
                          "PBOM"=>["total"=>0, "total_bag_qty"=>0],
                          "PPLN"=>["total"=>0, "total_bag_qty"=>0],
                          "PWAX"=>["total"=>0, "total_bag_qty"=>0],
                          "PWXT"=>["total"=>0, "total_bag_qty"=>0],
                          "PCAS"=>["total"=>0, "total_bag_qty"=>0],
                          "PINV"=>["total"=>0, "total_bag_qty"=>0],
                          "PSTN"=>["total"=>0, "total_bag_qty"=>0],
                          "PDIA"=>["total"=>0, "total_bag_qty"=>0],
                          "Cell1"=>["total"=>0, "total_bag_qty"=>0],
                          "Cell2"=>["total"=>0, "total_bag_qty"=>0],
                          "Cell3"=>["total"=>0, "total_bag_qty"=>0],
                          "Cell4"=>["total"=>0, "total_bag_qty"=>0],
                          "Cell5"=>["total"=>0, "total_bag_qty"=>0],
                          "GCL1"=>["total"=>0, "total_bag_qty"=>0],
                          "GCL2"=>["total"=>0, "total_bag_qty"=>0],
                          "PGMF"=>["total"=>0, "total_bag_qty"=>0],
                          "PMF"=>["total"=>0, "total_bag_qty"=>0],
                          "FAS"=>["total"=>0, "total_bag_qty"=>0],
                          "PFIL"=>["total"=>0, "total_bag_qty"=>0],
                          "PSET"=>["total"=>0, "total_bag_qty"=>0],
                          "PPOL"=>["total"=>0, "total_bag_qty"=>0],
                          "PFQC"=>["total"=>0, "total_bag_qty"=>0],
                          "PPRP"=>["total"=>0, "total_bag_qty"=>0],
                          "PFG"=>["total"=>0, "total_bag_qty"=>0],
                          "PGOP"=>["total"=>0, "total_bag_qty"=>0],
                        ];

                        $total_data = $all_dept;
                        $total_order_qty = 0;
                        $total_bags = 0;

                      ?>

                      <table id="datatable" class="table table-bordered table-responsive" style="width:100%">
                        <thead>
                          <tr>
                            <th colspan="3">Order No: @if(isset($order_data->po_number)){{ $order_data->po_number }}@endif</th>
                            <th colspan="3">Client Code: @if(isset($order_data->client_code)){{ $order_data->client_code }}@endif</th>
                            <th colspan="5">Client Name: @if(isset($order_data->customer)){{ $order_data->customer }}@endif</th>
                          </tr>
                          <tr style="text-align:center;">
                              <th>S.No.</th>
                              <th>Design No.</th>
                              <th>Order Quantity</th>
                              <th>Total Bag</th>
                              @foreach($all_dept as $k => $d)
                                <th>{{ $k }}</th>
                              @endforeach
                          </tr>
                        </thead>
                        <tbody>
                        @if(!empty($order_bag_data))
                          @php $count = 0; @endphp
                            @foreach($order_bag_data as $key => $data)

                            <?php

                            // echo "<pre>";
                            // print_r($all_dept);

                              $all_dept = [
                                "PCAD"=>["total"=>0, "total_bag_qty"=>0],
                                "PBOM"=>["total"=>0, "total_bag_qty"=>0],
                                "PPLN"=>["total"=>0, "total_bag_qty"=>0],
                                "PWAX"=>["total"=>0, "total_bag_qty"=>0],
                                "PWXT"=>["total"=>0, "total_bag_qty"=>0],
                                "PCAS"=>["total"=>0, "total_bag_qty"=>0],
                                "PINV"=>["total"=>0, "total_bag_qty"=>0],
                                "PSTN"=>["total"=>0, "total_bag_qty"=>0],
                                "PDIA"=>["total"=>0, "total_bag_qty"=>0],
                                "Cell1"=>["total"=>0, "total_bag_qty"=>0],
                                "Cell2"=>["total"=>0, "total_bag_qty"=>0],
                                "Cell3"=>["total"=>0, "total_bag_qty"=>0],
                                "Cell4"=>["total"=>0, "total_bag_qty"=>0],
                                "Cell5"=>["total"=>0, "total_bag_qty"=>0],
                                "GCL1"=>["total"=>0, "total_bag_qty"=>0],
                                "GCL2"=>["total"=>0, "total_bag_qty"=>0],
                                "PGMF"=>["total"=>0, "total_bag_qty"=>0],
                                "PMF"=>["total"=>0, "total_bag_qty"=>0],
                                "FAS"=>["total"=>0, "total_bag_qty"=>0],
                                "PFIL"=>["total"=>0, "total_bag_qty"=>0],
                                "PSET"=>["total"=>0, "total_bag_qty"=>0],
                                "PPOL"=>["total"=>0, "total_bag_qty"=>0],
                                "PFQC"=>["total"=>0, "total_bag_qty"=>0],
                                "PPRP"=>["total"=>0, "total_bag_qty"=>0],
                                "PFG"=>["total"=>0, "total_bag_qty"=>0],
                                "PGOP"=>["total"=>0, "total_bag_qty"=>0],
                              ];

                              $total_order_qty = $total_order_qty + $data->total_order_qty;
                              $total_bags = $total_bags + $data->total_bags;
                              $pd_data = $data->pd_data;

                              foreach ($pd_data as $key2 => $value2) {
                                if(isset($all_dept[$value2->to_dept])) {
                                  $all_dept[$value2->to_dept]['total'] = $all_dept[$value2->to_dept]['total'] + 1;
                                  $all_dept[$value2->to_dept]['total_bag_qty'] = $all_dept[$value2->to_dept]['total_bag_qty'] + $value2->final_bag_order_qty;
                                  $total_data[$value2->to_dept]['total'] = $total_data[$value2->to_dept]['total'] + 1;
                                  $total_data[$value2->to_dept]['total_bag_qty'] = $total_data[$value2->to_dept]['total_bag_qty'] + $value2->final_bag_order_qty;
                                }
                              }

                              // print_r($data->design_code);
                              // print_r($all_dept);
                              // print_r($data->pd_data);
                              // die;

                            ?>
                            <tr style="text-align: center;">
                                <td>{{ ++$count }}</td>
                                <td>{{ $data->design_code }}</td>
                                <td>{{ round($data->total_order_qty) }}</td>
                                <!-- <td>{{ $data->all_names }}</td> -->
                                <td>{{ $data->total_bags }}</td>
                                @foreach( $all_dept as $k2 => $d2 )
                                  <th>@if($d2['total'] >  0)
                                    {{ $d2['total']  }}
                                    <br>({{ $d2['total_bag_qty']  }})
                                    @endif
                                  </th>
                                @endforeach
                            </tr>
                            @endforeach
                        @endif

                          <tr style="text-align: center;">
                              <td></td>
                              <td style="font-weight: bold;">Grand Total</td>
                              <td style="font-weight: bold;" style="font-weight: bold;">{{ round($total_order_qty) }}</td>
                              <td style="font-weight: bold;">{{ $total_bags }}</td>
                              @foreach( $total_data as $k2 => $d2 )
                              <th>@if($d2['total'] >  0)
                                {{ $d2['total']  }}
                                <br>({{ $d2['total_bag_qty']  }})
                                @endif
                              </th>
                              @endforeach
                          </tr>

                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div>
                          <ul style="list-style:none;color: black;">
                            <li style="display:inline;margin-right: 22px;font-weight: bold;">PPLN -</li>Planning Location<br>
                            <li style="display:inline;margin-right: 22px;font-weight: bold;">PCAS -</li>Casting Location<br>
                            <li style="display:inline;margin-right: 22px;font-weight: bold;">CEL1 -</li>Cell 1 Location<br>
                            <li style="display:inline;margin-right: 10px;font-weight: bold;">PEFOM -</li>ElectroFoaming<br>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <ul style="list-style:none;color: black;">
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PDIA -</li>Diamond Location<br>
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PINV -</li>Centrel Location<br>
                          <li style="display:inline;margin-right: 12px;font-weight: bold;">CELL3 -</li>Cell 3 Location<br>
                          <li style="display:inline;margin-right: 18px;font-weight: bold;">PFQC -</li>Final QC Location<br>
                        </ul>
                      </div>
                      <div class="col-md-3">
                        <ul style="list-style:none;color: black;">
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PWAX -</li>Waxing Location<br>
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PSTN -</li>Stone Location<br>
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">GCL1 -</li>Gold Cell 1<br>
                          <li style="display:inline;margin-right: 10px;font-weight: bold;">PFG -</li>Fg Location for Bag<br>
                        </ul>
                      </div>
                      <div class="col-md-3">
                        <ul style="list-style:none;color: black;">
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PWXT -</li>Wax Setting Location<br>
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">PFIL -</li>Filling Location<br>
                          <li style="display:inline;margin-right: 22px;font-weight: bold;">GCL2 -</li>Gold Cell 2<br>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>


  @endsection
