@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/hr/bank_sheet/hdfc_bank?show='.request()->show.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&year='.request()->year);
@endphp

    <div class="main-panel">
        <div class="content">
            @includeif('admin.payroll.bank_sheet.filters')
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
                                               <th>Employee ID</th>
                                               <th>Account</th>
                                               <th>Credit</th>
                                               <th>Amount</th>
                                               <th>Narration</th>
                                               <th>Account,Credit,Amount,Narration</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                        @if (count($bank_sheet_data) > 0)
                                           @php $count = 1; @endphp
                                            @foreach($bank_sheet_data as $key => $data)
                                                <tr  style="text-align: center;">
                                                  <td>{{ $bank_sheet_data->firstItem() +  $key  }}</td>
                                                  <!-- <td>{{ $data->employee }}</td> -->
                                                  <td>{{ $data->attendance_device_id }}</td>
                                                  <td>{{ $data->bank_ac_no}}</td>
                                                  <td>{{ 'C' }}</td>
                                                  <td>{{ round($data->net_pay) }}</td>
                                                  <td>{{ $data->employee_name }}</td>
                                                  <td>{{ $data->bank_ac_no . ",C," . round($data->net_pay) ."," . $data->employee_name }}</td>
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
                                    {{ $bank_sheet_data->links('vendor.pagination.bootstrap-4') }}
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
