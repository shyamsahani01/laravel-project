@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/esi/esi_challan?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year);
@endphp
    <div class="main-panel">
        <div class="content">
            @includeif('admin.esi.filters')
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="card">
                    <div class="clearfix"></div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                        <th>S.No.</th>
                                        <th>IP Number <p style="color: red;"> (10 Digits)</p></th>
                                        <th>IP Name <p style="color: red;"> (Only alphabets and space)</p></th>
                                        <th><p>No of Days for which wages paid payable during the month</p></th>
                                        <th><p>Total Monthly Wages</p></th>
                                        <th><p>Reason Code for Zero workings days(numeric only;provide 0 for all other reasons- Click on the link for referencel)</p></th>
                                        <th>Last Working Day <p style="color: red;">(Format DD/MM/YYYY or DD-MM-YYYY)</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($esi_challan_data) > 0)
                                           @php $count = 1; $last_working_day = "";  @endphp
                                            @foreach($esi_challan_data as $key => $data)
                                            @php $last_working_day = "";  @endphp
                                            @if ( strlen($data->last_working_day) >= 6)
                                            @php $last_working_day = date('d-m-Y', strtotime($data->last_working_day));  @endphp
                                            @endif
                                                <tr style="text-align: center;">
                                                    <td>{{ $esi_challan_data->firstItem() +  $key }}</td>
                                                    <td>{{ $data->esic_no}}</td>
                                                    <td>{{ $data->employee_name}}</td>
                                                    <td>{{ $data->payment_days}}</td>
                                                    <td>{{ $data->esi_earnings}}</td>
                                                    <td>{{ $data->workings_day1}}</td>
                                                    <td> {{ $last_working_day }} </td>
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
                                    {{ $esi_challan_data->links('vendor.pagination.bootstrap-4') }}
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
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
