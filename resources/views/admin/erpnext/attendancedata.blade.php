@extends('admin.layout.app')

@section('content')
@php
$url = url('attendnce-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data);
$showurl = url('attendance?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data);
// $inmissingurl = url('in-missing-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company);
// $oturl = url('ot-data-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company);
 //dd($oturl);
@endphp
    <div class="main-panel">
        <div class="content">
            @includeif('admin.erpnext.filters')
            {{-- <div class="container-fluid card">
                <div class="row">
                    <div class="col-md-6">
                        <form method="get" action="{{ $missingurl }}">
                            <div class="row">

                                <div class="col-md-7">
                                    <input type="hidden" name="employee_code" value="{{ request()->employee_code }}">
                                    <input type="hidden" name="employee_name" value="{{ request()->employee_name }}">
                                    <input type="hidden" name="start_date" value="{{ request()->start_date }}">
                                    <input type="hidden" name="end_date" value="{{ request()->end_date }}">
                                    <input type="hidden" name="status" value="{{ request()->status }}">
                                    <input type="hidden" name="shift" value="{{ request()->shift }}">
                                    <input type="hidden" name="company" value="{{ request()->company }}">
                                    <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                                        <input placeholder="Employee Code" type="date" name="missing_date" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="footer-button">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o" style="font-size:24px;color:#000"></i> Export OUt Missing Data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">url('/attendance')
            </div> --}}
            <div class="row"  style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                            <th>S.No.</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Shift Type</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($attendnces) > 0)
                                           @php $count = 1 @endphp
                                            @foreach($attendnces as $key => $attendnce)
                                                <tr style="text-align: center;">
                                                    <td>{{ $attendnces->firstItem() + $key }}</td>
                                                    <td>{{ $attendnce->employee}}</td>
                                                    <td>{{ $attendnce->employee_name }}</td>
                                                    <td>{{ $attendnce->shift}}</td>
                                                    <td>{{ $attendnce->company}}</td>
                                                    <td>{{ $attendnce->status}}</td>
                                                    <td>{{ date('d-m-Y',strtotime($attendnce->attendance_date)) }}</td>
                                                    <td>
                                                        <a href="https://erp.pinkcityindia.com/app/attendance/{{ $attendnce->name }}" class="btn btn-success" target="_blanck"><i class="fa fa-eye"></i></a>
                                                        {{-- <a href="{{ url('attendance-checkin-checkout/?employee_code='.$attendnce->employee.'&date='.date('d-m-Y',strtotime($attendnce->attendance_date))) }}" class="btn btn-success" target="_blanck">View</a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="10" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
                                    {{ $attendnces->links('vendor.pagination.bootstrap-4') }}
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
