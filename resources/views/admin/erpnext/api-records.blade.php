@extends('admin.layout.app')

@section('content')
<style>
.FixedHeightContainer
{
  height: 500px;
  padding:3px;
  background:#000;
}
.Content
{
  height:500px;
 overflow:auto;
    background:#fff;
}
</style>

<div class="main-panel">
        <div class="content">
            @includeif('admin.erpnext.filters')

            <div class="row"  style="margin-top: 10px;">

                <div class="col-md-12">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <!-- <div class="card-header card-header-primary">

                            <form method="POST" action="{{ route('Essl.Export') }}">
                              @csrf
                               <input type="hidden" name="sdate" value="{{ request()->start_date }}">
                               <input type="hidden" name="edate" value="{{ request()->end_date }}">
                               <input type="hidden" name="ename" id="ename" value=""> -->
                               <!-- <a href="{{ url('essl_erp') }}" class="btn btn-success btn pull-right" style="margin-top:-43px;"><i class="fa fa-refresh"></i> Refresh Data In ERP</a>   -->
                               <!-- <button type="submit" class="btn btn-success btn pull-right" id="importdata"><i class="fa fa-file-excel-o"></i></button>
                            </form>
                        </div> -->
                        <div class="card-body">
                            <div class="table-responsive">

                                <div class="panel-body">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employeedata as $employee)
                                            <tr data-toggle="collapse" data-target="#demo{{ $employee->employee }}" class="accordion-toggle">
                                                <td colspan="7">
                                                    <button class="btn btn-default btn-xs">{{ $employee->employee_name }}</button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="12" class="hiddenRow">
                                                    <div class="accordian-body collapse" id="demo{{ $employee->employee }}">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Employee Code</th>
                                                                <th>Shift Type</th>
                                                                <th>Branch</th>
                                                                <th>Date</th>
                                                                <th>Check In</th>
                                                                <th>Check Out</th>
                                                                 <th>Total Working Hour</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               {{ request()->start_date }}
                                                                @foreach($records as $res)
                                                                  @php
                                                                   $res = (array) $res;
                                                                  @endphp
                                                                 @if(request()->start_date <= date('Y-m-d',strtotime($res['intime'])))
                                                                   @if($res['userid'] == $employee->employee_number)
                                                                    @php
                                                                        $timedate = substr($res['intime'], 0, strpos($res['intime'], '.'));
                                                                        $outdate = substr($res['outime'], 0, strpos($res['outime'], '.'));
                                                                        $intime  = date('H:i:s',strtotime($timedate));
                                                                        $outtime  = !empty($res['outime']) ? date('H:i:s',strtotime($outdate)) : '';
                                                                        $start_date = new DateTime($intime);
                                                                        $end_date = new DateTime($outtime);
                                                                        $interval = $start_date->diff($end_date);
                                                                        $hours   = $interval->format('%h');
                                                                        $minut   = $interval->format('%i');
                                                                     @endphp
                                                                     <tr data-toggle="collapse" class="accordion-toggle" data-target="#demo10">
                                                                        <td class="">{{  $employee->employee }}</td>
                                                                        <td >{{  $employee->default_shift }}</td>
                                                                        <td>{{  $employee->branch }}</td>
                                                                        <td>{{ date('d-m-Y',strtotime($res['intime'])) }}</td>
                                                                        <td>{{ $intime }}</td>
                                                                        <td>{{ $outtime }}</td>
                                                                        <td>@if(!empty($outtime)) {{ $hours }} Hours {{ $minut }} Minuts @endif</td>
                                                                    </tr>
                                                                    @endif
                                                                  @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination pull-right">
                                      {{ $employeedata->links('vendor.pagination.essl-pagnation') }}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$("#employee_name").keyup(function(){
    var value = $( this ).val();
    $('#ename').val(value);
});

$('#submitform').submit(function(e){
       e.preventDefault();
        var name = $("input[name=employee_name]").val();
        var startdate = $("input[name=start_date]").val();
        var enddate = $("input[name=end_date]").val();
        alert('submit');
         // $.ajax({
        //    type:'POST',
        //    url:"{{ route('Essl.Export') }}",
        //    data:{name:name, startdate:startdate, enddate:enddate},
        //    success:function(data){
        //       alert(data.success);
        //    }
        // });
});
</script>
<script>
   function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
