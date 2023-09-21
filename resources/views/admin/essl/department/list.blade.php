@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/essl/essl_department/list?show='.request()->show);
@endphp

    <div class="main-panel">
        <div class="content">
            @includeif('admin.essl.filters')
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="clearfix"></div>
                        <div class="row">
                     <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                           <div class="x_content">
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="card-box table-responsive">

                                       <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                          <thead>
                                             <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                               <th>S.NO.</th>
                                               <th>Department</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                        @if (count($department_data) > 0)
                                           @php $count = 1; @endphp
                                            @foreach($department_data as $key => $data)
                                                <tr  style="text-align: center;">
                                                  <td>{{ $department_data->firstItem() +  $key  }}</td>
                                                  <td>{{ $data->DepartmentFName }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="7" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                           </tr>
                                        @endif
                                    </tbody>
                                 </table>
                                 <div class="btn-group">
            						            <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
            						            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
            						            <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                                  </div>
                                    <div class="pagination pull-right">
                                    {{ $department_data->links('vendor.pagination.bootstrap-4') }}
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
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer-scripts')
<script>

</script>
<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
