@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/esi/esi_statement?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year);
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
                            <form method="GET" id="show_form" action="{{$showurl}}" >

                                    </form>
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                            <th>SI No.</th>
                                            <th>ESI NO.</th>
                                            <th>Name of Member</th>
                                            <th>Days Worked</th>
                                            <th>ESI Earnings</th>
                                            <th>ESI Contribution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($esi_statement_data) > 0)
                                           @php $count = 1 @endphp
                                            @foreach($esi_statement_data as $key => $data)
                                                <tr  style="text-align: center;" >
                                                    <td >{{ $esi_statement_data->firstItem() +  $key }}</td>
                                                    <td >{{ $data->esic_no}}</td>
                                                    <td style="text-align: left;">{{ $data->employee_name}}</td>
                                                    <td >{{ $data->payment_days}}</td>
                                                    <td >{{ $data->esi_earnings}}</td>
                                                    <td  >{{ $data->esi_contribution}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="6" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                           </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="btn-group">
						            <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
						            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
						            <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                               </div>

                                  <!-- <select id="attendnceform" name="datatable_length" style="width: 10%; float: left;" aria-controls="datatable" class="form-control input-sm ">
                                   <option value="">All</option>
                                  <option value="10" @if(request()->show == 10) selected @endif>10</option>
                                  <option value="100" @if(request()->show == 100) selected @endif>100</option>
                                  <option value="500" @if(request()->show == 500) selected @endif>500</option>
                                </select> -->

                                <div class="pagination pull-right" style="float">
                                    {{ $esi_statement_data->links('vendor.pagination.bootstrap-4') }}
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
// $('#attendnceform').on('change', function() {
//     $("#show_hidden_input").attr("value", $('#attendnceform').val());
//     $("#filter_form").trigger("submit");
// });
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
