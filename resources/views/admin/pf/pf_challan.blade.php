@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/pf/pf_challan?show='.request()->show.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year);
@endphp
    <div class="main-panel">
        <div class="content">
            @includeif('admin.pf.filters')
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
                                               <th  >S.NO.</th>
                                               <th  >UAN</th>
                                               <th  >Member Name</th>
                                               <th  >Gross Wages</th>
                                               <th  >EPF Wages</th>
                                               <th >EPS Wages</th>
                                               <th >EDLI Wages</th>
                                               <th >EPF Contribution remitted</th>
                                               <th  >EPS Contribution remitted</th>
                                               <th >EPF and EPS Diff remitted</th>
                                               <th  >NCP Days</th>
                                               <th  >Refund of Advances</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                              @if (count($pf_challan_data) > 0)
                                           @php $count = 1 @endphp
                                            @foreach($pf_challan_data as $key => $data)
                                                <tr  style="text-align: center;">
                                                <td>{{ $pf_challan_data->firstItem() +  $key  }}</td>
                                                <td   >{{ "".$data->uan_number}}</td>
                                                <td style="text-align: left;">{{ $data->employee_name}}</td>
                                                <td>{{ $data->gross_pay}}</td>
                                                <td>{{ $data->amount1}}</td>
                                                <td>{{ $data->amount2 }}</td>
                                                <td>{{ $data->amount3}}</td>
                                                <td>{{ $data->pf}}</td>
                                                <td>{{ $data->eps}}</td>
                                                <td>{{ $data->epsepf}}</td>
                                                <td>{{ $data->leave_without_pay}}</td>
                                                <td >0</td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
                                    {{ $pf_challan_data->links('vendor.pagination.bootstrap-4') }}
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
    // $('#attendnceform').on('change', function() {
    // $("#show_hidden_input").attr("value", $('#attendnceform').val());
    // $("#filter_form").trigger("submit");
    //     //   this.form.submit()
    // });
    $('#employee_name').on('change', function() {
        if($('#employee_name').val().length >= 1) {
            $.ajax({
                url: '{{  url("search-employee") }}',
                cache: false,
                type: "get",
                data: {employee_name : $('#employee_name').val()},
                dataType: "json",
                success: function(html){
                    $("#results").append(html);
                    },
                error: function(html){
                    $("#results").append(html);
                    },
            });
        }
    });
    $('#example').select2({
        placeholder: 'Select a month'
    });
</script>
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
