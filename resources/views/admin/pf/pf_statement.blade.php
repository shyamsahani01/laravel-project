@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/pf/pf_statement?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name);
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
                                          <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                             <th>S No.<br> (1)</th>
                                             <th>UAN<br> (2)</th>
                                             <th>Name of Member<br> (3)</th>
                                             <th>Employee PF Earnings<br> (4)</th>
                                             <th>Contribution EPF<br> (5)</th>
                                             <th>Employer EPF Difference<br> (6)</th>
                                             <th>Contribution Pension 8.33%<br> (7)</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @if (count($pf_statement_data) > 0)
                                          @php $count = 1 @endphp
                                          @foreach($pf_statement_data as $key => $data)
                                          <tr>
                                             <td  style="text-align: center;">{{ $pf_statement_data->firstItem() +  $key }}</td>
                                             <td  style="text-align: center;" >{{ round($data->uan_number) . "" }}</td>
                                             <td>{{ $data->employee_name}}</td>
                                             <td style="text-align: center;">{{ $data->amount}}</td>
                                             <td style="text-align: center;">{{ $data->pf}}</td>
                                             <td style="text-align: center;" >{{ $data->epsepf}}</td>
                                             <td style="text-align: center;">{{ $data->eps}}</td>
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
                                       <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                                       <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                                       <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                                    </div>
                                    <div class="pagination pull-right">
                                       {{ $pf_statement_data->links('vendor.pagination.bootstrap-4') }}
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
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
