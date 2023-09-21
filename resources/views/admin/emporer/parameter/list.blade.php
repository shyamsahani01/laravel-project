@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&type='.request()->type;
$str .= '&category='.request()->category;
$str .= '&sub_category='.request()->sub_category;
$str .= '&description='.request()->description;
$str .= '&status='.request()->status;
$showurl = url("/emporer/parameter/list?$str");
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/parameter/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/parameter/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Parameter Type</label>
                                      <select name="type" id="type" class="form-control select2-lib-dropdown-parameter_type "> <?php if(isset(request()->type)) { echo  '
                                        <option value="'.request()->type.'" Selected >'.request()->type.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Category</label>
                                      <select name="category" id="category" class="form-control select2-lib-dropdown-parameter_category "> <?php if(isset(request()->category)) { echo  '
                                        <option value="'.request()->category.'" Selected >'.request()->category.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Sub Category</label>
                                      <select name="sub_category" id="sub_category" class="form-control select2-lib-dropdown-parameter_sub_category "> <?php if(isset(request()->sub_category)) { echo  '
                                        <option value="'.request()->sub_category.'" Selected >'.request()->sub_category.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Description</label>
                                      <input name="description" type="text" autocomplete="off" placeholder="Description" class="form-control" value="{{ request()->description }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Status</label>
                                      <select name="status" id="status" class="form-control  ">
                                        <option value="">Select Status</option>
                                        <option value="Y" @if(request()->status == 'Y') Selected @endif> Y</option>
                                        <option value="N" @if(request()->status == 'N') Selected @endif> N</option>
                                     </select>
                                      </select>
                                  </div>
                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">

                        <div class="form-group pull-left showing" style="margin-top:37px;">
                            <p class="text-sm text-gray-700 leading-5">
                                <span class="font-medium">{{ $parameter_data->firstItem() }}</span>
                               {!! __('to') !!}
                                <span class="font-medium">{{ $parameter_data->total() }}</span>
                                {!! __('results') !!}
                            </p>
                        </div>

                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                 <th>S No.</th>
                                 <th>Parameter Type</th>
                                 <th>Category</th>
                                 <th>Sub Category</th>
                                 <th>Description</th>
                                 <th>Value</th>
                                 <th>Status</th>
                                 <th>User (Modified)</th>
                                 <th>Date (Modified)</th>
                              </tr>
                           </thead>
                           <tbody >
                              @if (count($parameter_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($parameter_data as $key => $data)
                              <tr style="text-align:center;">
                                   <td>{{ $parameter_data->firstItem() +  $key }}</td>
                                   <td> <b>{{ $data->PTyp }}</b> ({{ $data->parameter_description }})</td>
                                   <td>{{ $data->PMCd }}</td>
                                   <td>{{ $data->PSCd }}</td>
                                   <td>{{ $data->PDesc }}</td>
                                   <td>{{ $data->PValue }}</td>
                                   <td>{{ $data->PValidYn }}</td>
                                   <td>{{ $data->ModUsr  }}</td>
                                   <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                              </tr>
                              @endforeach
                              @else
                              <tr>
                                 <td colspan="11" class="text-center text-danger">
                                    <h3><b>No Record Found</b></h3>
                                 </td>
                              </tr>
                              @endif
                           </tbody>
                        </table>
                        <div class="btn-group">
                           <button type="button" onclick="changenumber(20)" class="btn btn-default btn-sm btn-paging @if(request()->show == 20 || empty(request()->show )) btn-info @endif " data-value="20">20</button>
                           <button type="button" onclick="changenumber(50)" class="btn btn-default btn-sm btn-paging @if(request()->show == 50) btn-info @endif " data-value="50">50</button>
                           <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                         </div>
                         <div class="pagination pull-right">
                         {{ $parameter_data->links('vendor.pagination.bootstrap-4') }}
                         </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@include('admin.emporer.emporer_script')


<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}




function parameter_type_select2() {
    $(".select2-lib-dropdown-parameter_type").select2({
      placeholder: "Parameter Type",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-parameter_type',
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

function parameter_category_select2() {
    $(".select2-lib-dropdown-parameter_category").select2({
      placeholder: "Category",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-parameter_category',
            parameter_type: $("#type").val(),
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


function parameter_sub_category_select2() {
    $(".select2-lib-dropdown-parameter_sub_category").select2({
      placeholder: "Sub Category",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-parameter_sub_category',
            parameter_type: $("#type").val(),
            category: $("#category").val(),
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
  parameter_type_select2();
  parameter_category_select2();
  parameter_sub_category_select2();
  // zoomImages()
});






</script>

@endsection
