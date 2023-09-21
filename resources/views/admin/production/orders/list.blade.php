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
                    <div class=" ">
                      <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                          <tr style="text-align:center;">
                              <th>S.No.</th>
                              <th>Order No.</th>
                              <th>Client Name</th>
                              <th>Client Code</th>
                              <th>Order Date</th>
                              <!-- <th>Action</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        @if(!empty($pd_orders_data))
                            @foreach($pd_orders_data as $key => $data)

                            <tr style="text-align: center;">
                                <td>{{ $pd_orders_data->firstItem() +  $key  }}</td>
                                <td><a href="{{ url( '/production/pd-orders/view?po_number='. $data->po_number ) }}" target="_blank" style="color: green;">{{ $data->po_number }}</a></td>
                                <td>{{ $data->customer }}</td>
                                <td>{{ $data->client_code }}</td>
                                <td>{{ $data->order_date }}</td>
                                <!-- <td style="padding: 0px !important;text-align: center;">
                                   <a href="{{ url( '/production/pd-orders/view?po_number='. $data->po_number ) }}" title="View" class="btn btn-info btn_space" style="color: white;" ><i class="fa fa-eye"></i></a>
                                </td> -->

                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                      </table>
                      <div class="btn-group">
                          <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                          <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                          <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                      </div>
                      <div class="pagination pull-right">
                          {{ $pd_orders_data->links('vendor.pagination.bootstrap-4') }}
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
