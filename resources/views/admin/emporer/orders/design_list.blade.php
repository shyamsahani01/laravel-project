@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">

@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&order_start_date='.request()->order_start_date;
$str .= '&order_end_date='.request()->order_end_date;
$str .= '&customer_code='.request()->customer_code;
$str .= '&order_no='.request()->order_no;
$str .= '&expected_order_start_date='.request()->expected_order_start_date;
$str .= '&purchase_order_no='.request()->purchase_order_no;
$str .= '&company='.request()->company;
$str .= '&customer_code='.request()->customer_code;
$showurl = url("/emporer/orders-design/list?$str");
@endphp
<style>
    table td,th {
    padding: 8px !important;
}
</style>
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                        <form method="GET" id="filter_form" action="{{ url('/emporer/orders-design/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/orders-design/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Order Date - From</label>
                                      <input name="order_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Order Date - To</label>
                                      <input name="order_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Select Customer Code</label>
                                      <select name="customer_code" id="customer_code" class="form-control select2-lib-dropdown-customer_code "> <?php if(isset(request()->customer_code)) { echo  '
                                        <option value="'.request()->customer_code.'" Selected >'.request()->customer_code.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Select Company</label>
                                      <select name="company" class="form-control">
                                         <option value="">Select Company</option>
                                         <option value="PC" @if(request()->company == 'PC') Selected @endif>PC</option>
                                         <option value="PJ" @if(request()->company == 'PJ') Selected @endif>PJ</option>
                                         <option value="PJ2" @if(request()->company == 'PJ2') Selected @endif>PJ2</option>
                                      </select>
                                  </div>
                                  <!-- <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Select Customer Name</label>
                                      <select name="customer_name" id="customer_name" class="form-control select2-lib-dropdown-customer_name "> <?php if(isset(request()->customer_name)) { echo  '
                                        <option value="'.request()->customer_name.'" Selected >'.request()->customer_name.'</option>'; } ?>
                                      </select>
                                  </div> -->
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Order No.</label>
                                      <input name="order_no" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_no }}">
                                  </div>


                                </div>
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Expected Delivery Date - From</label>
                                      <input name="expected_order_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->expected_order_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Expected Delivery Date - To</label>
                                      <input name="expected_order_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->expected_order_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Purshase Order No.</label>
                                      <input name="purchase_order_no" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->purchase_order_no }}">
                                  </div>
                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body table-responsive">
                        <table id="design-table"  class="table table-striped table-bordered" style="">
                           <thead>
                              <tr style="text-align: center;">
                                <th>Button</th>
                                <th>S.NO.</th>
                                <th>Order Design S.NO.</th>
                                <th>Design Code</th>
                                <th>Suffix</th>
                                <th>Size</th>
                                <th>Order Qunatity</th>
                                <th>Product Qunatity</th>
                                <th>Balance Qunatity</th>
                                <th>Export Qunatity</th>
                                <th>FG Qunatity</th>
                                <th>Calculated Price</th>
                                <th>Sale Price</th>
                                <th>Customer Price</th>
                                <th>Karat</th>
                                <th>Production Sequence</th>
                                <th>Color</th>
                                <th style="min-width: 200px;">Production Instruction</th>
                                <th style="min-width: 200px;">Customer Instruction</th>
                                <th style="min-width: 200px;">Stamp Instruction</th>
                                <th style="min-width: 200px;">Size Instruction</th>
                                <th>Customer Code</th>
                                <th style="min-width: 125px;">Delivery Date</th>
                                <th>Product Sequence</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Order Export Date</th>
                                <th>User (Modified)</th>
                                <th style="min-width: 125px;">Date (Modified)</th>
                              </tr>
                           </thead>
                           <tbody>

                              @if (count($orders_design_details) > 0)
                              @php $count = 1 @endphp
                              @foreach($orders_design_details as $key => $data)
                                   @php $count++; @endphp
                                   <tr  style="text-align: center;" class="@if(($data->OdPrdQty - $data->OdExpQty)>0) table-danger @else table-success @endif">
                                     <td><button class="btn btn-info" id="design_id-{{ $count }}" onclick="getDesignBag('{{ $data->OdIdNo}}', '{{ $data->OdDmCd}}', {{ $count }}, this)"> Info </button></td>
                                     <td>{{ $orders_design_details->firstItem() +  $key }}</td>
                                     <td>{{ $data->OdSr  }}</td>
                                     <td><a href="/emporer/design/designDetails?design_code={{ $data->OdDmCd}}"  style="color: green; font-weight:bold">{{ $data->OdDmCd  }}</td>

                                     <td>{{ $data->OdSfx  }}</td>
                                     <td>{{ $data->OdDmSz  }}</td>
                                     <td>{{ $data->OdOrdQty  }}</td>
                                     <td>{{ $data->OdPrdQty  }}</td>
                                     <td>{{ ($data->OdPrdQty - $data->OdExpQty)  }}</td>
                                     <td>{{ $data->OdExpQty  }}</td>
                                     <td>{{ $data->OdFgQty  }}</td>
                                     <td>{{ round($data->OdCalcPrc, 4)  }}</td>
                                     <td>{{ round($data->OdSalPrc, 4)  }}</td>
                                     <td>{{ round($data->OdCstPrc, 4)  }}</td>
                                     <td>{{ $data->OdKt  }}</td>
                                     <td>{{ $data->OdPrdSeq  }}</td>
                                     <td>{{ $data->OdDmCol  }}</td>
                                     <td>{{ $data->OdDmPrdInst  }}</td>
                                     <td>{{ $data->OdCmPrdInst  }}</td>
                                     <td>{{ $data->OdCmStmpInst  }}</td>
                                     <td>{{ $data->OdSzInst  }}</td>
                                     <td>{{ $data->OdOmCmCd  }}</td>
                                     <td>{{ date("D, d-m-Y",strtotime($data->OdDelDt)) }}</td>
                                     <td>{{ $data->OdPrdSeq  }}</td>
                                     <td>{{ $data->order_no  }}</td>
                                     <td>{{ date('D, d-m-Y', strtotime($data->OmDt))   }}</td>
                                     <td>{{ date('D, d-m-Y', strtotime($data->OmExpDelDt))  }}</td>
                                     <td>{{ $data->ModUsr  }}</td>
                                     <td>{{ date("D, d-m-Y",strtotime($data->ModDt)) . ' ' . $data->ModTime }}</td>
                                    </tr>
                              @endforeach
                           @else
                             <tr>
                               <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                              </tr>
                           @endif
                           </tbody>
                        </table>



                         <div class="pagination pull-right">
                         {{ $orders_design_details->links('vendor.pagination.bootstrap-4') }}
                         </div>

                         <div class="btn-group">
                            <button type="button" onclick="changenumber(20)" class="btn btn-default btn-sm btn-paging @if(request()->show == 20 || empty(request()->show )) btn-info @endif " data-value="20">20</button>
                            <button type="button" onclick="changenumber(50)" class="btn btn-default btn-sm btn-paging @if(request()->show == 50) btn-info @endif " data-value="50">50</button>
                            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.emporer.emporer_script')



  <!-- confirm Modal -->
  <div class="modal fade bd-example-modal-lg" id="all_check_in_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="all_check_in_modal_label" style="font-weight: bold; color: black;">Bag No . : </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <table id="table" class="table-bordered table-striped table table-responsive" >
            <thead>
              <tr style="text-align: center;">
                <th>S.NO.</th>
                <th>Bag No. </th>
                <th style="min-width: 125px;">Design Code</th>
                <th>Open Quantity</th>
                <th style="min-width: 125px;">Open Date</th>
                <th>Open Location</th>
                <th>Bag Location</th>
                <th>Quantity</th>
                <th>Gross Weight</th>
                <!-- <th style="min-width: 125px;" >Received Date</th>
                <th>User (Modified)</th> -->
              </tr>
            </thead>
            <tbody id="all_check_in_table_body">
              <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
              </tr>
          </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>




  <script>

  function getDesignBag(OdIdNo, design_no, series, this_var) {
    $("#all_check_in_modal_label").html("Design No . - " + design_no)
    $("#all_check_in_table_body").html("")


         $.ajax({
               url: '{{  url("/emporer/get-order-design-bag-details") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "get",
               data: { "OdIdNo": OdIdNo },
               dataType: "json",
               beforeSend: function (obj) {
                 $('#loader').removeClass('hidden')
               },
               success: function(obj){
                 console.log(obj)
                 $('#loader').addClass('hidden')
                  if(obj.status) {
                     $("#all_check_in_table_body").html(obj.html_data)
                     $("#all_check_in_modal").modal("show")

                  }else {
                     alert(obj.msg)
                  }


               },
               error: function(obj){
                 $('#loader').addClass('hidden')
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });

  }


  </script>


<script>

$(function() {
  $('#design-table').DataTable( {
    ordering: true,
    dom: 'Bfrtip',
    "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],     // page length options
    buttons: [
      {
        extend: 'excel',
        text: 'EXCEL',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'design_details_' + n;
            }
      },
      {
        extend: 'csv',
        text: 'CSV',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'design_details_' + n;
            }
      },
      // {
      //   extend: 'pdf',
      //   text: 'PDF',
      //   filename: function(){
      //           var d = new Date();
      //           var n = d.getTime();
      //           return 'design_details_' + n;
      //       }
      // },
      'copy', 'pageLength']
  } );
});

</script>

<style>
.dt-buttons.btn-group {
  margin-bottom: -50px;
}
</style>


<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}


function customer_code_select2() {
    $(".select2-lib-dropdown-customer_code").select2({
      placeholder: "Customer Code",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-customer_code',
          }
          return query;
        },
        dataType: 'json',
        processResults: function (data) {
            return data;
        }
      }
    })
}

function customer_name_select2() {
    $(".select2-lib-dropdown-customer_name").select2({
      placeholder: "Customer Name",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-customer_name',
          }
          return query;
        },
        dataType: 'json',
        processResults: function (data) {
            return data;
        }
      }
    })
}


$(document).ready(function(){
  customer_code_select2();
  customer_name_select2();
});


</script>

@endsection
