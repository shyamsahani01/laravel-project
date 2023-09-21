@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&design_start_date='.request()->design_start_date;
$str .= '&design_end_date='.request()->design_end_date;
$str .= '&category='.request()->category;
$str .= '&description='.request()->description;
$str .= '&design_code='.request()->design_code;
$showurl = url("/emporer/design/list?$str");
@endphp

@php
use App\Library\WebHelper;
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/design/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/design/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Design Date - From</label>
                                      <input name="design_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->design_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Design Date - To</label>
                                      <input name="design_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->design_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Category</label>
                                      <select name="category" id="category" class="form-control select2-lib-dropdown-category "> <?php if(isset(request()->category)) { echo  '
                                        <option value="'.request()->category.'" Selected >'.request()->category.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Description</label>
                                      <input name="description" type="text" autocomplete="off" placeholder="Description" class="form-control" value="{{ request()->description }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Design Code</label>
                                      <input name="design_code" type="text" autocomplete="off" placeholder="Design Code" class="form-control" value="{{ request()->design_code }}">
                                  </div>


                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                 <th>S No.</th>
                                 <th>Design Code</th>
                                 <th>Design Image</th>
                                 <th>Description</th>
                                 <th>Design Category</th>
                                 <th>Karat</th>
                                 <th>Design By</th>
                                 <th>Design Date</th>
                              </tr>
                           </thead>
                           <tbody >
                              @if (count($design_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($design_data as $key => $data)
                              <tr>
                                 <td  style="text-align: center;">{{ $design_data->firstItem() +  $key }}</td>
                                 <td  style="text-align: center;" ><a href="/emporer/design/designDetails?design_code={{ $data->DmCd}}"  style="color: green;">{{ $data->DmCd }}</a></td>
                                 <td style="text-align: center;" >
                                   @if (WebHelper::get_emr_design_file_location($data->DmCtg, $data->DmTcTyp, $data->DmCd) != "")
                                   <img id='design-{{ $data->DmCd  }}' onclick=displayImage('{{ $data->DmCd  }}') src='{{ WebHelper::get_emr_design_file_location($data->DmCtg, $data->DmTcTyp, $data->DmCd)  }}'  width='150' height='150'>
                                   @endif
                                  </td>
                                   <td  style="text-align: center;" >{{ $data->DmDesc }}</td>
                                   <td  style="text-align: center;" >{{ $data->DmCtg }}</td>
                                   <td  style="text-align: center;" >{{ $data->DmKt }}</td>
                                   <td  style="text-align: center;" >{{ $data->DmDsgBy }}</td>
                                   <td  style="text-align: center;" >{{ date("D, d-m-Y", strtotime($data->DmDsgDt)) }}</td>
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
                         {{ $design_data->links('vendor.pagination.bootstrap-4') }}
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




function category_select2() {
    $(".select2-lib-dropdown-category").select2({
      placeholder: "Category",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-design_category',
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
  category_select2();
  // zoomImages()
});






</script>

@endsection
